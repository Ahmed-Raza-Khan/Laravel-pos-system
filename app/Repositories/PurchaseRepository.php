<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Support\IndexTable;
use Illuminate\Support\Facades\DB;
use App\Services\InventoryService;
use App\Interfaces\PurchaseRepositoryInterface;
use App\Services\Inventory\WarehouseStockService;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function __construct(
        protected InventoryService $inventoryService,
        protected WarehouseStockService $warehouseStockService
    ) {}

    public function getAll()
    {
        $query = Purchase::with('supplier','warehouse');

        return IndexTable::apply(
            $query,
            ['invoice_no', 'supplier.name', 'purchase_date', 'total_amount', 'status'],
            'purchase_date'
        );
    }

    public function store(array $data)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::create([
                'invoice_no' => 'PUR-' . time(),
                'supplier_id' => $data['supplier_id'],
                'warehouse_id' => $data['warehouse_id'],
                'purchase_date' => $data['purchase_date'],
                'total_amount' => 0,
                'note' => $data['note'] ?? null,
                'status' => 'pending',
            ]);

            $total = $this->syncItems($purchase, $data, false);

            $purchase->update(['total_amount' => $total]);

            DB::commit();

            return $purchase;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function approve(int $id): Purchase
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::with('items')->findOrFail($id);

            if ($purchase->status === 'approved') {
                throw new \Exception('Purchase is already approved.');
            }

            if ($purchase->status === 'cancelled') {
                throw new \Exception('Cancelled purchases cannot be approved.');
            }

            foreach ($purchase->items as $item) {
                $this->addStockForItem($item, "Stock added from approved purchase #{$purchase->invoice_no}.");
                $this->warehouseStockService->increase(
                    $purchase->warehouse_id,
                    $item->product_id,
                    $item->quantity
                );
            }

            $purchase->update(['status' => 'approved']);
            DB::commit();

            return $purchase->fresh(['supplier', 'items.product']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function cancel(int $id): Purchase
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::with('items')->findOrFail($id);

            if ($purchase->status === 'cancelled') {
                throw new \Exception('Purchase is already cancelled.');
            }

            if ($purchase->status === 'approved') {
                foreach ($purchase->items as $item) {
                    $this->removeStockForItem($item, "Stock reversed from cancelled purchase #{$purchase->invoice_no}.");
                    $this->warehouseStockService->decrease(
                        $purchase->warehouse_id,
                        $item->product_id,
                        $item->quantity
                    );
                }
            }

            $purchase->update(['status' => 'cancelled']);
            DB::commit();

            return $purchase->fresh(['supplier', 'items.product']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findById($id)
    {
        return Purchase::with('items.product', 'supplier', 'warehouse')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::with('items')->findOrFail($id);
            if ($purchase->status === 'cancelled') {
                throw new \Exception('Cancelled purchases cannot be edited.');
            }

            if ($purchase->status === 'approved') {
                foreach ($purchase->items as $item) {
                    $this->removeStockForItem($item, 'Stock reversed before purchase update.');
                    $this->warehouseStockService->decrease(
                        $purchase->warehouse_id,
                        $item->product_id,
                        $item->quantity
                    );
                }
            }
            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            $wasApproved = $purchase->status === 'approved';
            $total = $this->syncItems($purchase, $data, $wasApproved);

            $purchase->update([
                'supplier_id' => $data['supplier_id'],
                'warehouse_id' => $data['warehouse_id'],
                'purchase_date' => $data['purchase_date'],
                'total_amount' => $total,
                'note' => $data['note'] ?? null,
            ]);
            DB::commit();

            return $purchase->fresh(['supplier', 'items.product']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::with('items')->findOrFail($id);
            if ($purchase->status === 'approved') {
                foreach ($purchase->items as $item) {
                    $this->removeStockForItem($item, 'Stock reversed from deleted purchase.');
                    $this->warehouseStockService->decrease(
                        $purchase->warehouse_id,
                        $item->product_id,
                        $item->quantity
                    );
                }
            }

            PurchaseItem::where('purchase_id', $purchase->id)->delete();
            $purchase->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function syncItems(Purchase $purchase, array $data, bool $applyStock): float
    {
        $total = 0;
        foreach ($data['product_id'] as $key => $productId) {
            $qty = $data['quantity'][$key];
            $price = $data['purchase_price'][$key];
            $subtotal = $qty * $price;

            $item = PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $productId,
                'quantity' => $qty,
                'purchase_price' => $price,
                'subtotal' => $subtotal,
            ]);

            if ($applyStock) {
                $this->addStockForItem($item, 'Stock added from purchase update.');
            }

            $total += $subtotal;
        }

        return $total;
    }

    protected function addStockForItem(PurchaseItem $item, string $note): void
    {
        $product = Product::findOrFail($item->product_id);
        $before = $product->stock;
        $product->stock += $item->quantity;
        $product->save();
        $product->refresh();

        $this->inventoryService->log(
            $product,
            'purchase',
            $item->quantity,
            $before,
            $product->stock,
            $note
        );
    }

    protected function removeStockForItem(PurchaseItem $item, string $note): void
    {
        $product = Product::find($item->product_id);
        if (! $product) {
            return;
        }

        $before = $product->stock;
        $product->stock = max(0, $product->stock - $item->quantity);
        $product->save();
        $product->refresh();

        $this->inventoryService->log(
            $product,
            'adjustment',
            $item->quantity,
            $before,
            $product->stock,
            $note
        );
    }
}

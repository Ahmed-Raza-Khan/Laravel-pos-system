<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use App\Interfaces\PurchaseRepositoryInterface;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function getAll()
    {
        return Purchase::with('supplier')->latest()->paginate(10);
    }

    public function store(array $data)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::create([
                'invoice_no' => 'INV-' . time(),
                'supplier_id' => $data['supplier_id'],
                'purchase_date' => $data['purchase_date'],
                'total_amount' => 0,
                'note' => $data['note'] ?? null,
                'status' => 1,
            ]);

            $total = 0;

            foreach ($data['product_id'] as $key => $productId) {
                $qty = $data['quantity'][$key];
                $price = $data['purchase_price'][$key];
                $subtotal = $qty * $price;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'purchase_price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $product = Product::findOrFail($productId);
                $product->stock += $qty;
                $product->save();
                $total += $subtotal;
            }

            $purchase->update([
                'total_amount' => $total
            ]);

            DB::commit();
            return $purchase;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findById($id)
    {
        return Purchase::with('items.product')
            ->findOrFail($id);
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::with('items')
                ->findOrFail($id);

            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }

            PurchaseItem::where('purchase_id', $purchase->id)
                ->delete();
            $total = 0;

            foreach ($data['product_id'] as $key => $productId) {
                $qty = $data['quantity'][$key];
                $price = $data['purchase_price'][$key];
                $subtotal = $qty * $price;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'purchase_price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $product = Product::findOrFail($productId);
                $product->stock += $qty;
                $product->save();
                $total += $subtotal;
            }

            $purchase->update([
                'supplier_id' => $data['supplier_id'],
                'purchase_date' => $data['purchase_date'],
                'total_amount' => $total,
                'note' => $data['note'] ?? null,
            ]);

            DB::commit();

            return $purchase;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::with('items')
                ->findOrFail($id);

            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }

            PurchaseItem::where('purchase_id', $purchase->id)
                ->delete();

            $purchase->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
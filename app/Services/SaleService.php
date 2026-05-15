<?php

namespace App\Services;

use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SaleRepositoryInterface;

class SaleService
{
    protected $saleRepository;

    public function __construct(
        SaleRepositoryInterface $saleRepository
    ) {
        $this->saleRepository = $saleRepository;
    }

    /**
     * Create Sale
     */
    public function createSale(array $data)
    {
        DB::beginTransaction();

        try {

            $cart = session()->get('cart', []);

            if (empty($cart)) {
                throw new \Exception('Cart is empty.');
            }

            $subtotal = $this->calculateSubtotal($cart);

            $discountAmount = $this->calculateDiscount(
                $subtotal,
                $data['discount_type'] ?? null,
                $data['discount_value'] ?? 0
            );

            $afterDiscount = $subtotal - $discountAmount;

            $taxAmount = ($afterDiscount * $data['tax_percentage']) / 100;

            $grandTotal = $afterDiscount + $taxAmount;

            $paidAmount = $data['paid_amount'];

            $dueAmount = $grandTotal - $paidAmount;

            $sale = $this->saleRepository->create([
                'invoice_no'      => $this->saleRepository->generateInvoiceNumber(),
                'customer_id'     => $data['customer_id'] ?? null,
                'subtotal'        => $subtotal,
                'discount_type'   => $data['discount_type'] ?? null,
                'discount_value'  => $data['discount_value'] ?? 0,
                'discount_amount' => $discountAmount,
                'tax_percentage'  => $data['tax_percentage'],
                'tax_amount'      => $taxAmount,
                'grand_total'     => $grandTotal,
                'paid_amount'     => $paidAmount,
                'due_amount'      => $dueAmount,
                'payment_method'  => $data['payment_method'],
                'sale_date'       => now(),
                'created_by'      => auth()->id(),
                'notes'           => $data['notes'] ?? null,
            ]);

            foreach ($cart as $item) {

                SaleItem::create([
                    'sale_id'   => $sale->id,
                    'product_id'=> $item['product_id'],
                    'quantity'  => $item['qty'],
                    'price'     => $item['price'],
                    'total'     => $item['total'],
                ]);

                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['qty']) {
                    throw new \Exception(
                        "{$product->name} stock not available."
                    );
                }

                $product->decrement('stock', $item['qty']);
            }

            session()->forget('cart');

            DB::commit();

            return $sale;

        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Calculate Cart Subtotal
     */
    public function calculateSubtotal($cart)
    {
        return collect($cart)->sum('total');
    }

    /**
     * Calculate Discount
     */
    public function calculateDiscount(
        $subtotal,
        $type,
        $value
    ) {
        if (!$type || !$value) {
            return 0;
        }

        if ($type === 'fixed') {
            return $value;
        }

        if ($type === 'percentage') {
            return ($subtotal * $value) / 100;
        }

        return 0;
    }
}
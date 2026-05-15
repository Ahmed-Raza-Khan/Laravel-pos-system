<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\SaleService;
use App\Http\Requests\StoreSaleRequest;
use App\Interfaces\SaleRepositoryInterface;

class SaleController extends Controller
{
    protected $saleRepository;
    protected $saleService;

    public function __construct(
        SaleRepositoryInterface $saleRepository,
        SaleService $saleService
    ) {
        $this->saleRepository = $saleRepository;
        $this->saleService = $saleService;
    }

    /**
     * Sales List
     */
    public function index()
    {
        $sales = $this->saleRepository->getAll();

        return view('sales.index', compact('sales'));
    }

    /**
     * POS Screen
     */
    public function create(Request $request)
    {
        $products = Product::when($request->search, function ($query) use ($request) {

            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%')
                ->orWhere('barcode', 'like', '%' . $request->search . '%');

        })->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        $customers = Customer::latest()->get();

        $cart = session()->get('cart', []);

        return view('sales.create', compact(
            'products',
            'customers',
            'cart'
        ));
    }

    /**
     * Add Product To Cart
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock < 1) {
            return back()->with('error', 'Out of stock.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            if ($product->stock <= $cart[$id]['qty']) {
                return back()->with(
                    'error',
                    'Stock limit exceeded.'
                );
            }

            $cart[$id]['qty']++;

            $cart[$id]['total'] =
                $cart[$id]['qty'] *
                $cart[$id]['price'];

        } else {

            $cart[$id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->sale_price,
                'qty'        => 1,
                'total'      => $product->sale_price,
            ];
        }

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Product added to cart.'
        );
    }

    /**
     * Update Cart Quantity
     */
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back();
        }

        $product = Product::findOrFail($id);

        $qty = (int) $request->qty;

        if ($qty > $product->stock) {
            return back()->with(
                'error',
                'Stock not available.'
            );
        }

        $cart[$id]['qty'] = $qty;

        $cart[$id]['total'] =
            $cart[$id]['price'] * $qty;

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Cart updated.'
        );
    }

    /**
     * Remove Item
     */
    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            unset($cart[$id]);

            session()->put('cart', $cart);
        }

        return back()->with(
            'success',
            'Item removed.'
        );
    }

    /**
     * Clear Cart
     */
    public function clearCart()
    {
        session()->forget('cart');

        return back()->with(
            'success',
            'Cart cleared.'
        );
    }

    /**
     * Complete Sale
     */
    public function store(StoreSaleRequest $request)
    {
        try {

            $sale = $this->saleService
                ->createSale($request->validated());

            return redirect()
                ->route('sales.show', $sale->id)
                ->with('success', 'Sale completed.');

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    /**
     * Invoice
     */
    public function show($id)
    {
        $sale = $this->saleRepository->findById($id);

        return view('sales.show', compact('sale'));
    }
}

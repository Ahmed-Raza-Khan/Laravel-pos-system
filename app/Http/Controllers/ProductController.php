<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrdouctRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'status' => 'required'
        ]);

        $data['slug'] = Str::slug($request->name);

        $this->productService->createProduct($data);

        return redirect()->route('products.index')->with('success', 'Product created');
    }

    public function edit($id)
    {
        $product = $this->productService->getProduct($id);
        $categories = Category::where('status', 1)->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'name' => 'required|string',
            'price' => 'required',
            'stock' => 'required',
            'status' => 'required',
        ]);

        $data['slug'] = Str::slug($request->name);

        $this->productService->updateProduct($id, $data);

        return redirect()->route('products.index')->with('success', 'Product updated');
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);

        return redirect()->route('products.index')->with('success', 'Product deleted');
    }
}
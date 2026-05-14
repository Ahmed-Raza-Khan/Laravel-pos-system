<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Services\ProductService;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

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
        $brands = Brand::where('status', 1)->get();

        return view('products.create', ['categories' => Category::all(),'brands' => Brand::all(),]);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productService->createProduct($data);

        return redirect()->route('products.index')
            ->with('success', 'Product created');
    }

    public function edit($id)
    {
        $product = $this->productService->getProduct($id);
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('products.edit', ['product' => Product::findOrFail($id),'categories' => Category::all(),'brands' => Brand::all(),]);
    }


    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $product = $this->productService->getProduct($id);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $data['image'] = $request->file('image')
            ->store('products', 'public');
        }

        $this->productService->updateProduct($id, $data);

        return redirect()->route('products.index')->with('success', 'Product updated sucessfully.');
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);

        return redirect()->route('products.index')
            ->with('success', 'Product deleted');
    }
}
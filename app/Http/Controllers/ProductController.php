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
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function show($id)
    {
        $product = Product::with(['category', 'brand'])
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function barcode($id)
    {
        $product = Product::findOrFail($id);

        return view('products.barcode', compact('product'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('products.create', compact('categories', 'brands'));
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

        return view('products.edit', compact('product', 'categories', 'brands'));
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

    public function export(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['name', 'sku', 'barcode', 'category_id', 'brand_id', 'purchase_price', 'sale_price', 'stock', 'description', 'status']);

            Product::with(['category', 'brand'])->orderBy('name')->chunk(200, function ($products) use ($handle) {
                foreach ($products as $product) {
                    fputcsv($handle, [
                        $product->name,
                        $product->sku,
                        $product->barcode,
                        $product->category_id,
                        $product->brand_id,
                        $product->purchase_price,
                        $product->sale_price,
                        $product->stock,
                        $product->description,
                        $product->status,
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    public function importForm()
    {
        return view('products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');
        $header = fgetcsv($file);
        $imported = 0;

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 8) {
                continue;
            }

            $data = array_combine($header, $row) ?: [
                'name' => $row[0] ?? null,
                'sku' => $row[1] ?? null,
                'barcode' => $row[2] ?? null,
                'category_id' => $row[3] ?? 1,
                'brand_id' => $row[4] ?? null,
                'purchase_price' => $row[5] ?? 0,
                'sale_price' => $row[6] ?? 0,
                'stock' => $row[7] ?? 0,
            ];

            if (empty($data['name'])) {
                continue;
            }

            Product::updateOrCreate(
                ['sku' => $data['sku'] ?? Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'barcode' => $data['barcode'] ?? null,
                    'category_id' => $data['category_id'] ?: 1,
                    'brand_id' => $data['brand_id'] ?: null,
                    'purchase_price' => $data['purchase_price'] ?? 0,
                    'sale_price' => $data['sale_price'] ?? 0,
                    'stock' => $data['stock'] ?? 0,
                    'description' => $data['description'] ?? null,
                    'status' => $data['status'] ?? 1,
                ]
            );
            $imported++;
        }

        fclose($file);

        return redirect()->route('products.index')->with('success', "{$imported} products imported.");
    }
}
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
        $data['sku'] = $this->generateSku();
        $data['barcode'] = $data['barcode'] ?? $this->generateBarcode();

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
            fputcsv($handle, ['name', 'sku', 'barcode', 'category_id', 'brand_id', 'purchase_price', 'sale_price', 'total_stock', 'description', 'status']);

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
                        $product->total_stock,
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
        $skipped = [];

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 8) {
                continue;
            }

            $data = array_combine($header, $row);
            if (!$data || empty($data['name'])) {
                continue;
            }

            $slug = Str::slug($data['name']);
            $exists = Product::where('slug', $slug)
                ->orWhere('sku', $data['sku'] ?? '')
                ->orWhere('barcode', $data['barcode'] ?? '')->exists();

            if ($exists) {
                $skipped[] = $data['name'];
                continue;
            }

            Product::create([
                'name' => $data['name'],
                'slug' => $slug,
                'sku' => $data['sku'] ?? 'SKU-' . rand(10000, 99999),
                'barcode' => $data['barcode'] ?? 'BC-' . rand(1000000000, 9999999999),
                'category_id' => $data['category_id'] ?: 1,
                'brand_id' => $data['brand_id'] ?: null,
                'purchase_price' => $data['purchase_price'] ?? 0,
                'sale_price' => $data['sale_price'] ?? 0,
                // 'stock' => $data['stock'] ?? 0,
                'description' => $data['description'] ?? null,
                'status' => $data['status'] ?? 1,
            ]);

            $imported++;
        }

        fclose($file);
        $message = "{$imported} products imported successfully.";

        if (count($skipped)) {
            $message .= ' Skipped duplicate products: ' . implode(', ', $skipped);
        }

        return redirect()->route('products.index')->with('success', $message);
    }

    private function generateSku()
    {
        do {
            $sku = 'SKU-' . strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }

    private function generateBarcode()
    {
        do {
            $barcode = rand(100000000000, 999999999999);
        } while (Product::where('barcode', $barcode)->exists());

        return $barcode;
    }
}
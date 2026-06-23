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
        $updated = 0;
        $skipped = [];
        $errors = [];

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 8) {
                continue;
            }

            $data = array_combine($header, $row);
            if (!$data || empty($data['name'])) {
                continue;
            }

            $slug = Str::slug($data['name']);
            $sku = $data['sku'] ?? 'SKU-' . rand(10000, 99999);
            $barcode = $data['barcode'] ?? 'BC-' . rand(1000000000, 9999999999);

            // Check if product exists
            $existingProduct = Product::where('slug', $slug)
                ->orWhere('sku', $sku)
                ->orWhere('barcode', $barcode)
                ->first();

            if ($existingProduct) {
                $skipped[] = $data['name'] . ' (SKU: ' . $existingProduct->sku . ')';
                continue;
            }

            try {
                $product = Product::create([
                    'name' => $data['name'],
                    'slug' => $slug,
                    'sku' => $sku,
                    'barcode' => $barcode,
                    'category_id' => $data['category_id'] ?? 1,
                    'brand_id' => $data['brand_id'] ?? null,
                    'purchase_price' => $data['purchase_price'] ?? 0,
                    'sale_price' => $data['sale_price'] ?? 0,
                    'description' => $data['description'] ?? null,
                    'status' => $data['status'] ?? 1,
                ]);

                // Handle stock if provided
                if (isset($data['stock']) && $data['stock'] > 0) {
                    $defaultWarehouse = \App\Models\Warehouse::first();
                    if ($defaultWarehouse) {
                        \App\Models\WarehouseProduct::create([
                            'warehouse_id' => $defaultWarehouse->id,
                            'product_id' => $product->id,
                            'stock' => $data['stock'],
                        ]);
                    }
                }

                $imported++;
            } catch (\Exception $e) {
                $errors[] = $data['name'] . ': ' . $e->getMessage();
            }
        }

        fclose($file);

        // Build response message
        $message = [];
        
        if ($imported > 0) {
            $message[] = "{$imported} product(s) imported successfully.";
        }
        
        if (count($skipped) > 0) {
            $message[] = count($skipped) . " product(s) skipped (already exist).";
        }
        
        if (count($errors) > 0) {
            $message[] = count($errors) . " product(s) failed to import.";
        }
        
        if (empty($message)) {
            $message[] = "No products were processed.";
        }

        // Store detailed results in session for display
        session()->flash('import_results', [
            'imported' => $imported,
            'skipped' => $skipped,
            'errors' => $errors,
            'total' => $imported + count($skipped) + count($errors)
        ]);

        return redirect()->route('products.index')
            ->with('success', implode(' ', $message));
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
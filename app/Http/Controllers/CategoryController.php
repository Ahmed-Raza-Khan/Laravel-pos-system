<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ];

        $this->categoryService->createCategory($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->getCategory($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ];

        $this->categoryService->updateCategory($id, $data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category Deleted Successfully');
    }
}

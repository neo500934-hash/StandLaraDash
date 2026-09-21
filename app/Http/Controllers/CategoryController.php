<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categories.index');
    }

    /**
     * Provide the server-side DataTables payload for the listing.
     */
    public function data()
    {
        $query = Category::with('parent')->select('categories.*');

        return DataTables::eloquent($query)
            ->addColumn('select', fn (Category $category) => '<input type="checkbox" class="form-check-input row-select-category" value="'.$category->id.'" aria-label="'.__('Select :name', ['name' => e($category->name)]).'">')
            ->addColumn('parent', fn (Category $category) => $category->parent?->name ?? __('—'))
            ->editColumn('created_at', fn (Category $category) => $category->created_at->format('M d, Y \a\t H:i'))
            ->addColumn('actions', fn (Category $category) => view('categories._actions', ['category' => $category])->render())
            ->rawColumns(['select', 'actions'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')->with('status', __('Category created.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return redirect()->route('categories.edit', $category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->orderBy('name')->get();

        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')->with('status', __('Category updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('status', __('Category deleted.'));
    }

    /**
     * Remove multiple resources from storage at once.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:categories,id'],
        ]);

        $count = Category::whereIn('id', $validated['ids'])->get()->each->delete()->count();

        return redirect()->route('categories.index')->with('status', trans_choice('{1} Category deleted.|[2,*] :count categories deleted.', $count, ['count' => $count]));
    }
}

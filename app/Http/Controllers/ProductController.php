<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Provide the server-side DataTables payload for the listing.
     */
    public function data()
    {
        $query = Product::with('category')->select('products.*');

        return DataTables::eloquent($query)
            ->addColumn('select', fn (Product $product) => '<input type="checkbox" class="form-check-input row-select-product" value="'.$product->id.'" aria-label="'.__('Select :name', ['name' => e($product->name)]).'">')
            ->addColumn('category', fn (Product $product) => $product->category?->name ?? __('—'))
            ->editColumn('status', function (Product $product) {
                $badge = match ($product->status) {
                    ProductStatus::Active => 'success',
                    ProductStatus::Archived => 'secondary',
                    default => 'warning',
                };

                return '<span class="badge text-bg-'.$badge.'">'.ucfirst($product->status->value).'</span>';
            })
            ->editColumn('created_at', fn (Product $product) => $product->created_at->format('M d, Y \a\t H:i'))
            ->addColumn('actions', fn (Product $product) => view('products._actions', ['product' => $product])->render())
            ->rawColumns(['select', 'status', 'actions'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::flattenedTree();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('status', __('Product created.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return redirect()->route('products.edit', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::flattenedTree();
        $product->load(['images', 'variants.inventory', 'variants.promotionalPrices']);

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with('status', __('Product updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('status', __('Product deleted.'));
    }

    /**
     * Remove multiple resources from storage at once.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:products,id'],
        ]);

        $count = Product::whereIn('id', $validated['ids'])->get()->each->delete()->count();

        return redirect()->route('products.index')->with('status', trans_choice('{1} Product deleted.|[2,*] :count products deleted.', $count, ['count' => $count]));
    }
}

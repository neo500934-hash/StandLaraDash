<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('brands.index');
    }

    /**
     * Provide the server-side DataTables payload for the listing.
     */
    public function data()
    {
        $query = Brand::with('user')->select('brands.*');

        return DataTables::eloquent($query)
            ->addColumn('added_by', fn (Brand $brand) => $brand->user->name)
            ->editColumn('created_at', fn (Brand $brand) => $brand->created_at->format('M d, Y \a\t H:i'))
            ->addColumn('actions', fn (Brand $brand) => view('brands._actions', ['brand' => $brand])->render())
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Brand::create([...$validated, 'user_id' => auth()->id()]);

        return redirect()->route('brands.index')->with('status', __('Brand created.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return redirect()->route('brands.edit', $brand);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $brand->update($validated);

        return redirect()->route('brands.index')->with('status', __('Brand updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('status', __('Brand deleted.'));
    }
}

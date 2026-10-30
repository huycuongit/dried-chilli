<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EcomBundleController extends Controller
{
    public function index()
    {
        return view('admin.ecom_bundles.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = \App\Models\Bundle::query();
            
            return \DataTables::of($query)
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_bundles.edit', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit"><i class="ti ti-edit ti-md"></i></a>
                                <form action="'.route('admin.ecom_bundles.destroy', $row->id).'" method="POST" class="d-inline-block" data-confirm="Are you sure?">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill"><i class="ti ti-trash ti-md"></i></button>
                                </form>
                            </div>';
                })
                ->editColumn('price', function($row) {
                    return '$' . number_format($row->price, 2);
                })
                ->editColumn('is_active', function($row) {
                    return $row->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
    }

    public function create()
    {
        $products = \App\Models\Product::where('is_active', true)->get();
        return view('admin.ecom_bundles.form', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.required_quantity' => 'required|integer|min:1',
        ]);

        $bundle = \App\Models\Bundle::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        foreach ($request->products as $item) {
            $bundle->items()->create([
                'product_id' => $item['product_id'],
                'required_quantity' => $item['required_quantity'],
            ]);
        }

        return redirect()->route('admin.ecom_bundles.index')->with('success', 'Bundle created successfully.');
    }

    public function edit($id)
    {
        $bundle = \App\Models\Bundle::with('items')->findOrFail($id);
        $products = \App\Models\Product::where('is_active', true)->get();
        return view('admin.ecom_bundles.form', compact('bundle', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.required_quantity' => 'required|integer|min:1',
        ]);

        $bundle = \App\Models\Bundle::findOrFail($id);
        $bundle->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        $bundle->items()->delete(); // Clear old items
        foreach ($request->products as $item) {
            $bundle->items()->create([
                'product_id' => $item['product_id'],
                'required_quantity' => $item['required_quantity'],
            ]);
        }

        return redirect()->route('admin.ecom_bundles.index')->with('success', 'Bundle updated successfully.');
    }

    public function destroy($id)
    {
        \App\Models\Bundle::findOrFail($id)->delete();
        return redirect()->route('admin.ecom_bundles.index')->with('success', 'Bundle deleted successfully.');
    }
}

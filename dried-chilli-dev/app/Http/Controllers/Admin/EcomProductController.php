<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;

class EcomProductController extends Controller
{
    public function index()
    {
        return view('admin.ecom_products.index');
    }
    
    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with('inventory');
            if ($request->has('keyword') && $request->keyword != '') {
                $query->where('name', 'like', '%' . $request->keyword . '%');
            }
            return DataTables::of($query)
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_products.edit', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="Edit"><i class="ti ti-edit ti-md"></i></a>
                                <form action="'.route('admin.ecom_products.destroy', $row->id).'" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure you want to delete this product?\');">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="submit" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill" title="Delete"><i class="ti ti-trash ti-md text-danger"></i></button>
                                </form>
                            </div>';
                })
                ->addColumn('quantity', function($row) {
                    return $row->inventory ? $row->inventory->quantity : 0;
                })
                ->editColumn('price', function($row) { return '$' . number_format($row->price, 2); })
                ->editColumn('sale_price', function($row) { return $row->sale_price ? '$' . number_format($row->sale_price, 2) : '-'; })
                ->editColumn('is_best_seller', function($row) { return $row->is_best_seller ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>'; })
                ->editColumn('is_sale', function($row) { return $row->is_sale ? '<span class="badge bg-primary">Yes</span>' : '<span class="badge bg-secondary">No</span>'; })
                ->editColumn('is_limited_sale', function($row) { return $row->is_limited_sale ? '<span class="badge bg-warning">Yes</span>' : '<span class="badge bg-secondary">No</span>'; })
                ->rawColumns(['action', 'is_best_seller', 'is_sale', 'is_limited_sale'])
                ->make(true);
        }
    }

    public function create()
    {
        $data = new Product();
        return view('admin.ecom_products.form', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sale_type' => $request->sale_type ?? 'none',
            'sale_start_date' => $request->sale_start_date,
            'sale_end_date' => $request->sale_end_date,
            'description' => $request->description,
            'is_best_seller' => $request->has('is_best_seller'),
            'is_active' => $request->has('is_active'),
            'is_sale' => $request->has('is_sale'),
            'is_limited_sale' => $request->has('is_limited_sale'),
        ]);

        if ($request->has('quantity')) {
            \App\Models\Inventory::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 0,
            ]);
        }

        return redirect()->route('admin.ecom_products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $data = Product::findOrFail($id);
        return view('admin.ecom_products.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . $id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sale_type' => $request->sale_type ?? 'none',
            'sale_start_date' => $request->sale_start_date,
            'sale_end_date' => $request->sale_end_date,
            'description' => $request->description,
            'is_best_seller' => $request->has('is_best_seller'),
            'is_active' => $request->has('is_active'),
            'is_sale' => $request->has('is_sale'),
            'is_limited_sale' => $request->has('is_limited_sale'),
        ]);

        if ($request->has('quantity')) {
            $inventory = \App\Models\Inventory::firstOrNew(['product_id' => $product->id, 'variant_id' => null]);
            $inventory->quantity = $request->quantity;
            $inventory->save();
        }

        return redirect()->route('admin.ecom_products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.ecom_products.index')->with('success', 'Product deleted successfully.');
    }
}

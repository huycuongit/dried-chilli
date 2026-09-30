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
            $query = Product::query();
            if ($request->has('keyword') && $request->keyword != '') {
                $query->where('name', 'like', '%' . $request->keyword . '%');
            }
            return DataTables::of($query)
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_products.edit', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="Edit"><i class="ti ti-edit ti-md"></i></a>
                            </div>';
                })
                ->editColumn('price', function($row) { return '$' . number_format($row->price, 2); })
                ->editColumn('sale_price', function($row) { return $row->sale_price ? '$' . number_format($row->sale_price, 2) : '-'; })
                ->editColumn('is_best_seller', function($row) { return $row->is_best_seller ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>'; })
                ->rawColumns(['action', 'is_best_seller'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $data = Product::findOrFail($id);
        return view('admin.ecom_products.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'is_best_seller' => $request->has('is_best_seller')
        ]);
        return redirect()->route('admin.ecom_products.index')->with('success', 'Product updated successfully.');
    }
}

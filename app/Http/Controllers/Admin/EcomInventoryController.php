<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EcomInventoryController extends Controller
{
    public function index()
    {
        return view('admin.ecom_inventory.index');
    }
    
    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = \App\Models\Inventory::with(['product', 'variant']);
            if ($request->has('keyword') && $request->keyword != '') {
                $query->whereHas('product', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->keyword . '%');
                })->orWhereHas('variant', function($q) use ($request) {
                    $q->where('sku', 'like', '%' . $request->keyword . '%');
                });
            }
            return \DataTables::of($query)
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_inventory.edit', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="Edit"><i class="ti ti-edit ti-md"></i></a>
                            </div>';
                })
                ->addColumn('product_name', function($row) {
                    $name = $row->product->name ?? 'Unknown';
                    if ($row->variant) {
                        $name .= ' - ' . ($row->variant->color ? $row->variant->color . ' ' : '') . $row->variant->size;
                    }
                    return $name;
                })
                ->addColumn('sku', function($row) {
                    return $row->variant ? $row->variant->sku : '-';
                })
                ->editColumn('quantity', function($row) { 
                    $badge = $row->quantity <= $row->low_stock_threshold ? 'bg-danger' : 'bg-success';
                    return '<span class="badge '.$badge.'">' . $row->quantity . '</span>'; 
                })
                ->rawColumns(['action', 'quantity'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $data = \App\Models\Inventory::with(['product', 'variant'])->findOrFail($id);
        return view('admin.ecom_inventory.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ]);

        $inventory = \App\Models\Inventory::findOrFail($id);
        $inventory->update([
            'quantity' => $request->quantity,
            'low_stock_threshold' => $request->low_stock_threshold,
        ]);
        
        return redirect()->route('admin.ecom_inventory.index')->with('success', 'Inventory updated successfully.');
    }
}

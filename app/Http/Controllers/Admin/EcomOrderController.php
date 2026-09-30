<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use DataTables;

class EcomOrderController extends Controller
{
    public function index()
    {
        return view('admin.ecom_orders.index');
    }
    
    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::query();
            if ($request->has('keyword') && $request->keyword != '') {
                $query->where('id', $request->keyword);
            }
            return DataTables::of($query)
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_orders.edit', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="Edit"><i class="ti ti-edit ti-md"></i></a>
                            </div>';
                })
                ->editColumn('total_amount', function($row) { return '$' . number_format($row->total_amount, 2); })
                ->editColumn('status', function($row) { 
                    $color = match($row->status) {
                        'pending' => 'warning',
                        'paid', 'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary'
                    };
                    return '<span class="badge bg-'.$color.'">'.ucfirst($row->status).'</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $data = Order::with('items')->findOrFail($id);
        return view('admin.ecom_orders.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
        ]);
        return redirect()->route('admin.ecom_orders.index')->with('success', 'Order status updated successfully.');
    }
}

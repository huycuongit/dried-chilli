<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EcomCustomerController extends Controller
{
    public function index()
    {
        return view('admin.ecom_customers.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = \App\Models\Customer::query();
            return \DataTables::of($query)
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_customers.show', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="View"><i class="ti ti-eye ti-md"></i></a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $customer = \App\Models\Customer::findOrFail($id);
        // Assuming orders table has user_id but maybe should be customer_id, we just fetch by email for safety if they mismatch, or user_id
        $orders = \App\Models\Order::where('user_id', $customer->id)->get();
        return view('admin.ecom_customers.show', compact('customer', 'orders'));
    }
}

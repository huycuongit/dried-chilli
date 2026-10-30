<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use DataTables;

class EcomCouponController extends Controller
{
    public function index()
    {
        return view('admin.ecom_coupons.index');
    }
    
    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = Coupon::query();
            if ($request->has('keyword') && $request->keyword != '') {
                $query->where('code', 'like', '%' . $request->keyword . '%');
            }
            return DataTables::of($query)
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_coupons.edit', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="Edit"><i class="ti ti-edit ti-md"></i></a>
                                <form action="'.route('admin.ecom_coupons.destroy', $row->id).'" method="POST" class="d-inline-block" data-confirm="Are you sure you want to delete this coupon?">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="submit" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill" title="Delete"><i class="ti ti-trash ti-md text-danger"></i></button>
                                </form>
                            </div>';
                })
                ->editColumn('value', function($row) { return $row->type == 'percent' ? $row->value . '%' : '$' . number_format($row->value, 2); })
                ->editColumn('is_active', function($row) { return $row->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; })
                ->editColumn('expires_at', function($row) { return $row->expires_at ? $row->expires_at->format('Y-m-d H:i') : 'Never'; })
                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
    }

    public function create()
    {
        $data = new Coupon();
        return view('admin.ecom_coupons.form', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:255',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.ecom_coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit($id)
    {
        $data = Coupon::findOrFail($id);
        return view('admin.ecom_coupons.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,'.$id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
        ]);
        return redirect()->route('admin.ecom_coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->route('admin.ecom_coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}

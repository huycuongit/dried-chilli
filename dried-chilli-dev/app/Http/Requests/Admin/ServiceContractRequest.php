<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->routeIs('admin.contracts.store') && $this->boolean('quick_create')) {
            return [
                'quick_create' => ['required', 'accepted'],
                'customer_name' => ['required', 'string', 'max:255'],
                'customer_email' => ['nullable', 'email', 'max:255'],
                'service_ids' => ['required', 'array', 'min:1', 'max:50'],
                'service_ids.*' => ['required', 'integer', 'distinct', Rule::exists('services', 'id')->where('active', true)],
            ];
        }
        $contractId = $this->route('id');

        $detailRules = ['website_details' => ['nullable', 'array']];
        foreach (config('website-contract.fields') as $fields) {
            foreach ($fields as $key => $label) {
                $detailRules['website_details.' . $key] = ['nullable', 'string', 'max:5000'];
            }
        }

        return $detailRules + [
            'contract_number' => [
                'nullable', 'string', 'max:80',
                Rule::unique('service_contracts', 'contract_number')->ignore($contractId),
            ],
            'title' => ['required', 'string', 'max:255'],
            'locale' => ['required', Rule::in(['vi', 'en'])],
            'effective_date' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:effective_date'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_company' => ['nullable', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'customer_tax_id' => ['nullable', 'string', 'max:100'],
            'customer_address' => ['nullable', 'string', 'max:1000'],
            'scope_summary' => ['nullable', 'string', 'max:5000'],
            'terms' => ['required', 'string', 'max:50000'],
            'payment_terms' => ['nullable', 'string', 'max:10000'],
            'tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'currency' => ['required', Rule::in(['VND', 'USD', 'AUD'])],
            'items' => ['required', 'array', 'min:1', 'max:50'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.description' => ['nullable', 'string', 'max:2000'],
            'items.*.quantity' => ['required', 'numeric', 'gt:0', 'max:999999'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0', 'max:9999999999999'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_ids.required' => 'Vui lòng chọn ít nhất một dịch vụ.',
            'service_ids.*.distinct' => 'Mỗi dịch vụ chỉ được chọn một lần.',
            'service_ids.*.exists' => 'Dịch vụ đã chọn không còn hoạt động.',
            'items.required' => 'Hợp đồng phải có ít nhất một sản phẩm hoặc dịch vụ.',
            'items.min' => 'Hợp đồng phải có ít nhất một sản phẩm hoặc dịch vụ.',
            'items.*.name.required' => 'Vui lòng nhập tên sản phẩm/dịch vụ.',
            'items.*.quantity.gt' => 'Số lượng phải lớn hơn 0.',
            'customer_name.required' => 'Vui lòng nhập tên người ký.',
            'customer_email.required' => 'Vui lòng nhập email nhận hợp đồng.',
            'terms.required' => 'Vui lòng nhập điều khoản hợp đồng.',
        ];
    }
}

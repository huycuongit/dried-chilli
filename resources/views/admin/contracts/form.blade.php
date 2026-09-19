@extends('admin.layouts.master')

@push('css')
<style>
    .contract-item{border:1px solid #e5e7eb;border-radius:12px;padding:18px;margin-bottom:14px;background:#fafbfc}.contract-item-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1.3fr auto;gap:12px;align-items:end}@media(max-width:900px){.contract-item-grid{grid-template-columns:1fr 1fr}.contract-item-grid>*:first-child{grid-column:1/-1}}.contract-total{font-size:1.15rem;font-weight:700}.contract-locked{padding:12px 16px;border-radius:10px;background:#e8f7ee;color:#167443}
</style>
@endpush

@section('content')
    @php
        $isEdit = $contract->exists;
        $locked = $contract->isSigned();
        $items = old('items', $isEdit ? $contract->items->map(fn ($item) => $item->only(['name','description','quantity','unit','unit_price']))->all() : [['name' => '', 'description' => '', 'quantity' => 1, 'unit' => 'gói', 'unit_price' => 0]]);
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="POST" action="{{ $isEdit ? route('admin.contracts.update', $contract->id) : route('admin.contracts.store') }}" id="contract-form">
            @csrf
            @if ($isEdit) @method('PUT') @endif
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div><h3 class="mb-1">{{ $isEdit ? $contract->contract_number : 'Tạo hợp đồng dịch vụ' }}</h3><p class="text-muted mb-0">Nhập khách hàng và các sản phẩm/dịch vụ cần cung cấp.</p></div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.contracts.index') }}" class="btn btn-label-secondary">Back</a>
                    @if ($isEdit)<a href="{{ $contract->publicUrl() }}" class="btn btn-label-info" target="_blank">Xem hợp đồng</a>@endif
                    @if (!$locked)<button class="btn btn-primary" type="submit">Save hợp đồng</button>@endif
                </div>
            </div>

            @include('admin.layouts.partials.messages')
            @if ($errors->any())<div class="alert alert-danger"><strong>Vui lòng kiểm tra lại:</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @if (!$locked && $contract->hasUnfilledTerms())<div class="alert alert-info">Bản nháp đã được tạo. Mẫu hợp đồng còn thông tin chưa điền; thiết lập mẫu dùng chung trong Content các trang cho lần tạo tiếp theo, hoặc mở phần chỉnh sửa bên dưới để hoàn thiện bản này.</div>@endif
            @if ($locked)<div class="contract-locked mb-4"><i class="ti ti-lock me-1"></i>Hợp đồng đã ký lúc {{ $contract->signed_at->format('d/m/Y H:i') }} và đã được khóa nội dung.</div>@endif

            <details class="mb-4"><summary class="btn btn-label-secondary">Chỉnh thông tin và điều khoản</summary>
            <fieldset class="mt-3" @disabled($locked)>
                <div class="card mb-4"><div class="card-header"><h5 class="mb-0">Thông tin hợp đồng và khách hàng</h5></div><div class="card-body"><div class="row g-4">
                    <div class="col-md-4"><label class="form-label">Mã hợp đồng</label><input class="form-control" name="contract_number" value="{{ old('contract_number', $contract->contract_number) }}" placeholder="Để trống để tự sinh"></div>
                    <div class="col-md-5"><label class="form-label">Tên hợp đồng *</label><input class="form-control" name="title" required value="{{ old('title', $contract->title) }}"></div>
                    <div class="col-md-3"><label class="form-label">Ngôn ngữ *</label><select class="form-select" name="locale"><option value="vi" @selected(old('locale', $contract->locale) === 'vi')>Vietnamese</option><option value="en" @selected(old('locale', $contract->locale) === 'en')>English</option></select></div>
                    <div class="col-md-6"><label class="form-label">Tên người ký *</label><input class="form-control" name="customer_name" required value="{{ old('customer_name', $contract->customer_name) }}"></div>
                    <div class="col-md-6"><label class="form-label">Công ty khách hàng</label><input class="form-control" name="customer_company" value="{{ old('customer_company', $contract->customer_company) }}"></div>
                    <div class="col-md-6"><label class="form-label">Email nhận hợp đồng</label><input class="form-control" type="email" name="customer_email" value="{{ old('customer_email', $contract->customer_email) }}"></div>
                    <div class="col-md-3"><label class="form-label">Số điện thoại</label><input class="form-control" name="customer_phone" value="{{ old('customer_phone', $contract->customer_phone) }}"></div>
                    <div class="col-md-3"><label class="form-label">Mã số thuế / CCCD</label><input class="form-control" name="customer_tax_id" value="{{ old('customer_tax_id', $contract->customer_tax_id) }}"></div>
                    <div class="col-md-6"><label class="form-label">Địa chỉ khách hàng</label><textarea class="form-control" name="customer_address" rows="2">{{ old('customer_address', $contract->customer_address) }}</textarea></div>
                    <div class="col-md-3"><label class="form-label">Ngày hiệu lực</label><input class="form-control" type="date" name="effective_date" value="{{ old('effective_date', optional($contract->effective_date)->format('Y-m-d')) }}"></div>
                    <div class="col-md-3"><label class="form-label">Hạn ký</label><input class="form-control" type="date" name="expires_at" value="{{ old('expires_at', optional($contract->expires_at)->format('Y-m-d')) }}"></div>
                    <div class="col-12"><label class="form-label">Phạm vi công việc</label><textarea class="form-control" name="scope_summary" rows="3">{{ old('scope_summary', $contract->scope_summary) }}</textarea></div>
                </div></div></div>

                <div class="card mb-4"><div class="card-header d-flex justify-content-between align-items-center"><h5 class="mb-0">Sản phẩm / dịch vụ</h5><button class="btn btn-sm btn-label-primary" type="button" id="add-contract-item"><i class="ti ti-plus me-1"></i>Thêm hạng mục</button></div><div class="card-body" id="contract-items">
                    @foreach ($items as $index => $item)
                        <div class="contract-item" data-contract-item>
                            <div class="contract-item-grid">
                                <div><label class="form-label">Tên sản phẩm/dịch vụ *</label><input class="form-control" name="items[{{ $index }}][name]" required value="{{ $item['name'] ?? '' }}"></div>
                                <div><label class="form-label">Số lượng *</label><input class="form-control js-quantity" type="number" min="0.01" step="0.01" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] ?? 1 }}"></div>
                                <div><label class="form-label">Đơn vị *</label><input class="form-control" name="items[{{ $index }}][unit]" value="{{ $item['unit'] ?? 'gói' }}"></div>
                                <div><label class="form-label">Đơn giá *</label><input class="form-control js-price" type="number" min="0" step="0.01" name="items[{{ $index }}][unit_price]" value="{{ $item['unit_price'] ?? 0 }}"></div>
                                <button class="btn btn-icon btn-label-danger js-remove-item" type="button"><i class="ti ti-trash"></i></button>
                            </div>
                            <div class="mt-3"><label class="form-label">Description / tính năng bàn giao</label><textarea class="form-control" rows="2" name="items[{{ $index }}][description]">{{ $item['description'] ?? '' }}</textarea></div>
                        </div>
                    @endforeach
                </div></div>

                @if ($contract->website_details !== null)
                    @include('admin.contracts.website-details')
                @endif

                <div class="row g-4">
                    <div class="col-lg-8"><div class="card h-100"><div class="card-header"><h5 class="mb-0">Điều khoản</h5></div><div class="card-body"><label class="form-label">Điều khoản hợp đồng *</label><textarea class="form-control mb-4" name="terms" rows="9" required>{{ old('terms', $contract->terms) }}</textarea><label class="form-label">Điều khoản thanh toán</label><textarea class="form-control" name="payment_terms" rows="4">{{ old('payment_terms', $contract->payment_terms) }}</textarea></div></div></div>
                    <div class="col-lg-4"><div class="card"><div class="card-header"><h5 class="mb-0">Giá trị hợp đồng</h5></div><div class="card-body">
                        <label class="form-label">Tiền tệ</label><select class="form-select mb-3" name="currency" id="contract-currency">@foreach (['VND','USD','AUD'] as $currency)<option value="{{ $currency }}" @selected(old('currency', $contract->currency) === $currency)>{{ $currency }}</option>@endforeach</select>
                        <p class="text-muted small">{{ config('website-contract.tax_note') }}</p><label class="form-label">Thuế (%)</label><input class="form-control mb-4" type="number" min="0" max="100" step="0.01" name="tax_rate" id="contract-tax" value="{{ old('tax_rate', $contract->tax_rate ?? 0) }}">
                        <div class="d-flex justify-content-between mb-2"><span>Tạm tính</span><span id="subtotal-preview">0</span></div><div class="d-flex justify-content-between mb-3"><span>Thuế</span><span id="tax-preview">0</span></div><hr><div class="d-flex justify-content-between contract-total"><span>Tổng cộng</span><span id="total-preview">0</span></div>
                    </div></div></div>
                </div>
            </fieldset>
            </details>

            @if ($isEdit)
                <div class="card mt-4"><div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3"><div><strong>Link ký hợp đồng</strong><div class="text-muted small text-break">{{ $contract->publicUrl() }}</div></div><div class="d-flex gap-2"><button class="btn btn-label-secondary" id="copy-contract-link" type="button" data-url="{{ $contract->publicUrl() }}"><i class="ti ti-copy me-1"></i>Sao chép link</button>@if (!$locked && $contract->customer_email)<button class="btn btn-primary" type="submit" form="send-contract-form"><i class="ti ti-send me-1"></i>Gửi email cho khách</button>@endif</div></div></div>
            @endif
        </form>
        @if ($isEdit && !$locked)<form id="send-contract-form" method="POST" action="{{ route('admin.contracts.send', $contract->id) }}">@csrf</form>@endif
    </div>
@endsection

@push('js')
<script>
(() => {
    const container = document.querySelector('#contract-items');
    const addButton = document.querySelector('#add-contract-item');
    if (!container) return;
    let index = container.querySelectorAll('[data-contract-item]').length;
    const template = (i) => `<div class="contract-item" data-contract-item><div class="contract-item-grid"><div><label class="form-label">Tên sản phẩm/dịch vụ *</label><input class="form-control" name="items[${i}][name]" required></div><div><label class="form-label">Số lượng *</label><input class="form-control js-quantity" type="number" min="0.01" step="0.01" name="items[${i}][quantity]" value="1"></div><div><label class="form-label">Đơn vị *</label><input class="form-control" name="items[${i}][unit]" value="gói"></div><div><label class="form-label">Đơn giá *</label><input class="form-control js-price" type="number" min="0" step="0.01" name="items[${i}][unit_price]" value="0"></div><button class="btn btn-icon btn-label-danger js-remove-item" type="button"><i class="ti ti-trash"></i></button></div><div class="mt-3"><label class="form-label">Description / tính năng bàn giao</label><textarea class="form-control" rows="2" name="items[${i}][description]"></textarea></div></div>`;
    const calculate = () => {
        let subtotal = 0;
        container.querySelectorAll('[data-contract-item]').forEach((row) => subtotal += (Number(row.querySelector('.js-quantity')?.value) || 0) * (Number(row.querySelector('.js-price')?.value) || 0));
        const tax = subtotal * (Number(document.querySelector('#contract-tax')?.value) || 0) / 100;
        const currency = document.querySelector('#contract-currency')?.value || 'VND';
        const format = (value) => new Intl.NumberFormat(currency === 'VND' ? 'vi-VN' : 'en-US', {style:'currency', currency, maximumFractionDigits: currency === 'VND' ? 0 : 2}).format(value);
        document.querySelector('#subtotal-preview').textContent = format(subtotal);
        document.querySelector('#tax-preview').textContent = format(tax);
        document.querySelector('#total-preview').textContent = format(subtotal + tax);
    };
    addButton?.addEventListener('click', () => { container.insertAdjacentHTML('beforeend', template(index++)); calculate(); });
    container.addEventListener('click', (event) => { const button = event.target.closest('.js-remove-item'); if (!button) return; if (container.querySelectorAll('[data-contract-item]').length > 1) button.closest('[data-contract-item]').remove(); calculate(); });
    document.querySelector('#contract-form')?.addEventListener('input', calculate);
    document.querySelector('#copy-contract-link')?.addEventListener('click', async (event) => { await navigator.clipboard.writeText(event.currentTarget.dataset.url); event.currentTarget.innerHTML = '<i class="ti ti-check me-1"></i>Đã sao chép'; });
    calculate();
})();
</script>
@endpush

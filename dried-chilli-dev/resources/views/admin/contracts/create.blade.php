@extends('admin.layouts.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h3 class="mb-1">Tạo hợp đồng</h3><p class="text-muted mb-0">Nhập tên khách và thêm dịch vụ để tạo hợp đồng từ mẫu.</p></div><a href="{{ route('admin.contracts.index') }}" class="btn btn-label-secondary">Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin.contracts.store') }}" class="card">
        @csrf
        <input type="hidden" name="quick_create" value="1">
        <div class="card-body">
            <div class="mb-4"><label class="form-label" for="customer-name">Tên khách hàng *</label><input id="customer-name" class="form-control" name="customer_name" maxlength="255" required value="{{ old('customer_name') }}" placeholder="Nguyễn Văn A"></div>
            <div class="mb-4"><label class="form-label">Dịch vụ *</label>
                @foreach($services as $service)
                    <label class="d-flex gap-3 align-items-center border rounded p-3 mb-2"><input class="form-check-input service-choice" type="checkbox" name="service_ids[]" value="{{ $service->id }}" data-price="{{ $service->contract_price }}" @checked(in_array((string) $service->id, array_map('strval', old('service_ids', [])), true)) @disabled($service->contract_price === null)><span class="flex-grow-1">{{ $service->name_vi ?: $service->name }}</span><strong>{{ $service->contract_price === null ? 'Chưa có giá' : number_format((float) $service->contract_price, 0, ',', '.') . ' đ' }}</strong></label>
                @endforeach
                <div class="form-text">Giá được cấu hình ở mục Dịch vụ. Mỗi dịch vụ chọn tương ứng một gói.</div>
                <div class="d-flex justify-content-between mt-3"><strong>Tổng cộng</strong><strong id="quick-total">0 đ</strong></div>
            </div>
            <details class="mb-4"><summary class="text-muted">Thông tin bổ sung (không bắt buộc)</summary><div class="mt-3"><label class="form-label" for="customer-email">Email nhận hợp đồng</label><input id="customer-email" class="form-control" type="email" name="customer_email" value="{{ old('customer_email') }}"><div class="form-text">Có thể bỏ trống và sao chép link gửi cho khách.</div></div></details>
            <button type="submit" class="btn btn-primary" @disabled($services->isEmpty())>Tạo hợp đồng</button>
            @if($services->isEmpty())<p class="text-muted mt-3">Chưa có dịch vụ đang hoạt động. Hãy thêm dịch vụ trước.</p>@endif
        </div>
    </form>
</div>
<script>
(() => { const inputs = document.querySelectorAll('.service-choice'); const total = document.getElementById('quick-total'); const update = () => { let cents = 0; inputs.forEach(input => { if(input.checked) cents += Math.round(Number(input.dataset.price) * 100); }); total.textContent = new Intl.NumberFormat('vi-VN', {style:'currency', currency:'VND'}).format(cents / 100); }; inputs.forEach(input => input.addEventListener('change', update)); update(); })();
</script>
@endsection

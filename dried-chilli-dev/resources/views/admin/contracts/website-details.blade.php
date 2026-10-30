<div class="card mb-4">
    <div class="card-header"><h5 class="mb-1">Mẫu hợp đồng website · NAFU Services giữ mã nguồn</h5><p class="text-muted mb-0">Điền thông tin dưới đây để hoàn thiện điều khoản và Phụ lục 01. Phí NAFU Care cần khớp với hạng mục tính tiền.</p></div>
    <div class="card-body">
        @foreach (config('website-contract.fields') as $group => $fields)
            <h6 class="mt-3">{{ ['provider' => 'Đại diện và thanh toán', 'project' => 'Phạm vi công việc và quyền bàn giao', 'care' => 'NAFU Care', 'payment' => 'Tiến độ thanh toán'][$group] }}</h6>
            <div class="row g-3 mb-4">
                @foreach ($fields as $key => $label)
                    <div class="col-md-6"><label class="form-label" for="detail-{{ $key }}">{{ $label }}</label><textarea id="detail-{{ $key }}" class="form-control" name="website_details[{{ $key }}]" rows="2" maxlength="5000">{{ old('website_details.' . $key, $contract->website_details[$key] ?? '') }}</textarea></div>
                @endforeach
            </div>
        @endforeach
        <p class="text-muted small mb-0">Thông tin không áp dụng: ghi “Không áp dụng”. Các ký hiệu trong ngoặc vuông ở điều khoản sẽ được thay bằng thông tin tương ứng khi xem hợp đồng.</p>
    </div>
</div>

@extends('admin.layouts.master')

@section('content')
    @php
        $statusLabels = ['draft' => 'Bản nháp', 'sent' => 'Đã gửi', 'signed' => 'Đã ký', 'cancelled' => 'Đã hủy'];
        $statusColors = ['draft' => 'secondary', 'sent' => 'warning', 'signed' => 'success', 'cancelled' => 'danger'];
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div><h3 class="mb-1">Hợp đồng dịch vụ</h3><p class="text-muted mb-0">Tạo hợp đồng, gửi link và theo dõi chữ ký online.</p></div>
            @if (userHasPermission('admin.contracts.create'))
                <a href="{{ route('admin.contracts.create') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Tạo hợp đồng</a>
            @endif
        </div>

        <div class="card mb-4">
            <form class="card-body row g-3 align-items-end" method="GET">
                <div class="col-md-6"><label class="form-label">Search</label><input class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="Mã hợp đồng, khách hàng hoặc email"></div>
                <div class="col-md-3"><label class="form-label">Status</label><select class="form-select" name="status"><option value="">All</option>@foreach ($statusLabels as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="col-md-3"><button class="btn btn-success" type="submit"><i class="ti ti-filter me-1"></i>Lọc</button></div>
            </form>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Mã hợp đồng</th><th>Khách hàng</th><th>Giá trị</th><th>Status</th><th>Update</th><th class="text-end">Thao tác</th></tr></thead>
                    <tbody>
                    @forelse ($contracts as $contract)
                        <tr>
                            <td><a class="fw-semibold" href="{{ route('admin.contracts.edit', $contract->id) }}">{{ $contract->contract_number }}</a></td>
                            <td><strong>{{ $contract->customer_company ?: $contract->customer_name }}</strong><small class="d-block text-muted">{{ $contract->customer_email }}</small></td>
                            <td>{{ number_format((float) $contract->total, $contract->currency === 'VND' ? 0 : 2) }} {{ $contract->currency }}</td>
                            <td><span class="badge bg-label-{{ $statusColors[$contract->status] ?? 'secondary' }}">{{ $statusLabels[$contract->status] ?? $contract->status }}</span></td>
                            <td>{{ $contract->updated_at?->format('d/m/Y H:i') }}</td>
                            <td><div class="d-flex justify-content-end gap-1">
                                <button type="button" class="btn btn-sm btn-label-secondary js-copy-link" data-url="{{ $contract->publicUrl() }}"><i class="ti ti-copy"></i></button>
                                <a class="btn btn-sm btn-label-info" href="{{ $contract->publicUrl() }}" target="_blank" rel="noopener"><i class="ti ti-eye"></i></a>
                                @if (!$contract->isSigned() && userHasPermission('admin.contracts.edit'))
                                    <form method="POST" action="{{ route('admin.contracts.send', $contract->id) }}">@csrf<button class="btn btn-sm btn-label-primary" title="Gửi email ký hợp đồng"><i class="ti ti-send"></i></button></form>
                                    <a class="btn btn-sm btn-label-warning" href="{{ route('admin.contracts.edit', $contract->id) }}"><i class="ti ti-edit"></i></a>
                                @endif
                                @if (!$contract->isSigned() && userHasPermission('admin.contracts.destroy'))
                                    <form method="POST" action="{{ route('admin.contracts.destroy', $contract->id) }}" onsubmit="return confirm('Delete hợp đồng {{ $contract->contract_number }}?')">@csrf @method('DELETE')<button class="btn btn-sm btn-label-danger" title="Delete hợp đồng"><i class="ti ti-trash"></i></button></form>
                                @endif
                            </div></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-5">Chưa có hợp đồng nào.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if ($contracts->hasPages())<div class="card-footer">{{ $contracts->links() }}</div>@endif
        </div>
    </div>
@endsection

@push('js')
<script>
    document.querySelectorAll('.js-copy-link').forEach((button) => button.addEventListener('click', async () => {
        await navigator.clipboard.writeText(button.dataset.url);
        const icon = button.innerHTML;
        button.innerHTML = '<i class="ti ti-check"></i>';
        setTimeout(() => button.innerHTML = icon, 1400);
    }));
</script>
@endpush

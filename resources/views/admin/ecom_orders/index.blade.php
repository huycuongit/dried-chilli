@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        @if($pendingRefunds->total())
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-1">Refunds requiring confirmation</h5><p class="mb-0">These payments have not yet been confirmed refunded by the payment provider. Failed refunds require investigation.</p></div>
                <div class="table-responsive"><table class="table">
                    <thead><tr><th>Payment</th><th>Provider</th><th>Amount</th><th>Reason</th><th>Provider status</th><th>Last error</th></tr></thead>
                    <tbody>@foreach($pendingRefunds as $refund)
                        <tr><td>{{ $refund->id }}</td><td>{{ strtoupper($refund->provider) }}</td><td>{{ $refund->currency }} {{ $refund->total_amount }}</td><td>{{ $refund->failure_code }}</td><td>{{ $refund->refund_status ?? 'Not confirmed' }}</td><td>{{ $refund->refund_last_error ?? '—' }}</td></tr>
                    @endforeach</tbody>
                </table></div>
                <div class="card-body">{{ $pendingRefunds->links() }}</div>
            </div>
        @endif

        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">E-Commerce Orders</h5>
                <div class="row pt-4">
                    <div class="col-md-5 col-lg-4 mb-4 mb-md-0">
                        <input class="form-control" type="text" id="keyword" placeholder="Search by Order ID">
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <table class="dt-orders table text-nowrap">
                    <thead class="border-top">
                        <tr>
                            <th>Order ID</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script>
        $(function () {
            const tableElement = $('.dt-orders');
            const table = tableElement.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.ecom_orders.datatables') }}',
                    type: 'GET',
                    data: function (data) {
                        data.keyword = $('#keyword').val() || '';
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'status', name: 'status' },
                    { data: 'payment_status', name: 'payment_status' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                paging: true,
                lengthChange: true,
                ordering: true,
                order: [[0, 'desc']],
                info: true,
                searching: false,
                autoWidth: false,
                language: {
                    sLengthMenu: '_MENU_',
                    emptyTable: 'No orders yet',
                    processing: '<div class="spinner-border text-primary" role="status"></div>',
                    paginate: {
                        next: '<i class="ti ti-chevron-right ti-sm"></i>',
                        previous: '<i class="ti ti-chevron-left ti-sm"></i>'
                    }
                }
            });

            $('#keyword').on('keyup', function (event) {
                if (event.key === 'Enter' || !this.value) table.ajax.reload();
            });
            
            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm');
        });
    </script>
@endpush

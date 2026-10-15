@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Coupons & Vouchers</h5>
                <a href="{{ route('admin.ecom_coupons.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Add Coupon
                </a>
            </div>
            
            <div class="card-body mt-4">
                <div class="row">
                    <div class="col-md-5 col-lg-4 mb-4 mb-md-0">
                        <input class="form-control" type="text" id="keyword" placeholder="Search by code">
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <table class="dt-coupons table text-nowrap">
                    <thead class="border-top">
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Usage Limit</th>
                            <th>Expires At</th>
                            <th>Status</th>
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
            const tableElement = $('.dt-coupons');
            const table = tableElement.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.ecom_coupons.datatables') }}',
                    type: 'GET',
                    data: function (data) {
                        data.keyword = $('#keyword').val() || '';
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'code', name: 'code' },
                    { data: 'type', name: 'type' },
                    { data: 'value', name: 'value' },
                    { data: 'usage_limit', name: 'usage_limit', render: function(data, type, row) { return data ? row.used_count + ' / ' + data : 'Unlimited'; } },
                    { data: 'expires_at', name: 'expires_at' },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                paging: true,
                lengthChange: true,
                ordering: true,
                info: true,
                searching: false,
                autoWidth: false,
                language: {
                    sLengthMenu: '_MENU_',
                    emptyTable: 'No coupons yet',
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

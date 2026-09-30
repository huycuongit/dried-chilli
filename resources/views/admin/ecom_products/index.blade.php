@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">E-Commerce Products</h5>
                <div class="row pt-4">
                    <div class="col-md-5 col-lg-4 mb-4 mb-md-0">
                        <input class="form-control" type="text" id="keyword" placeholder="Search by product name">
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <table class="dt-products table text-nowrap">
                    <thead class="border-top">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>Best Seller</th>
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
            const tableElement = $('.dt-products');
            const table = tableElement.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.ecom_products.datatables') }}',
                    type: 'GET',
                    data: function (data) {
                        data.keyword = $('#keyword').val() || '';
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'sale_price', name: 'sale_price' },
                    { data: 'is_best_seller', name: 'is_best_seller' },
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
                    emptyTable: 'No products yet',
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

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
                <h5 class="card-title mb-0">Product Bundles</h5>
                <a href="{{ route('admin.ecom_bundles.create') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i> Add Bundle</a>
            </div>

            <div class="card-datatable table-responsive mt-3">
                <table class="dt-bundles table text-nowrap">
                    <thead class="border-top">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
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
            const table = $('.dt-bundles').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.ecom_bundles.datatables') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'action', orderable: false, searchable: false }
                ],
            });
        });
    </script>
@endpush

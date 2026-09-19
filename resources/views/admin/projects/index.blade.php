@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <style>
        .project-thumb { width: 104px; height: 68px; object-fit: cover; border-radius: 7px; border: 1px solid #e5e7eb; }
        .dt-action-buttons { margin-top: 1.5em !important; }
        .project-url { display: inline-block; max-width: 430px; overflow: hidden; text-overflow: ellipsis; vertical-align: middle; }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Search</h5>
                <div class="row pt-4">
                    <div class="col-md-5 col-lg-4 mb-4 mb-md-0">
                        <input class="form-control" type="text" id="keyword" placeholder="Search by project name or description">
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success waves-effect waves-light btn-filter">
                            <i class="ti ti-filter ti-md"></i> Filter
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <table class="dt-projects table text-nowrap">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Project name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-destroy" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <form id="form-destroy" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <span class="badge badge-center rounded-pill bg-danger bg-glow mb-4" style="height:4rem;width:4rem">
                            <i class="ti ti-trash" style="font-size:3.5rem"></i>
                        </span>
                        <p class="modal-title-destroy fs-4 fw-bold mb-1"></p>
                        <p class="text-muted">Deleted data cannot be recovered.</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-destroy-modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="url-datatable" value="{{ route('admin.projects.datatables') }}">
    <input type="hidden" id="url-create" value="{{ route('admin.projects.create') }}">
    <input type="hidden" id="url-edit" value="{{ route('admin.projects.edit', ['id' => '_id']) }}">
    <input type="hidden" id="url-destroy" value="{{ route('admin.projects.destroy', ['id' => '_id']) }}">
    <input type="hidden" id="default-image" value="{{ asset('assets/imgs/default.png') }}">
    <input type="hidden" id="storage-base" value="{{ Storage::url('') }}">
    <input type="hidden" id="user-permissions" value="{{ json_encode($permissions) }}">
@endsection

@push('js')
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function () {
            const permissions = JSON.parse($('#user-permissions').val() || '[]');
            const tableElement = $('.dt-projects');
            const defaultImage = $('#default-image').val();
            const storageBase = $('#storage-base').val();

            const table = tableElement.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: $('#url-datatable').val(),
                    type: 'GET',
                    data: function (data) {
                        data.keyword = $('#keyword').val() || '';
                    }
                },
                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        checkboxes: { selectAllRender: '<input type="checkbox" class="form-check-input">' },
                        render: () => '<input type="checkbox" class="dt-checkboxes form-check-input">'
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: (data, type, row, meta) => meta.settings._iDisplayStart + meta.row + 1
                    },
                    {
                        data: 'avatar',
                        orderable: false,
                        searchable: false,
                        render: function (avatar, type, row) {
                            const image = avatar ? storageBase + avatar : defaultImage;
                            return `<img src="${image}" class="project-thumb" alt="${$('<div>').text(row.title || '').html()}" loading="lazy">`;
                        }
                    },
                    {
                        data: 'title',
                        render: function (title, type, row) {
                            const editUrl = $('#url-edit').val().replace('_id', row.id);
                            return `<a href="${editUrl}" class="text-primary fw-medium">${$('<div>').text(title || '').html()}</a>`;
                        }
                    },
                    { data: 'description', render: value => $('<div>').text((value || '').length > 100 ? value.slice(0, 100) + '…' : (value || '')).html() },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            let actions = '<div class="d-flex align-items-center">';
                            if (permissions.includes('admin.projects.destroy')) {
                                actions += '<a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-destroy" title="Delete"><i class="ti ti-trash ti-md"></i></a>';
                            }
                            if (permissions.includes('admin.projects.edit')) {
                                actions += '<a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="Edit"><i class="ti ti-edit ti-md"></i></a>';
                            }
                            return actions + '</div>';
                        }
                    }
                ],
                paging: true,
                lengthChange: true,
                ordering: false,
                info: true,
                searching: false,
                autoWidth: false,
                responsive: false,
                scrollX: true,
                dom: '<"row"<"col-md-2"<"ms-n2"l>><"col-md-10"<"dt-action-buttons text-end d-flex align-items-center justify-content-end mb-6 mt-n6"B>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: permissions.includes('admin.projects.create') ? [{
                    text: '<i class="ti ti-plus me-1 ti-xs"></i><span>Create new</span>',
                    className: 'btn btn-primary waves-effect waves-light btn-add'
                }] : [],
                language: {
                    sLengthMenu: '_MENU_',
                    emptyTable: 'No projects yet',
                    zeroRecords: 'No matching projects found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ projects',
                    infoEmpty: 'Showing 0 projects',
                    processing: '<div class="spinner-border text-primary" role="status"></div>',
                    paginate: {
                        next: '<i class="ti ti-chevron-right ti-sm"></i>',
                        previous: '<i class="ti ti-chevron-left ti-sm"></i>'
                    }
                }
            });

            $('.btn-filter').on('click', () => table.ajax.reload());
            $('#keyword').on('keyup', function (event) {
                if (event.key === 'Enter' || !this.value) table.ajax.reload();
            });
            $(document).on('click', '.btn-add', () => window.location.href = $('#url-create').val());

            tableElement.on('click', '.btn-edit', function () {
                const row = table.row($(this).closest('tr')).data();
                window.location.href = $('#url-edit').val().replace('_id', row.id);
            });

            tableElement.on('click', '.btn-destroy', function () {
                const row = table.row($(this).closest('tr')).data();
                $('.modal-title-destroy').text(`Are you sure you want to delete “${row.title}”?`);
                $('#form-destroy').attr('action', $('#url-destroy').val().replace('_id', row.id));
                $('#modal-destroy').modal('show');
            });

            $('.btn-destroy-modal').on('click', function () {
                const form = $('#form-destroy');
                $.ajax({
                    url: form.attr('action'),
                    type: 'DELETE',
                    data: form.serialize(),
                    success: function (response) {
                        $('#modal-destroy').modal('hide');
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        $('#modal-destroy').modal('hide');
                        toastr.error('Could not delete the project.');
                    }
                });
            });

            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm');
        });
    </script>
@endpush

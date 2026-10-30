@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <style>
        .contact-person strong, .contact-person small { display: block; }
        .contact-person small { margin-top: 3px; color: #8b8d97; }
        .contact-message-preview { display: block; max-width: 330px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .contact-detail-message { padding: 14px; white-space: pre-wrap; background: #f7f7f9; border-radius: 20px; }
        .contact-status { min-width: 132px; }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')

        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Contact enquiries</h5>
                <div class="row g-3 pt-4">
                    <div class="col-md-5">
                        <input class="form-control" id="keyword" placeholder="Search by name, email, phone or message">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="status-filter">
                            <option value="">All statuses</option>
                            <option value="new">New</option>
                            <option value="contacted">Contacted</option>
                            <option value="done">Completed</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success btn-filter" type="button"><i class="ti ti-filter ti-md"></i> Filter</button>
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <table class="dt-contacts table text-nowrap">
                    <thead class="border-top">
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Projects / Budget</th>
                            <th>Message</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contact-detail-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title contact-detail-name"></h5>
                        <small class="text-muted contact-detail-date"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6"><small class="text-muted d-block">Email</small><a class="contact-detail-email"></a></div>
                        <div class="col-md-6"><small class="text-muted d-block">Phone</small><a class="contact-detail-phone"></a></div>
                        <div class="col-md-6"><small class="text-muted d-block">Project type</small><strong class="contact-detail-project"></strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">Budget</small><strong class="contact-detail-budget"></strong></div>
                    </div>
                    <small class="text-muted d-block mb-2">Customer message</small>
                    <div class="contact-detail-message"></div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="url-datatable" value="{{ route('admin.contacts.datatables') }}">
    <input type="hidden" id="url-update" value="{{ route('admin.contacts.update', ['id' => '_id']) }}">
    <input type="hidden" id="user-permissions" value="{{ json_encode($permissions) }}">
@endsection

@push('js')
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function () {
            const permissions = JSON.parse($('#user-permissions').val() || '[]');
            const canUpdate = permissions.includes('admin.contacts.edit');
            const csrf = $('meta[name="csrf-token"]').attr('content');
            const projectLabels = {
                'business-website': 'Business website', ecommerce: 'E-commerce',
                'custom-web-app': 'Web App', 'booking-system': 'Booking system', other: 'Other'
            };
            const budgetLabels = {
                'under-1000': 'Under $1,000', '1000-3000': '$1.000 – $3.000',
                '3000-5000': '$3.000 – $5.000', 'over-5000': 'Over $5,000', discuss: 'Discuss further'
            };
            const escapeHtml = value => $('<div>').text(value || '').html();

            const tableElement = $('.dt-contacts');
            const table = tableElement.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: $('#url-datatable').val(),
                    data: data => {
                        data.keyword = $('#keyword').val() || '';
                        data.status = $('#status-filter').val() || '';
                    }
                },
                columns: [
                    { data: null, searchable: false, orderable: false, render: (data, type, row, meta) => meta.settings._iDisplayStart + meta.row + 1 },
                    { data: 'full_name', render: (name, type, row) => `<span class="contact-person"><strong>${escapeHtml(name)}</strong><small>${escapeHtml(row.email || 'No email')}</small></span>` },
                    { data: 'phone', render: (phone, type, row) => escapeHtml(phone ? `${row.phone_country || ''} ${phone}`.trim() : '—') },
                    { data: 'project_type', render: (value, type, row) => `<strong>${escapeHtml(projectLabels[value] || value || '—')}</strong><small class="d-block text-muted mt-1">${escapeHtml(budgetLabels[row.budget] || row.budget || 'Not selected')}</small>` },
                    { data: 'message', render: value => `<span class="contact-message-preview" title="${escapeHtml(value)}">${escapeHtml(value)}</span>` },
                    { data: 'created_at' },
                    { data: 'status', orderable: false, render: (status, type, row) => {
                        if (!canUpdate) return status === 'new' ? '<span class="badge bg-label-primary">New</span>' : status === 'contacted' ? '<span class="badge bg-label-warning">Contacted</span>' : '<span class="badge bg-label-success">Completed</span>';
                        return `<select class="form-select form-select-sm contact-status" data-id="${row.id}"><option value="new" ${status === 'new' ? 'selected' : ''}>New</option><option value="contacted" ${status === 'contacted' ? 'selected' : ''}>Contacted</option><option value="done" ${status === 'done' ? 'selected' : ''}>Completed</option></select>`;
                    }},
                    { data: 'action', orderable: false, searchable: false, render: () => '<button class="btn btn-icon btn-text-secondary rounded-pill btn-detail" type="button" title="View details"><i class="ti ti-eye ti-md"></i></button>' }
                ],
                order: [], searching: false, responsive: false, scrollX: true,
                language: {
                    sLengthMenu: '_MENU_', emptyTable: 'No contact enquiries yet', zeroRecords: 'No matching enquiries found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ enquiries', infoEmpty: 'Showing 0 enquiries',
                    processing: '<div class="spinner-border text-primary" role="status"></div>',
                    paginate: { next: '<i class="ti ti-chevron-right ti-sm"></i>', previous: '<i class="ti ti-chevron-left ti-sm"></i>' }
                }
            });

            $('.btn-filter').on('click', () => table.ajax.reload());
            $('#status-filter').on('change', () => table.ajax.reload());
            $('#keyword').on('keyup', function (event) { if (event.key === 'Enter' || !this.value) table.ajax.reload(); });

            tableElement.on('change', '.contact-status', function () {
                const select = $(this);
                select.prop('disabled', true);
                $.ajax({
                    url: $('#url-update').val().replace('_id', select.data('id')),
                    type: 'PATCH', data: { _token: csrf, status: select.val() },
                    success: response => toastr.success(response.message),
                    error: () => { toastr.error('Could not update the status.'); table.ajax.reload(null, false); },
                    complete: () => select.prop('disabled', false)
                });
            });

            tableElement.on('click', '.btn-detail', function () {
                const row = table.row($(this).closest('tr')).data();
                const phone = row.phone ? `${row.phone_country || ''} ${row.phone}`.trim() : '';
                $('.contact-detail-name').text(row.full_name || 'Customer');
                $('.contact-detail-date').text(`Submitted ${row.created_at || ''}`);
                $('.contact-detail-email').text(row.email || 'Not provided').attr('href', row.email ? `mailto:${row.email}` : null);
                $('.contact-detail-phone').text(phone || 'Not provided').attr('href', phone ? `tel:${phone.replace(/[^+\d]/g, '')}` : null);
                $('.contact-detail-project').text(projectLabels[row.project_type] || row.project_type || '—');
                $('.contact-detail-budget').text(budgetLabels[row.budget] || row.budget || 'Not selected');
                $('.contact-detail-message').text(row.message || '');
                $('#contact-detail-modal').modal('show');
            });
        });
    </script>
@endpush

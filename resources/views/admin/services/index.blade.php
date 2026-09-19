@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <style>.service-thumb{width:104px;height:68px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb}.dt-action-buttons{margin-top:1.5em!important}</style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.layouts.partials.messages')
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Homepage services</h5>
                <div class="row pt-4 g-3">
                    <div class="col-md-5"><input class="form-control" id="keyword" placeholder="Search by service name"></div>
                    <div class="col-md-3"><select class="form-select" id="active-filter"><option value="">All statuses</option><option value="1">Visible</option><option value="0">Hidden</option></select></div>
                    <div class="col-md-2"><button class="btn btn-success btn-filter" type="button"><i class="ti ti-filter"></i> Filter</button></div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="dt-services table text-nowrap"><thead class="border-top"><tr><th></th><th>No.</th><th>Image</th><th>Service name</th><th>Position</th><th>Status</th><th>Actions</th></tr></thead></table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-destroy" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Delete service</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body text-center"><form id="form-destroy" method="POST">@csrf @method('DELETE')<p class="modal-title-destroy fs-4 fw-bold mb-1"></p><p class="text-muted">Deleted data cannot be recovered.</p></form></div>
        <div class="modal-footer justify-content-center"><button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger btn-destroy-modal">Delete</button></div>
    </div></div></div>

    <input type="hidden" id="url-datatable" value="{{ route('admin.services.datatables') }}">
    <input type="hidden" id="url-create" value="{{ route('admin.services.create') }}">
    <input type="hidden" id="url-edit" value="{{ route('admin.services.edit', ['id' => '_id']) }}">
    <input type="hidden" id="url-destroy" value="{{ route('admin.services.destroy', ['id' => '_id']) }}">
    <input type="hidden" id="default-image" value="{{ asset('assets/imgs/default.png') }}">
    <input type="hidden" id="storage-base" value="{{ Storage::url('') }}">
    <input type="hidden" id="user-permissions" value="{{ json_encode($permissions) }}">
@endsection

@push('js')
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function () {
            const permissions = JSON.parse($('#user-permissions').val() || '[]');
            const tableElement = $('.dt-services');
            const table = tableElement.DataTable({
                processing:true,serverSide:true,ordering:false,searching:false,scrollX:true,
                ajax:{url:$('#url-datatable').val(),data:data=>{data.keyword=$('#keyword').val()||'';data.active=$('#active-filter').val();}},
                columns:[
                    {data:'id',orderable:false,searchable:false,render:()=>'<input type="checkbox" class="form-check-input">'},
                    {data:null,render:(data,type,row,meta)=>meta.settings._iDisplayStart+meta.row+1},
                    {data:'avatar',render:(avatar,type,row)=>{const image=!avatar?$('#default-image').val():(avatar.startsWith('assets/')?'/'+avatar:$('#storage-base').val()+avatar);return `<img src="${image}" class="service-thumb" alt="${$('<div>').text(row.name||'').html()}">`; }},
                    {data:'name',render:(name,type,row)=>`<a class="text-primary fw-medium" href="${$('#url-edit').val().replace('_id',row.id)}">${$('<div>').text(name||'').html()}</a><small class="d-block text-muted">${$('<div>').text(row.name_vi||'').html()}</small>`},
                    {data:'position'},
                    {data:'active',render:active=>active?'<span class="badge bg-label-success">Visible</span>':'<span class="badge bg-label-secondary">Hidden</span>'},
                    {data:'action',render:(data,type,row)=>{let html='<div class="d-flex">';if(permissions.includes('admin.services.edit'))html+='<a href="javascript:;" class="btn btn-icon btn-text-secondary btn-edit"><i class="ti ti-edit"></i></a>';if(permissions.includes('admin.services.destroy'))html+='<a href="javascript:;" class="btn btn-icon btn-text-secondary btn-destroy"><i class="ti ti-trash"></i></a>';return html+'</div>';}}
                ],
                dom:'<"row"<"col-md-2"l><"col-md-10"<"dt-action-buttons text-end d-flex justify-content-end mb-6 mt-n6"B>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons:permissions.includes('admin.services.create')?[{text:'<i class="ti ti-plus me-1"></i>Create new',className:'btn btn-primary btn-add'}]:[],
                language:{emptyTable:'No services yet',zeroRecords:'No services found',processing:'Loading...',info:'Showing _START_ to _END_ of _TOTAL_ services',paginate:{next:'›',previous:'‹'}}
            });
            $('.btn-filter').on('click',()=>table.ajax.reload());
            $('#keyword').on('keyup',function(event){if(event.key==='Enter'||!this.value)table.ajax.reload();});
            $(document).on('click','.btn-add',()=>location.href=$('#url-create').val());
            tableElement.on('click','.btn-edit',function(){const row=table.row($(this).closest('tr')).data();location.href=$('#url-edit').val().replace('_id',row.id);});
            tableElement.on('click','.btn-destroy',function(){const row=table.row($(this).closest('tr')).data();$('.modal-title-destroy').text(`Are you sure you want to delete “${row.name}”?`);$('#form-destroy').attr('action',$('#url-destroy').val().replace('_id',row.id));$('#modal-destroy').modal('show');});
            $('.btn-destroy-modal').on('click',function(){const form=$('#form-destroy');$.ajax({url:form.attr('action'),type:'DELETE',data:form.serialize(),success:response=>{$('#modal-destroy').modal('hide');toastr.success(response.message);table.ajax.reload(null,false);},error:()=>toastr.error('Could not delete the service.')});});
        });
    </script>
@endpush

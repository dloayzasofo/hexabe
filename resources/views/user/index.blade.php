@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Miembros
            </h4>
        </div>
        <div class="col-sm-4 col-md-6">
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> 
                    <a href="{{route('user.create')}}" class="dt-button create-new btn btn-primary">
                        <span><i class="bx bx-plus me-sm-2"></i> 
                            <span class="d-none d-sm-inline-block">Agregar</span>
                        </span>
                    </a> 
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('user.delete'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('user.delete') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header">
                   
                </div>
                <div class="card-datatable text-nowrap">
                    <div class="fobo-datatable table-responsive text-nowrap">
                        <table id="datatable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Rol</th>
                                    <th>Área</th>
                                    <th>Equipos</th>
                                    <th>Creado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user._modal_delete')
@endsection

@section('script')
<link rel="stylesheet" href="{{ asset('/assets/admin/js/datatable/datatable.min.css') }}">
<script src="{{ asset('/assets/admin/js/datatable/datatable.min.js') }}"></script>

<script>
    var meDataTable = null;
    $(document).ready(function(){
        var url = "{{ route('user.list') }}";

        meDataTable = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            //aaStoring: [
            order: [
                [4, 'desc']
            ],
            columnDefs: [
                { orderable: false, targets: [3,4,5]}
            ],
            ajax: {
                url: url,
                type: 'POST',
            },
            columns: [
                { data: 'name' },
                { data: 'role' },
                { data: 'position' },
                { data: 'teams' },
                { data: 'created_at' },
                { data: 'actions' },
            ],
        });

        $(document).on('click', '.userActionToggle', userActionToggle);
    });

    function userActionToggle(){
        var url = $(this).attr('data-href');
        $.ajax({
            url: url,
            type: 'get',
            success: function(data){
                meDataTable.ajax.reload();
            },
            error: function(err){
                alert("ERROR: De conexión\nOcurrió un error al intentar conectarse al servidor.\n" + err.message);
            }
        });
    }
</script>
@endsection
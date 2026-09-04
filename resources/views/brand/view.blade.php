@extends('layout')

@section('main')
    <div class="btn-add-task"> 
        <button id="btnCreate" class="btn btn-primary" title="Crear nueva tarea">
            <span><i class="bx bx-plus"></i></span> Crear tarea
        </button> 
    </div>

    @if(Session::has('brand.success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('brand.success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif

    @if(Session::has('task.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('task.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    @if(Session::has('brand.error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ Session::get('brand.error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <div class="d-flex align-items-center w-100">
                <div class="p-2 me-sm-2 rounded" style="background:#fff;">
                    <img src="{{ $brand->image }}" style="height:64px;">
                </div>
                <div>
                    <h4 class="fw-bold" style="margin-bottom:4px;"> {{ $brand->name }} </h4>
                    <small>{{ $brand->industry }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-end">
            @hasanyrole('SUPER|ADMIN')
            <button id="btnEdit" data-href="{{ route('brand.edit', [$brand]) }}" class="dt-button create-new btn btn-primary brand-item">
                <span><i class="bx bx-edit me-sm-2"></i> 
                    <span class="d-none d-sm-inline-block">Editar marca</span>
                </span>
            </button>

            <button type="button" class="btn btn-label-danger confirmDelete" title="Eliminar marca"
                data-href="{{ route('brand.delete', [$brand]) }}"
                data-message="la marca <b> {{ $brand->name }} </b>.">
                <i class="icon-base bx bx-trash icon-md"></i> 
            </button>
            @endhasanyrole
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Tareas Totales</span>
                <h4 class="card-title mb-0 fw-bold">{{ $brand->total_tasks }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                    <span class="d-block fw-medium mb-1">Progreso General</span>
                    <div class="d-flex align-items-center">
                        <div class="pe-2">
                            <h4 class="card-title mb-0 fw-bold">{{ $brand->progress == -1 ? 0 : $brand->progress }}%</h4>
                        </div>
                        <div>
                            <div class="progress" style="height:8px;margin:auto;padding:0px;width:100px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $brand->progress }}%;background:@if($brand->progress >= 85) #22C55E; @elseif ($brand->progress >= 50) #EAB308; @else #EF4444; @endif;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Miembros Activos</span>
                <h4 class="card-title mb-0 fw-bold">{{ count($members) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8">
            <div style="margin-bottom:13px;">
                <h5 class="fw-bold" style="margin-bottom:4px;"> Tareas Recientes </h5>
            </div>
            @if( count($lastTasks) > 0 )
                <div id="listTasks">
                    @foreach ($lastTasks as $task)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-10">
                                    <div class="d-flex align-items-center w-100">
                                        <spam class="fw-bold">{{ $task->brand->name }}</spam>
                                    </div>
                                    <div class="fw-bold mt-2">
                                        <a href="{{ route('task.view', [$task]) }}"> {{ $task->title }} </a>
                                    </div>
                                    <div class="mt-2">
                                        <div class="d-flex">
                                            <div class="@if( count($task->collaborators) > 0 ) ps-2 @endif">
                                                @if( isset($task->date_ini) && $task->date_ini )
                                                    <small class="me-2"><i class="icon-base bx bx-calendar"></i> Inicia: {{ \Carbon\Carbon::parse($task->date_ini)->format('d/m/Y H:i') }} </small>
                                                @endif
                                                <small>
                                                    @if( $task->assign->image )
                                                        <img src="{{ $task->assign->image }}" alt="Avatar" class="rounded-circle pull-up" style="width:25px;height:25px;">
                                                    @else
                                                        <span class="avatar-initial rounded-circle bg-label-danger" style="width:25px;height:25px;display:inline-block;text-align:center;padding-top:3px;">{{ $task->assign->nameInitial }}</span>
                                                    @endif 
                                                    Responsable: {{ $task->assign->name }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    {{--<span class="badge rounded-pill bg-label-primary">Primary</span>--}}
                                    <span class="badge rounded-pill @if($task->status == 'TOSTART') bg-label-warning @elseif($task->status == 'PROCESS') bg-label-info @elseif($task->status == 'FINALIZED') bg-label-success @elseif($task->status == 'DELAY') bg-label-danger @elseif($task->status == 'PAUSED') bg-label-danger @endif">
                                        @switch($task->status)
                                            @case('TOSTART')
                                                Sin empezar
                                                @break
                                            @case('PROCESS')
                                                En proceso
                                                @break
                                            @case('FINALIZED')
                                                Finalizado
                                                @break
                                            @case('DELAY')
                                                Retrasado
                                                @break
                                            @case('PAUSED')
                                                Pausado
                                                @break
                                            @default
                                        @endswitch
                                    </span>
                                    @if( $task->progress >= 0 )
                                    <div class="progress" style="height:8px;margin-left:auto;margin-right:0px;padding:0px;width:100px;margin-top:8px;">
                                        <div class="progress-bar" role="progressbar" style="width:{{ $task->progress }}%;background:@if($task->progress >= 85) #22C55E; @elseif ($task->progress >= 50) #EAB308; @else #EF4444; @endif" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="task-pagination">
                {{ $lastTasks->links('pagination') }}
                </div>
            @endif
            @if( count($lastTasks) == 0 )
                <div class="card-body">
                    <p class="text-center mb-0">No hay tareas recientes.</p>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h5 class="fw-bold" style="margin-bottom:4px;"> Equipo </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('team.index') }}" class="fw-bold text-warning">Gestionar</a>
                </div>
            </div>
            <div class="card">
                @foreach( $brand->members as $member )
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    @if( $member->image )
                                        <img src="{{ $member->image }}" alt="Avatar" class="rounded-circle">
                                    @else
                                        <span class="avatar-initial rounded-circle bg-label-danger">{{ $member->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('task.user.list', [$member]) }}" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $member->name }}</span>
                                </a>
                                <small>{{ $member->email }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                        </div>
                    </div>
                </div>
                <hr class="m-0">
                @endforeach

                @if( count($brand->members) == 0 )
                    <div class="card-body">
                        <p class="text-center mb-0">No hay miembros en esta marca.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade " id="modalCenter" tabindex="-1" aria-modal="true" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title fw-bold" id="modalTitle">Actualizar marca</h5>
                        <div id="modalDescription">Actualización de datos.</div>
                    </div>

                </div>
                <div id="popup">

                </div>
            </div>
        </div>
    </div>

    @include('brand._modal_delete')
@endsection

@section('script')
@hasanyrole('SUPER|ADMIN')
<script src="{{asset('/assets/admin/js/dropzone.js')}}"></script>
<script>
    let modeBrand = 'EDIT';
    //let urlCreate = "{{ route('brand.create') }}";
    window.addEventListener('load', () => {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btnSaveBrand')) {
                handleCreateBrand();
            }
        });

        let brandItems = document.querySelectorAll('.brand-item');
        brandItems.forEach(brandItem => {
            brandItem.addEventListener('click', handleEdit);
        });
    });

    function handleCreateBrand(){
        let form = document.querySelector('#formBrandCreate');
        let url = form.getAttribute('data-action');

        let name = document.querySelector('#name');
        let token = document.getElementsByName("_token")[0];
        let industry = document.querySelector('#industry');
        let description = document.querySelector('#description');
        let image = document.querySelector('#image');

        var data = new FormData()
        data.append('_token', token.value);
        data.append('name', name.value);
        data.append('industry', industry.value);
        data.append('description', description.value);
        if( image.files.length > 0 ){
            data.append('image', image.files[0]);
        }

        if( validateForm() == false ){
            return false;
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: data
        })
        .then(response => response.json())
        .then(data => {
            if( data.success){
                $('#modalCenter').modal('hide');
                location.reload();
            }
            if( data.errors){
                handleShowErrors(data.errors);
            }
        });
    }

    function handleShowErrors(errors){
        if( errors.name ){
            showError('name', errors.name[0]);
        }
        if( errors.industry ){
            showError('industry', errors.industry[0]);
        }
        if( errors.description ){
            showError('description', errors.description[0]);
        }
        if( errors.image ){
            showError('image', errors.image[0]);
        }
    }

    function validateForm(){
        clearErrors();

        let name = document.querySelector('#name');
        let industry = document.querySelector('#industry');
        let description = document.querySelector('#description');
        let image = document.querySelector('#image');
        let isOk = true;

        if( !name.value ){
            showError('name', 'El campo es requerido');
            isOk = false;
        }

        if( !industry.value ){
            showError('industry', 'El campo es requerido');
            isOk = false;
        }

        //if( !description.value ){
        //    showError('description', 'El campo es requerido');
        //    isOk = false;
        //}

        if( modeBrand == 'CREATE' && !image.value ){
            showError('image', 'El campo es requerido');
            isOk = false;
        }else{
            if( image.files.length > 0 ){
                const sizeInBytes = image.files[0].size;
                const sizeInMB = (sizeInBytes / (1024 * 1024)).toFixed(2);
                if( sizeInMB > 1 ){
                    showError('image', 'El peso del archivo debe ser menor a 1MB');
                    isOk = false;
                }
            }
        }
        return isOk;
    }

    function clearErrors(){
        document.querySelector('#name').classList.remove('is-invalid');
        document.querySelector('#industry').classList.remove('is-invalid');
        document.querySelector('#description').classList.remove('is-invalid');
        document.querySelector('#image').classList.remove('is-invalid');

        document.querySelector('#errorName').innerHTML = '';
        document.querySelector('#errorIndustry').innerHTML = '';
        document.querySelector('#errorDescription').innerHTML = '';
        document.querySelector('#errorImage').innerHTML = '';
    }

    function showError(elementName, error){
        document.querySelector('#' + elementName).classList.add('is-invalid');
        elementName = elementName.charAt(0).toUpperCase() + elementName.slice(1);
        document.querySelector('#error' + elementName).innerHTML = error;
    }

    function handleEdit(){
        let url = this.getAttribute('data-href');
        console.log(url);
        fetch(url)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#popup').innerHTML = data;
            document.querySelector('#modalTitle').innerHTML = 'Actualizar marca';
            document.querySelector('#modalDescription').innerHTML = 'Actualización de datos.';
            $('#modalCenter').modal('show');
            modeBrand = 'EDIT';
            var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
        });
    }
</script>
@endhasanyrole


<link href="{{ asset('/assets/admin/js/quilljs/quill.css') }}" rel="stylesheet">
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<script src="{{ asset('/assets/admin/js/quilljs/quill.js') }}"></script>
<script src="{{asset('/assets/admin/js/mieditor.js')}}"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>let urlCreate = "{{ route('task.brand', [$brand]) }}";</script>
<script src="{{asset('/assets/admin/js/task.js')}}"></script>

<script>
    document.addEventListener('click', handlePaginationPage);

    function handlePaginationPage(e){
        if( e.target.classList.contains('pagination-item') ){
            e.preventDefault();
            let url = e.target.getAttribute('href');
            getAjaxPaginate(url);
        }
    }

    function getAjaxPaginate(url){
        fetch(url,{
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                //'Content-Type': 'application/json',
                //'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.querySelector('.task-pagination').innerHTML = data.pagination;
            renderTasks(data.tasks.data)

            //let parser = new DOMParser();
            //let doc = parser.parseFromString(data, 'text/html');
            //let lastTasks = doc.querySelector('#lastTasks');
            //document.querySelector('#lastTasks').innerHTML = lastTasks.innerHTML;
        });
    }

    function renderTasks(data){
        let listTasks = document.querySelector('#listTasks');
        let html = '';
        let url = "{{ route('task.view', ['id']) }}";

        for(let i=0; i < data.length; i++){
            let item = data[i];
            let taskUrl = url.replace('id', item.id);

            let dateIni = item.date_ini ? new Date(item.date_ini) : null;
            let dateIniElement = '';
            if( dateIni ){
                dateIniElement = `<small class="me-2"><i class="icon-base bx bx-calendar"></i> Inicia: ${dateIni.toLocaleDateString()} ${dateIni.toLocaleTimeString()}</small>`;
            }

            let avatar = `<span class="avatar-initial rounded-circle bg-label-danger" style="width:25px;height:25px;display:inline-block;text-align:center;padding-top:3px;">${item.assign.nameInitial}</span>`;
            if( item.assign.image ){
                avatar = `<img src="${item.assign.image}" alt="Avatar" class="rounded-circle pull-up" style="width:25px;height:25px;">`;
            }

            let statusName = 'Por empezar';
            switch(item.status){
                case 'PROCESS':
                    statusName = 'En Proceso';
                    break;
                case 'DELAY':
                    statusName = 'Retrasado';
                    break;
                case 'PAUSED':
                    statusName = 'Pausado';
                    break;
            }

            let progessHtml = '';
            if( item.progress >= 0 ){
                progessHtml = `
                    <div class="progress" style="height:8px;margin-left:auto;margin-right:0px;padding:0px;width:100px;margin-top:8px;">
                        <div class="progress-bar" role="progressbar" style="width:${item.progress}%;background:${item.progress >= 85 ? '#22C55E' : item.progress >= 50 ? '#EAB308' : '#EF4444'}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                `;
            }

            html += `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <div class="d-flex align-items-center w-100">
                                    <spam class="fw-bold">{{ $brand->name }}</spam>
                                </div>
                                <div class="fw-bold mt-2">
                                    <a href="${ taskUrl }"> ${ item.title } </a>
                                </div>
                                <div class="mt-2">
                                    <div class="d-flex">
                                        <div>
                                            ${dateIniElement}
                                            <small>
                                                ${ avatar }
                                                Responsable: ${ item.assign.name }
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="badge rounded-pill 
                                    ${ item.status == 'TOSTART' ? 'bg-label-warning' : '' } 
                                    ${ item.status == 'PROCESS' ? 'bg-label-info' : '' }
                                    ${ item.status == 'DELAY' ? 'bg-label-danger' : '' }
                                    ${ item.status == 'PAUSED' ? 'bg-label-danger' : '' }">
                                    ${ statusName }
                                </span>
                                ${ progessHtml }
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        listTasks.innerHTML = html;
    }
</script>
@endsection
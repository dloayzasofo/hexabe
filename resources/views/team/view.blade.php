@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <div class="d-flex align-items-center w-100">
                <div class="p-2 me-sm-2 rounded" style="background:#fff;">
                    <img src="{{ $team->image }}" style="height:64px;">
                </div>
                <div>
                    <h4 class="fw-bold" style="margin-bottom:4px;"> {{ $team->name }} </h4>
                    <small>{{ $team->description }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <button id="btnEdit" data-href="{{ route('team.edit', [$team]) }}" class="dt-button create-new btn btn-primary team-item">
                <span><i class="bx bx-edit me-sm-2"></i> 
                    <span class="d-none d-sm-inline-block">Editar equipo</span>
                </span>
            </button>
        </div>
    </div>

    @if(Session::has('team.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('team.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    @if(Session::has('team.invitation.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('team.invitation.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                    <div class="d-flex justify-content-between align-items-center card-widget-2 pb-4 pb-sm-0">
                        <div>
                            <p class="mb-0">Miembros activos</p>
                        </div>
                        <div class="avatar me-lg-6 w-px-42 h-px-42">
                            <span class="avatar-initial rounded bg-label-success text-heading">
                                <i class="icon-base bx bx-user icon-26px"></i>
                            </span>
                        </div>
                    </div>
                    <h4 class="card-title mb-0 fw-bold">{{ $team->members->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                    <div class="d-flex justify-content-between align-items-center card-widget-2 pb-4 pb-sm-0">
                        <div>
                            <p class="mb-0">Tareas en curso</p>
                        </div>
                        <div class="avatar me-lg-6 w-px-42 h-px-42">
                            <span class="avatar-initial rounded bg-label-primary text-heading">
                                <i class="icon-base bx bx-time-five icon-26px"></i>
                                <i class="bx bx-future"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-end">
                        <div class="pe-2">
                            <h4 class="card-title mb-0 fw-bold">{{ $team->total_tasks }}</h4>
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size:12px;color:#0052CC;">
                                {{ $team->progress == -1 ? "0" : $team->progress }} % completado
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                    <div class="d-flex justify-content-between align-items-center card-widget-2 pb-4 pb-sm-0">
                        <div>
                            <p class="mb-0">Marcas activas</p>
                        </div>
                        <div class="avatar me-lg-6 w-px-42 h-px-42">
                            <span class="avatar-initial rounded bg-label-warning text-heading">
                                <i class="icon-base bx bx-rocket icon-26px"></i>
                            </span>
                        </div>
                    </div>

                    <h4 class="card-title mb-0 fw-bold">{{ $team->teambrand->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h5 class="fw-bold" style="margin-bottom:4px;"> Miembros ({{ $team->members->count() }})</h5>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-text-dark fw-semibold" data-bs-toggle="modal" data-bs-target="#modalInvite" style="padding-right:0px;padding-top:0px;">+ Invitar</button>
                </div>
            </div>
            <div class="card">
                @foreach( $team->members as $member )
                <div id="member-{{ $member->id }}" class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    @if( $member->image )
                                        <img src="{{ asset($member->image) }}" alt="Avatar" class="rounded-circle">
                                    @else
                                        <span class="avatar-initial avatar-xs rounded-circle">{{ $member->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $member->name }}</span>
                                </a>
                                <small>{{ $member->email }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <button data-href="{{ route('team.remove.user', ['team'=> $team, 'user'=> $member]) }}" class="btn btn-sm confirmDelete"
                                data-message="al usuario <b>{{$member->name}}</b> de este equipo.">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @if($loop->last == false)
                    <hr class="m-0">
                @endif
                @endforeach

                @if( count($team->members) == 0 )
                    <div class="card-body">
                        <p class="text-center mb-0">No hay miembros en este equipo.</p>
                    </div>
                @endif
            </div>

            <div class="row mb-2 mt-5">
                <div class="col-md-6">
                    <h5 class="fw-bold" style="margin-bottom:4px;"> Marcas ({{ $team->teambrand->count() }})</h5>
                </div>
                <div class="col-md-6 text-end">
                    <button data-href="{{ route('team.edit', [$team]) }}" class="btn btn-text-dark fw-semibold team-item" style="padding-right:0px;padding-top:0px;">+ Agregar</button>
                </div>
            </div>
            <div class="card">
                @foreach( $team->teambrand as $teambrand )
                <div id="brand-{{ $teambrand->brand->id }}" class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    @if( $teambrand->brand->image )
                                        <img src="{{ asset($teambrand->brand->image) }}" alt="Avatar" class="rounded-circle">
                                    @else
                                        <span class="avatar-initial avatar-xs rounded-circle">{{ $teambrand->brand->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $teambrand->brand->name }}</span>
                                </a>
                                <small>{{ $teambrand->brand->industry }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <button data-href="{{ route('team.remove.brand', ['team'=> $team, 'brand'=> $teambrand->brand]) }}" class="btn btn-sm confirmDelete"
                                data-message="la marca <b>{{$teambrand->brand->name}}</b> de este equipo.">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @if($loop->last == false)
                    <hr class="m-0">
                @endif
                @endforeach

                @if( count($team->teambrand) == 0 )
                    <div class="card-body">
                        <p class="text-center mb-0">No hay marcas en este equipo.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div style="margin-bottom:13px;">
                <h5 class="fw-bold" style="margin-bottom:4px;"> Tareas recientes </h5>
            </div>
            @foreach ($lastTasks as $task)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center w-100">
                                <span class="badge rounded-pill @if($task->priority == 'medium') bg-label-warning @elseif($task->priority == 'low') bg-label-primary @elseif($task->priority == 'high') bg-label-danger @endif">
                                    @switch($task->priority)
                                        @case('high')
                                            Alta
                                            @break
                                        @case('medium')
                                            Media
                                            @break
                                        @case('low')
                                            Baja
                                            @break
                                        @default
                                    @endswitch
                                </span>
                                <spam class="fw-bold ps-2">{{ $task->brand->name }}</spam>
                            </div>
                            <div class="fw-bold mt-2">
                                <a href="{{ route('task.view', [$task]) }}"> {{ $task->title }} </a>
                            </div>
                            <div class="mt-2">
                                <div class="d-flex">
                                    @if( count($task->collaborators) > 0 )
                                    <div class="avatar-group d-flex align-items-center assigned-avatar">
                                        @foreach( $task->collaborators as $collaborator )
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="{{ $collaborator->user->name }}" data-bs-original-title="{{ $collaborator->user->name }}">
                                            @if( $collaborator->user->image )
                                                <img src="{{ $collaborator->user->image }}" alt="Avatar" class="rounded-circle pull-up">
                                            @else
                                                 <span class="avatar-initial rounded-circle bg-label-danger">{{ $collaborator->user->nameInitial }}</span>
                                            @endif
                                        </div>
                                        @endforeach
                                        {{-- 
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Clark" data-bs-original-title="Clark">
                                            <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                        --}}
                                    </div>
                                    @endif
                                    <div class="@if( count($task->collaborators) > 0 ) ps-2 @endif">
                                        <small class="me-2"><i class="icon-base bx bx-calendar"></i> Entrega: {{ $task->register_at }}</small>
                                        <small><i class="icon-base bx bx-user"></i> Responsable: {{ $task->assign->name }}</small>
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

            @if( count($lastTasks) == 0 )
                <div class="card-body">
                    <p class="text-center mb-0">No hay tareas recientes.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade " id="modalCenter" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title fw-bold" id="modalTitle"></h5>
                        <div id="modalDescription"></div>
                    </div>                    
                </div>
                <div id="popup"></div>
            </div>
        </div>
    </div>

	<div class="modal fade" id="modalInvite" tabindex="-1" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					<div>
						<h5 class="modal-title fw-bold">Invitar miembros</h5>
						<div>Envía una invitación a nuevos colaboradores para que se unan a tu equipo.</div>
					</div>                    
				</div>
				<div id="popupInvite">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Dirección de correo electrónico</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" style="background:#F8FAFC;"><i class="icon-base bx bx-envelope"></i></span>
                                <div class="result input-search-result previewItems"></div>
                                <input type="text" class="form-control input-user-search3 inputSearch" id="inviteEmail" placeholder="ejemplo@correo.com">
                            </div>
                        </div>
                    
                        <div class="mb-4">
                            <label class="form-label">Rol</label>
                            <select name="" id="inviteRole" class="form-select">
                                <option value="USER">Miembro</option>
                                <option value="EXTERNAL">Invitado (Cliente)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button data-href="{{ route('team.invitation') }}" id="btnInvite" type="button" class="btn btn-primary">Enviar invitación</button>
                    </div>
                </div>
			</div>
		</div>
	</div>
    @include('team._modal_delete')
@endsection

@section('script')
<script src="{{asset('/assets/admin/js/dropzone.js')}}"></script>
<script>
    let mode = 'EDIT';
    let urlCreate = "{{ route('team.create') }}";

    window.addEventListener('load', () => {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btnSave')) {
                handleCreateServer();
            }
        });

        let teamItems = document.querySelectorAll('.team-item');
        teamItems.forEach(teamItem => {
            teamItem.addEventListener('click', handleEdit);
        });
    });

    function handleCreateServer(){
        let form = document.querySelector('#formCreate');

        let url = form.getAttribute('data-action');
        let token = document.getElementsByName("_token")[0];
        let name = document.querySelector('#name');
        let description = document.querySelector('#description');
        let status = document.querySelector('#status');

        if( validateForm() == false ){
            return false;
        }

        var data = new FormData();
        data.append('_token', token.value);
        data.append('name', name ? name.value : '');
        data.append('description', description ? description.value : '');
        data.append('status', status ? status.value : '0');
        if( image.files.length > 0 ){
            data.append('image', image.files[0]);
        }

        const memberInputs = document.querySelectorAll('input[name="members[]"]');
        memberInputs.forEach((input) => {
            data.append('members[]', input.value);
        });
        const brandInputs = document.querySelectorAll('input[name="brands[]"]');
        brandInputs.forEach((input) => {
            data.append('brands[]', input.value);
        });

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
        if( errors.description ){
            showError('description', errors.description[0]);
        }
        if( errors.members ){
            showError('members', errors.members[0]);
        }
    }

    function validateForm(){
        clearErrors();

        let name = document.querySelector('#name');
        let isOk = true;

        if( !name || !name.value ){
            showError('name', 'El campo es requerido');
            isOk = false;
        }

        const memberInputs = document.querySelectorAll('input[name="members[]"]');
        if( memberInputs.length == 0){
            document.querySelector('#selectedMembers').classList.add('is-invalid');
            document.querySelector('#errorMembers').innerHTML = 'Ingresa almenos un miembro al equipo';
            isOk = false;
        }

        if( mode == 'CREATE' && !image.value ){
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
        const fields = ['name', 'description', 'members'];
        fields.forEach((field) => {
            const el = document.querySelector('#' + field);
            if (el) el.classList.remove('is-invalid');
            const err = document.querySelector('#error' + field.charAt(0).toUpperCase() + field.slice(1));
            if (err) err.innerHTML = '';
        });
    }

    function showError(elementName, error){
        const el = document.querySelector('#' + elementName);
        if (el) el.classList.add('is-invalid');
        const label = elementName.charAt(0).toUpperCase() + elementName.slice(1);
        const err = document.querySelector('#error' + label);
        if (err) err.innerHTML = error;
    }

    function handleEdit(){
        let url = this.getAttribute('data-href');
        fetch(url)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#popup').innerHTML = data;
            document.querySelector('#modalTitle').innerHTML = 'Actualizar equipo';
            document.querySelector('#modalDescription').innerHTML = 'Actualización de datos.';
            $('#modalCenter').modal('show');
            mode = 'EDIT';
            //setupMemberSearch();
            var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
            bindSearchInputAjax();
        });
    }
</script>

<script>
    window.addEventListener('load', () => {
        let searchServers = document.querySelectorAll('.serverSearch');
        searchServers.forEach(searchServer => {
            bindElementeToServerSearch(searchServer);
        });
    });

    function bindSearchInputAjax(){
        let searchServers = document.querySelectorAll('.serverSearch');
        searchServers.forEach(searchServer => {
            bindElementeToServerSearch(searchServer);
        });
    }

    function bindElementeToServerSearch(element){
        let preview = element.querySelector('.previewItems');
        let inputSearch = element.querySelector('.inputSearch');
        let resultItems = element.querySelector('.resultItems');
        let urlSearch = element.getAttribute('data-href');
        let type = element.getAttribute('data-type');

        inputSearch.addEventListener('keydown', (e) => {
            console.log('urlSearch');
            if (e.target.value.length < 2){
                resultItems.classList.remove('active');
                return;
            }
            searchServerByKey(e.target.value);
        });

        function searchServerByKey(value){
            fetch(urlSearch + '?q=' + value, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    return;
                }
                handlerRenderServerByKey(data.data);
            })
            .catch((e) => {
                console.log("Error Catch", e);
            });
        }

        function handlerRenderServerByKey(data){
            preview.innerHTML = '';
            if( data.length == 0 ){
                preview.classList.remove('active');
                return;
            }

            data.forEach(model => {
                const existing = resultItems.querySelector('input[value="' + model.id + '"]');
                if ( existing == null ) {
                    let div = document.createElement('div');
                    
                    if( model.image ) {
                        div.innerHTML = '<img src="' + model.image + '" class="avatar avatar-xs rounded-circle"/> ' + model.name;
                    }else{
                        div.innerHTML = '<span>' + model.initials + '</span> ' + model.name;
                    }

                    div.classList.add('input-search-result-item');
                    div.addEventListener('click', () => {
                        addSelectedServerItem(model);
                        preview.classList.remove('active');
                        inputSearch.value = '';
                    });
                    preview.appendChild(div);
                }
            });

            if( preview.innerHTML != '' ){
                preview.classList.add('active');
            }
        }

        function addSelectedServerItem(model){
            if (!resultItems) return;

            const existing = resultItems.querySelector('input[value="' + model.id + '"]');
            if (existing) {
                return;
            }

            const pill = document.createElement('span');
        
            let avatar = '';
            if( model.image ) {
                avatar = '<img src="' + model.image + '" class="avatar avatar-xs rounded-circle"/> ' + model.name;
            }else{
                avatar = '<span>' + model.initials + '</span> ' + model.name;
            }

            pill.className = 'badge rounded-pill selected-member-pill';
            pill.style.display = 'inline-flex';
            pill.style.alignItems = 'center';
            pill.style.gap = '0.3rem';
            pill.innerHTML = `${avatar} <button type="button" class="btn-close remove-member" aria-label="Remove"></button>`;

            const inputHidden = document.createElement('input');
            inputHidden.type = 'hidden';
            inputHidden.name = type + '[]';
            inputHidden.value = model.id;
            pill.appendChild(inputHidden);

            resultItems.appendChild(pill);
        }
        
        resultItems.addEventListener('click', (evt) => {
            const btn = evt.target.closest('.remove-member');
            if (!btn) return;
            const pill = btn.closest('.selected-member-pill');
            if (pill) pill.remove();
        });
    }
    
</script>

<script>
    window.addEventListener('load', () => {
        console.log("LOAD");
        let btnInvite = document.querySelector('#btnInvite');
        if( btnInvite ){
            btnInvite.addEventListener('click', handleInvite);
        }
    });

    function handleInvite(){
        let url = this.getAttribute('data-href');
        let email = document.querySelector('#inviteEmail').value;
        let role = document.querySelector('#inviteRole').value;


        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                _token: '{{ csrf_token() }}',
                email: email,
                role: role,
                team_id: {{ $team->id }}
            })
             
        })
        .then(response => response.text())
        .then(data => {
            //console.log(data);
            location.reload();

            //document.querySelector('#popup').innerHTML = data;
            //document.querySelector('#modalTitle').innerHTML = 'Invitar equipo';
            //document.querySelector('#modalDescription').innerHTML = 'Invitación de equipo.';
            //$('#modalCenter').modal('show');
        });
    }


</script>
@endsection
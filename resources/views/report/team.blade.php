@extends('layout')

@section('main')
    <div class="wrap-toast"></div>
    <div class="loading hide">
        <div class="spinner-border spinner-border-lg text-primary" role="status">
            <span class="visually-hidden"></span>
        </div>
        <div class="mt-2">
            Cargando...
        </div>
    </div>

    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <div class="d-flex align-items-center w-100">
                <div>
                    <h4 class="fw-bold" style="margin-bottom:4px;"> Carga de trabajo </h4>
                    <small>Monitorea carga de trabajo de un equipo o un usuario.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6>Filtros:</h6>
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <label class="switch switch-primary">
                        <input id="type" type="checkbox" name="type" class="switch-input" checked="">
                        <span class="switch-label" style="padding-left:0px;">Equipo</span>
                        <span class="switch-toggle-slider">
                            <span class="switch-on">
                                <i class="icon-base bx bx-check"></i>
                            </span>
                        </span>
                        <span class="switch-label">Usuario</span>
                    </label>
                </div>
                <div id="wrapTeam" class="me-3 hide">
                    <select name="team" id="team" class="form-select">
                        <option value="">Seleccione equipo</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="wrapUser" class="me-3">
                    <select name="user" id="user" class="form-select">
                        <option value="">Seleccione usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="me-3">
                    <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="form-control">
                </div>
                <div>
                    <button id="btnFilter" class="btn rounded-pill btn-primary">Filtrar</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="mt-4 mb-2">
            <small>Total de tareas: </small> <small id="totalTask"> 0 </small>
        </div>

        <div class="task-list-item task-list-header d-flex no-wrap">
            <div>
                TAREAS
            </div>
            <div>
                PRIORIDAD
            </div>
            <div>
                EQUIPO
            </div>
            <div>
                ESTADO
            </div>
            <div>
                DUEÑO
                {{--<i class="bx bx-paperclip"></i>--}}
            </div>
            <div>
                RESPON.
                {{--<i class="bx bx-message"></i>--}}
            </div>
            <div>
                FECHA
            </div>
            <div></div>
        </div>
        <div class="wrap-result">
            <div class="d-flex justify-content-center pt-4">
                Sin datos
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    let urlReportGroup = "{{ route('report.group.report') }}";
    window.addEventListener('load', () => {
        let btnFilter = document.querySelector('#btnFilter');
        btnFilter.addEventListener('click', handleFilter);

        let typeElement = document.querySelector('#type');
        typeElement.addEventListener('change', handleFilterChange);
    });

    function handleFilter(){
        document.querySelector('.loading').classList.remove('hide');
        let team = document.querySelector('#team');
        let user = document.querySelector('#user');
        let date = document.querySelector('#date');
        let check = document.querySelector('#type');
        let type = 'team';
        if( check.checked ) type = 'user';

        fetch(urlReportGroup, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                team: team.value,
                user: user.value,
                date: date.value,
                type: type
            })
        }).then(response => response.json())
        .then(data => {
            document.querySelector('.loading').classList.add('hide');
            if( data.success ){
                handleResponse(data.data);
            }
        })
        .catch((e) => {
            document.querySelector('.loading').classList.add('hide');
            alert(e.message);
        });
    }

    function handleResponse(data){
        let totalTask = document.querySelector('#totalTask');
        let wrapResult = document.querySelector('.wrap-result');
        totalTask.innerHTML = data.totalTask;

        let html = '';
        let domain = 'https://' + window.location.hostname; 

        if( data.tasks.length == 0 ){
            html = `
                <div class="d-flex justify-content-center pt-4">
                    Sin datos
                </div>
            `;
            wrapResult.innerHTML = html;
            return;
        }

        for(let i=0; i < data.tasks.length; i++){
            let item = data.tasks[i];
            let userImage = '';
            let assignImage = '';
            let priority = '';
            let status = '';

            if( item.priority == 'high' ){
                priority = '<span class="badge rounded-pill bg-label-danger">ALTA</span>';
            }
            else if( item.priority == 'medium' ){
                priority = '<span class="badge rounded-pill bg-label-warning">MEDIA</span>';
            }
            else if( item.priority == 'low' ){
                priority = '<span class="badge rounded-pill bg-label-primary">BAJA</span>';
            }

            if( item.status == 'TOSTART' ){
                status = '<span class="badge rounded-pill bg-label-secondary">Sin empezar</span>';
            }
            else if( item.status == 'PROCESS' ){
                status = '<span class="badge rounded-pill bg-label-primary">En proceso</span>';
            }
            else if( item.status == 'DELAY' ){
                status = '<span class="badge rounded-pill bg-label-danger">Retrasado</span>';
            }
            else if( item.status == 'PAUSED' ){
                status = '<span class="badge rounded-pill bg-label-warning">Pausado</span>';
            }
            else if( item.status == 'FINALIZED' ){
                status = '<span class="badge rounded-pill bg-label-success">Finalizado</span>';
            }

            if( item.user.image ){
                userImage = `<img src="${item.user.image}" alt="Avatar" class="rounded-circle">` ;
            }else{
                userImage = `<span class="avatar-initial rounded-circle bg-label-primary">${item.user.nameInitial}</span>`;
            }
            if( item.assign.image ){
                assignImage = `<img src="${item.assign.image}" alt="Avatar" class="rounded-circle">` ;
            }else{
                assignImage = `<span class="avatar-initial rounded-circle bg-label-primary">${item.assign.nameInitial}</span>`;
            }

            let teams = '';
            if( item.assign.teams ){
                for(let j=0; j < item.assign.teams.length; j++){
                    let team = item.assign.teams[j];
                    teams += `<span class="badge bg-label-dark me-2">${team}</span>`;
                }
            }

            html += `
                <div id="task-${item.id}" class="task-list-item d-flex no-wrap">
                <div class="d-flex justify-content-start align-items-center user-name">
                    <div class="avatar-wrapper">
                        <div class="avatar avatar-sm me-2">
                            <img src="${item.brand.image}" alt="Avatar" class="rounded">
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="${domain}/task/view/${item.id}" class="text-heading">
                            <span class="fw-medium">${item.title}</span>
                        </a>
                        <small>${item.brand.name}</small>
                    </div>
                </div>
                <div>
                    ${priority}
                </div>
                <div>
                    ${teams}
                </div>
                <div>
                    ${status}
                </div>
                  
                <div>
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="${item.user.name}" data-bs-original-title="${item.user.name}">
                                <a href="${domain}/task/staff/list/${item.user.id}">
                                    ${userImage}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="${item.assign.name}" data-bs-original-title="${item.assign.name}">
                                <a href="${domain}/task/staff/list/${item.assign.id}">
                                    ${assignImage}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div> ${item.date_delivery} </div>
                <div>
                    <button data-href="${domain}/task/view/${item.id}" onclick="handleCopyLink(this)"
                        data-bs-toggle="tooltip" 
                        class="btn btn-icon text-primary btnCopyLink"
                        data-bs-placement="top" 
                        data-task="title"
                        aria-label="Copiar enlace" 
                        data-bs-original-title="Copiar enlace">
                        <i class="icon-base bx bx-link icon-md"></i>
                    </button>
                </div>
            </div>
            `;
        }

        wrapResult.innerHTML = html;
        $('[data-bs-toggle="tooltip"]').tooltip();
    }
</script>

<script>
    function handleCopyLink(event){
        let href = event.dataset.href;
        let task = event.dataset.task;
        navigator.clipboard.writeText(href);

        let toastElement = document.createElement('div');
        toastElement.classList.add('bs-toast', 'toast', 'fade', 'bg-success');
        toastElement.setAttribute('role', 'alert');
        toastElement.setAttribute('aria-live', 'assertive');
        toastElement.setAttribute('aria-atomic', 'true');
        toastElement.setAttribute('data-bs-autohide', 'true');
        toastElement.setAttribute('data-bs-delay', '2000');
        toastElement.innerHTML = `
            <div class="toast-header">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">Enlace copiado</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">Tarea: ${task}</div>
        `;

        let wrapToast = document.querySelector('.wrap-toast');
        wrapToast.appendChild(toastElement);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 2000 // 2 seconds
        });

        toast.show();
    }

    function handleFilterChange(){
        let wrapTeam = document.querySelector('#wrapTeam');
        let wrapUser = document.querySelector('#wrapUser');

        if( filter = this.checked ){
            wrapTeam.classList.add('hide');
            wrapUser.classList.remove('hide');
        }else{
            wrapTeam.classList.remove('hide');
            wrapUser.classList.add('hide');
        }
    }
</script>
@endsection
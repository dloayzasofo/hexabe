@extends('layout')

@section('main')
	<div class="wrap-toast"></div>

    <div class="row sm-vl-base mb-4">
        <div class="">
            <h4 class="fw-bold"> Resumen de tareas </h4>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
        <div class="col">
            <a href="{{ route('task.index') }}?status=TOSTART">
                <div class="p-3 rounded back-tostart color-tostart">
                    <div class="fw-bold display-6">{{ $taskCategories['TOSTART'] }}</div>
                    <div class="text-dark fw-medium">Sin empezar</div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('task.index') }}?status=PROCESS">
                <div class="p-3 rounded back-process color-process">
                    <div class="fw-bold display-6">{{ $taskCategories['PROCESS'] }}</div>
                    <div class="text-negro fw-medium">En proceso</div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('task.index') }}?status=DELAY">
                <div class="p-3 rounded back-mora color-mora">
                    <div class="fw-bold display-6">{{ $taskCategories['DELAY'] }}</div>
                    <div class="text-negro fw-medium">Retrasado</div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('task.index') }}?status=PAUSED">
                <div class="p-3 rounded back-pause color-pause">
                    <div class="fw-bold display-6">{{ $taskCategories['PAUSED'] }}</div>
                    <div class="text-negro fw-medium">Pausado</div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('task.index') }}?status=FINALIZED">
                <div class="p-3 rounded back-success color-success">
                    <div class="fw-bold display-6">{{ $taskCategories['FINALIZED'] }}</div>
                    <div class="text-negro fw-medium">Finalizado</div>
                </div>
            </a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h5 class="fw-bold">Mis tareas</h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('task.index') }}" class="text-link">Ver todas</a>
        </div>
    </div>

    <div class="task-list-item task-list-header d-flex no-wrap">
        <div>
            Tarea
        </div>
        <div>
            Marca
        </div>
        <div>
            Responsable
        </div>
        <div>
            Estado
        </div>
        <div>
            Prioridad
        </div>
        <div>
            Progreso
        </div>
        <div>
            Fecha de entrega
        </div>
        <div>
            Acciones
        </div>
    </div>
    @foreach($tasks as $task)
    <div id="task-{{ $task->id }}" class="task-list-item d-flex no-wrap">
        <div>
            <div class="d-flex flex-column">
                <a href="{{ route('task.view', ['task'=> $task]) }}" class="text-heading">
                    <span class="fw-medium">{{ $task->title }}</span>
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-start align-items-center user-name">
            <div class="avatar-wrapper">
                <div class="avatar avatar-sm me-2">
                    <img src="{{ $task->brand->image }}" alt="Avatar" class="rounded">
                </div>
            </div>
            <div class="d-flex flex-column">
                <a href="{{ route('brand.view', ['brand'=> $task->brand->id]) }}" class="text-heading">
                    <span class="fw-medium">{{ strtoupper($task->brand->name) }}</span>
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center user-name">
            <div class="avatar-wrapper">
                <a href="{{ route('task.view', ['task'=> $task]) }}" class="text-heading">
                    <div class="avatar avatar-sm">
                        @if( isset($task->assign->image) )
                            <img class="rounded-circle" src="{{ $task->assign->image }}" alt="{{ $task->assign->name }}">
                        @else
                            <span class="avatar-initial rounded-circle bg-label-primary">{{ $task->assign->nameInitial }}</span>
                        @endif
                    </div>
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="ct-select" data-value="{{ $task->status }}" data-task="{{ $task->id }}" data-type="status">
                <div class="ct-select-view"></div>
                <ul class="list-items">
                    <li class="list-items-item TOSTART" data-id="{{ $task->id }}" data-value="TOSTART"> Sin empezar </li>
                    <li class="list-items-item PROCESS" data-id="{{ $task->id }}" data-value="PROCESS"> En proceso </li>
                    <li class="list-items-item DELAY" data-id="{{ $task->id }}" data-value="DELAY"> Retraso </li>
                    <li class="list-items-item PAUSED" data-id="{{ $task->id }}" data-value="PAUSED"> Pausado </li>
                    <li class="list-items-item FINALIZED" data-id="{{ $task->id }}" data-value="FINALIZED"> Finalizado </li>
                </ul>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="ct-select" data-value="{{ $task->priority }}" data-task="{{ $task->id }}" data-type="priority">
                <div class="ct-select-view"></div>
                <ul class="list-items">
                    <li class="list-items-item high" data-id="{{ $task->id }}" data-value="high"> ALTA </li>
                    <li class="list-items-item medium" data-id="{{ $task->id }}" data-value="medium"> MEDIA </li>
                    <li class="list-items-item low" data-id="{{ $task->id }}" data-value="low"> BAJA </li>
                </ul>
            </div>
        </div>

        <div>
            <div>
                @if( $task->childs_count > 0 )
                <div class="d-flex justify-content-between mb-1">
                    <div>
                        Subtareas
                    </div>
                    <div class="text-primary fw-bold">
                        {{ $task->childs_done }}/{{ $task->childs_count }}
                    </div>
                    
                </div>
                <div>
                    <div class="progress" style="height: 16px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $task->progress }}%
                        </div>
                    </div>
                </div>
                @else
                <div>
                    Sin Subtareas
                </div>
                @endif
            </div>
        </div>
       
        <div> {{ $task->register_at }} </div>
        
        <div>
            <div class="d-flex align-items-center justify-content-center">
                <a href="{{ route('task.view', [$task]) }}">
                    Ver tarea
                </a>
            </div>
        </div>
    </div>
    @endforeach


    <div class="row mt-5">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">Marcas</h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('brand.index') }}" class="text-link">Ver todas</a>
                </div>
            </div>

            <div class="card" style="/*min-height:350px;*/height:100%;">
                <div class="card-body">
                    @hasanyrole('SUPER|ADMIN')
                    <div>
                        <a href="{{ route('brand.index') }}">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-md me-4">
                                        <span class="avatar-initial rounded-circle bg-label-dark" style="font-size:22px;">+</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">Añadir marca</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endhasanyrole

                    @foreach($brands as $brand)
                    <div class="mt-3">
                        <a href="{{ route('brand.view', $brand->id) }}">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-md me-4">
                                        <img src="{{ $brand->image }}" class="rounded">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">{{ $brand->name }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">Mis equipos</h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('team.index') }}" class="text-link">Ver todos</a>
                </div>
            </div>

            <div class="card" style="/*min-height:350px;*/height:100%;">
                <div class="card-body">
                    @hasanyrole('SUPER|ADMIN')
                    <div>
                        <a href="{{ route('team.index') }}">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-md me-4">
                                        <span class="avatar-initial rounded-circle bg-label-dark" style="font-size:22px;">+</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">Añadir equipo</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endhasanyrole

                    @foreach($teams as $team)
                    <div class="mt-3">
                        <div class="d-flex justify-content-between dash-team align-items-center">
                            <div>
                                <a href="{{ route('team.view', $team->id) }}" >
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-md me-4">
                                                <img src="{{ $team->image }}" class="rounded">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">{{ $team->name }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div>
                                @if( $team->progress >= 0 )
                                    <div class="row mb-1">
                                        <div class="col-md-6">
                                            <small>Progreso</small>
                                        </div>
                                        <div class="col-md-6 fw-bold text-end">
                                            <small style="color:@if($team->progress >= 85) #22C55E; @elseif ($team->progress >= 50) #EAB308; @else #EF4444; @endif">{{ $team->progress == -1 ? "0" : $team->progress }}%</small>
                                        </div>
                                    </div>
                                    
                                    <div class="progress" style="height: 8px;margin: auto;padding:0px;">
                                        <div class="progress-bar" role="progressbar" style="width:{{ $team->progress }}%;background:@if($team->progress >= 85) #22C55E; @elseif ($team->progress >= 50) #EAB308; @else #EF4444; @endif" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <ul class="list-unstyled m-0 avatar-group d-flex align-items-center mt-4">
                                    @foreach( $team->members as $index => $member )
                                        @if( $index >= 3 )
                                            @break;
                                        @endif

                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-s pull-up" aria-label="{{ $member->name }}" data-bs-original-title="{{ $member->name }}">
                                            <a href="{{ route('task.user.list', [$member]) }}">
                                                @if( $member->image )
                                                    <img src="{{ asset($member->image) }}" alt="Avatar" class="rounded-circle">
                                                @else
                                                    <span class="avatar-initial rounded-circle">{{ $member->nameInitial }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach

                                    @if( $team->members->count() > 3 )
                                        <li class="avatar">
                                            <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ $team->members->count() - 3 }} more">+{{ $team->members->count() - 3 }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('/assets/admin/js/fobo_select.js') }}"></script>
<script>
/*
    window.addEventListener('load', () => {
        loadCtSelects();
    });

    function loadCtSelects(){
        let ctSelects = document.querySelectorAll('.ct-select');
        for (let i = 0; i < ctSelects.length; i++) {
            loadItemCtSelects(ctSelects[i]);
        }

        let ctSelectViews = document.querySelectorAll('.ct-select-view');
        for (let i = 0; i < ctSelectViews.length; i++) {
            ctSelectViews[i].addEventListener('click', handleClickCtSelect);
        }

        let ctSelectViewItems = document.querySelectorAll('.list-items-item');
        for (let i = 0; i < ctSelectViewItems.length; i++) {
            ctSelectViewItems[i].addEventListener('click', handleClickCtSelectItem);
        }
    }

    function loadItemCtSelects(element){
        let value = element.getAttribute('data-value');
        let items = element.querySelectorAll('.list-items-item');
        let view = element.querySelector('.ct-select-view');
        for (let i = 0; i < items.length; i++) {
            let item = items[i].getAttribute('data-value');
            if( item == value ){
                element.classList.remove(item);
                view.innerHTML = items[i].innerHTML;
            }
        }

        element.classList.add(value);
    }

    function handleClickCtSelect(){
        let parent = this.parentNode;
        closeAllCtSelect(parent);
        if( parent.classList.contains('active') ){
            parent.classList.remove('active');
            return;
        }
        parent.classList.add('active');
    }

    function closeAllCtSelect(element){
        let ctSelects = document.querySelectorAll('.ct-select');
        for (let i = 0; i < ctSelects.length; i++) {
            if( ctSelects[i] != element ){
                ctSelects[i].classList.remove('active');
            }
        }
    }

    function handleClickCtSelectItem(){
        let value = this.getAttribute('data-value');
        let taskId = this.getAttribute('data-id');
        let parent = this.parentNode.parentNode;
        let type = parent.getAttribute('data-type');
        
        if( type == 'priority' ){
            serverCtSelectPriority(taskId, value);
        }
        if( type == 'status' ){
            serverCtSelectStatus(taskId, value);
        }

        let view = parent.querySelector('.ct-select-view');
        view.innerHTML = this.innerHTML;
        parent.className = 'ct-select';
        parent.classList.add(value);
    }

    function serverCtSelectPriority(taskId, priority){
        let url = "{{ route('task.api.edit.priority', ':id') }}".replace(':id', taskId);
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                priority: priority
            })
        }).then(response => response.json())
        .then(data => {
            showCtSelectToast(data);
        });
    }

    function serverCtSelectStatus(taskId, status){
        let url = "{{ route('task.api.edit.status', ':id') }}".replace(':id', taskId);
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: status
            })
        }).then(response => response.json())
        .then(data => {
            showCtSelectToast(data);
        });
    }

    function showCtSelectToast(data){
        console.log(data, "true");
        if( data.success ) {
          const wrapToast = document.querySelector('.wrap-toast');
          let classAlert = data.success ? 'bg-success' : 'bg-danger';
          let idRandom = Math.random().toString(36).substring(2, 9);
          let html = `
            <div id="${idRandom}" class="bs-toast toast fade hide ${classAlert}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
              <div class="toast-header">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">Notificación</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">${ data.message }</div>
            </div>
          `;

          wrapToast.insertAdjacentHTML('beforeend', html);
          setTimeout(() => {
            const toastElement = document.getElementById(idRandom);
            if (toastElement) {
              const toast = new bootstrap.Toast(toastElement);
              toast.show();
            }
          }, 150);
        }
    }
*/
</script>
@endsection
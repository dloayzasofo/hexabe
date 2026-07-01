@extends('layout')

@section('main')
    <div class="btn-add-task"> 
        <button id="btnCreate" class="btn btn-primary" title="Crear nueva tarea">
            <span><i class="bx bx-plus"></i></span> Crear tarea
        </button> 
    </div>

    <div class="row sm-vl-base mb-2">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold"> {{ $user->name }} {{ $user->last_name }} - tareas </h4>
        </div>
        <div class="col-sm-4 col-md-6">
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> </div>
            </div>
        </div>
    </div>

    @if(Session::has('task.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('task.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div>
        <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.list', $user->id) }}" class="nav-link active" aria-selected="true">
                    <i class="bx bx-list-ol"></i> Lista
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.kanban', $user->id) }}" class="nav-link" ria-selected="false" tabindex="-1">
                    <i class="bx bx-card"></i> Tarjetas
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.calendar', $user->id) }}" class="nav-link" ria-selected="true">
                    <i class="bx bx-calendar"></i> Calendario
                </a>
            </li>
        </ul>

        <ul class="nav nav-tabs nav-fill tabs-status" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.list', $user->id) }}?status=TOSTART" class="nav-link @if( $status == 'TOSTART') active @endif" aria-selected="true">
                <span class="d-none d-sm-inline-flex align-items-center">
                    Sin empezar <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-info ms-2">{{ $counters['TOSTART'] }}</span>
                </span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.list', $user->id) }}?status=PROCESS" class="nav-link @if( $status == 'PROCESS') active @endif" aria-selected="true">
                <span class="d-none d-sm-inline-flex align-items-center">
                    En proceso <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-purple ms-2">{{ $counters['PROCESS'] }}</span>
                </span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.list', $user->id) }}?status=DELAY" class="nav-link @if( $status == 'DELAY') active @endif" aria-selected="true">
                <span class="d-none d-sm-inline-flex align-items-center">
                    Retraso <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-2">{{ $counters['DELAY'] }}</span>
                </span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.list', $user->id) }}?status=PAUSED" class="nav-link @if( $status == 'PAUSED') active @endif" aria-selected="true">
                <span class="d-none d-sm-inline-flex align-items-center">
                    Pausado <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-warning ms-2">{{ $counters['PAUSED'] }}</span>
                </span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.list', $user->id) }}?status=FINALIZED" class="nav-link @if( $status == 'FINALIZED') active @endif" aria-selected="true">
                <span class="d-none d-sm-inline-flex align-items-center">
                    Finalizado <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-success ms-2">{{ $counters['FINALIZED'] }}</span>
                </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="task-list-item task-list-header d-flex no-wrap">
        <div>
            Tarea
        </div>
        <div>
            Marca
        </div>
        <div>
            Estado
        </div>
        <div>
            Prioridad
        </div>
        <div>
            Equipo
        </div>
        <div>
            Fecha de entrega
        </div>
        <div>
            Acciones
        </div>
    </div>

    @foreach($tasks as $task)
    <div class="task-list-item d-flex no-wrap">
        <div class="d-flex justify-content-start align-items-center user-name">
            <div class="avatar-wrapper">
                <a href="{{ route('task.view', ['task'=> $task]) }}" class="text-heading">
                    <div class="avatar avatar-sm me-2">
                        @if( isset($task->assign->image) )
                            <img class="rounded-circle" src="{{ $task->assign->image }}" alt="{{ $task->assign->name }}">
                        @else
                            <span class="avatar-initial rounded-circle bg-label-primary">{{ $task->assign->nameInitial }}</span>
                        @endif
                    </div>
                </a>
            </div>
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

        <div class="d-flex justify-content-center">
            <div class="ct-select {{ $task->status }}" data-value="{{ $task->status }}" data-task="{{ $task->id }}" data-type="status">
                <div class="ct-select-view readonly">
                    @if( $task->status == 'TOSTART' )
                        Sin empezar
                    @elseif( $task->status == 'PROCESS' )
                        En proceso
                    @elseif( $task->status == 'DELAY' )
                        Retraso
                    @elseif( $task->status == 'PAUSED' )
                        Pausado
                    @elseif( $task->status == 'FINALIZED' )
                        Finalizado
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="ct-select {{ $task->priority }}" data-value="{{ $task->priority }}" data-task="{{ $task->id }}" data-type="priority">
                <div class="ct-select-view readonly">
                    @if( $task->priority == 'high' )
                        ALTA
                    @elseif( $task->priority == 'medium' )
                        MEDIA
                    @elseif( $task->priority == 'low' )
                        BAJA
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                <ul class="list-unstyled users-list d-flex align-items-center avatar-group mb-0">

                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="{{ $task->assign->name }}" data-bs-original-title="{{ $task->assign->name }}">
                        <a href="{{ route('task.user.list', [$task->assign]) }}">
                            @if( isset($task->assign->image) )
                                <img class="rounded-circle" src="{{ $task->assign->image }}" alt="{{ $task->assign->name }}">
                            @else
                                <span class="avatar-initial rounded-circle bg-label-primary">{{ $task->assign->nameInitial }}</span>
                            @endif
                        </a>
                    </li>

                    @foreach($task->collaborators as $index => $collaborator)
                        @if( $index >= 2)
                            @break
                        @endif

                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="{{ $collaborator->user->name }}" data-bs-original-title="{{ $collaborator->user->name }}">
                            <a href="{{ route('task.user.list', [$collaborator->user]) }}">
                                @if( isset($collaborator->user->image) )
                                    <img class="rounded-circle" src="{{ $collaborator->user->image }}" alt="{{ $collaborator->user->name }}">
                                @else
                                    <span class="avatar-initial rounded-circle bg-label-primary">{{ $collaborator->user->nameInitial }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach

                    @if( $task->collaborators_count >= 3 )
                        <li class="avatar">
                            <span class="avatar-initial rounded-circle pull-up text-heading" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="bottom" 
                                data-bs-original-title="{{ 3 - $task->collaborators_count }} más">
                                +{{ 3 - $task->collaborators_count }}
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div> {{ $task->register_at }} </div>

        <div>
            <div class="d-flex align-items-center justify-content-end">
                <a href="{{ route('task.view', [$task]) }}"
                    data-bs-toggle="tooltip"
                    class="btn btn-icon delete-record text-primary"
                    data-bs-placement="top" 
                    data-task="{{ $task->title }}"
                    aria-label="Ver tarea"
                    data-bs-original-title="Ver tarea">
                    <i class="bx bx-chevron-right"></i>
                </a>

                <button data-href="{{ route('task.view', [$task]) }}" 
                    data-bs-toggle="tooltip"
                    class="btn btn-icon delete-record text-primary btnCopyLink"
                    data-bs-placement="top" 
                    data-task="{{ $task->title }}"
                    aria-label="Copiar enlace"
                    data-bs-original-title="Copiar enlace">
                    <i class="icon-base bx bx-link icon-md"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach


    <div class="modal fade " id="modalCenter" tabindex="-1" aria-modal="true" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
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
@endsection

@section('script')
<link href="{{ asset('/assets/admin/js/quilljs/quill.css') }}" rel="stylesheet">
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<script src="{{ asset('/assets/admin/js/quilljs/quill.js') }}"></script>
<script src="{{asset('/assets/admin/js/mieditor.js')}}"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>let urlCreate = "{{ route('task.user', [$user]) }}";</script>
<script src="{{asset('/assets/admin/js/task.js')}}"></script>

<script>
    window.addEventListener('load', () => {
        let btnsCopyLink = document.querySelectorAll('.btnCopyLink');
        for(let i=0; i < btnsCopyLink.length; i++){
            btnsCopyLink[i].addEventListener('click', handleCopyLink);
        }
    });

    function handleCopyLink(){
        let href = this.dataset.href;
        let task = this.dataset.task;
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
</script>
@endsection
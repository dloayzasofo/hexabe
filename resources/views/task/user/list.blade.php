@extends('layout')

@section('main')
    <div class="btn-add-task"> 
        <button id="btnCreate" class="btn rounded-pill btn-icon btn-primary" title="Crear nueva tarea">
            <span><i class="bx bx-plus"></i></span>
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
        <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced mb-3" role="tablist">
            <li class="nav-item" role="presentation">
            <a href="{{ route('task.user.list', $user->id) }}" class="nav-link active" aria-selected="true">Lista</a>
            </li>
            <li class="nav-item" role="presentation">
            <a href="{{ route('task.user.kanban', $user->id) }}" class="nav-link" ria-selected="false" tabindex="-1">Tarjetas</a>
            </li>
        </ul>

        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.list', $user->id) }}?status=TOSTART" class="nav-link @if( $status == 'TOSTART') active @endif" aria-selected="true">
                <span class="d-none d-sm-inline-flex align-items-center">
                    Sin empezar <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-warning ms-2">{{ $counters['TOSTART'] }}</span>
                </span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('task.user.list', $user->id) }}?status=PROCESS" class="nav-link @if( $status == 'PROCESS') active @endif" aria-selected="true">
                <span class="d-none d-sm-inline-flex align-items-center">
                    En proceso <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-info ms-2">{{ $counters['PROCESS'] }}</span>
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
                    Pausado <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-2">{{ $counters['PAUSED'] }}</span>
                </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="task-list-item task-list-header d-flex no-wrap">
        <div>
            TAREAS
        </div>
        <div>
            PRIORIDAD
        </div>
        <div>
            PROGRESO
        </div>
        <div>
            EQUIPO
        </div>
        <div>
            <i class="bx bx-paperclip"></i>
        </div>
        <div>
            <i class="bx bx-message"></i>
        </div>
        <div>
            FECHA
        </div>
        <div></div>
    </div>

    @foreach($tasks as $task)
    <div class="task-list-item d-flex no-wrap">
        <div class="d-flex justify-content-start align-items-center user-name">
            <div class="avatar-wrapper">
                <div class="avatar avatar-sm me-2">
                    <img src="{{ $task->brand->image }}" alt="Avatar" class="rounded">
                </div>
            </div>
            <div class="d-flex flex-column">
                <a href="{{ route('task.view', ['task'=> $task]) }}" class="text-heading text-truncate">
                    <span class="fw-medium">{{ $task->title }}</span>
                </a>
                <small>{{ strtoupper($task->brand->name) }}</small>
            </div>
        </div>  

        <div>
            @if( $task->priority == 'high' )
            <span class="badge rounded-pill bg-label-danger">ALTA</span>
            @endif
            @if( $task->priority == 'medium' )
            <span class="badge rounded-pill bg-label-warning">MEDIA</span>
            @endif
            @if( $task->priority == 'low' )
            <span class="badge rounded-pill bg-label-primary">BAJA</span>
            @endif
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

        <div>
            <div class="d-flex flex-wrap align-items-center">
                <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">

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
        <div> {{ $task->medias_count == 0 ? '-' : $task->medias_count }} </div>
        <div> - </div>
        <div> {{ $task->register_at}} </div>
        <div>
            <div class="dropdown">
                <button class="btn text-body-secondary p-0" type="button" id="timelineWapper" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper" style="">
                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                </div>
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
@endsection
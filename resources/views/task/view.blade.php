@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-md-12">
            <div class="d-flex mb-3">
                @if( $task->status == 'TOSTART' )
                    <span class="badge rounded-pill me-2 bg-label-secondary">Por empezar</span>
                @elseif( $task->status == 'PROCCESS' )
                    <span class="badge rounded-pill me-2 bg-label-primary">Proceso</span>
                @elseif( $task->status == 'DELAY' )
                    <span class="badge rounded-pill me-2 bg-label-danger">Retrasado</span>
                @elseif( $task->status == 'PAUSED' )
                    <span class="badge rounded-pill me-2 bg-label-warning">Pausado</span>
                @elseif( $task->status == 'FINALIZED' )
                    <span class="badge rounded-pill me-2 bg-label-success">Finalizado</span>
                @endif
                
                @if( $task->priority == 'low')
                    <span class="badge rounded-pill bg-label-primary ">Prioridad baja</span>
                @elseif( $task->priority == 'medium')
                    <span class="badge rounded-pill bg-label-warning ">Prioridad media</span>
                @elseif( $task->priority == 'high')
                    <span class="badge rounded-pill bg-label-danget ">Prioridad alta</span>
                @endif
            </div>
            <div class="d-flex align-items-center w-100">
                <div>
                    <h2 class="fw-bold" style="margin-bottom:4px;"> {{ $task->title }} </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-2"><b>Descripción</b></div>
            <div>{{ $task->description }}</div>

            <div class="mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="fw-bold">Subtareas</h5>
                            </div>
                            <div>
                                65% Completado
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="progress" style="height: 16px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                    65%
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center border-primary py-3 px-4 border rounded mt-2" style="border-color:#F1F5F9 !important;">
                                <div class="me-3">
                                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none" style="color:#22C55E;">
                                        <i class="icon-base bx bx-check-circle" style="font-size:25px;"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-3">
                                        <p class="mb-0 text-heading" style="text-decoration: line-through;">Lorem ipsum dolor sit amet consectetur.</p>
                                    </div>
                                    <div class="user-progress">
                                        <div class="d-flex justify-content-center">
                                            <small class="mt-auto mb-1 text-heading"> Sep 12</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center border-primary py-3 px-4 border rounded mt-2" style="border-color:#F1F5F9 !important;">
                                <div class="me-3">
                                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                        <i class="icon-base bx bx-circle" style="font-size:25px;"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-3">
                                        <p class="mb-0 text-heading">Lorem ipsum dolor sit amet consectetur.</p>
                                    </div>
                                    <div class="user-progress">
                                        <div class="avatar avatar-sm">
                                                <span class="avatar-initial rounded-circle bg-label-danger">DL</span>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center border-primary py-3 px-4 border rounded mt-2" style="border-color:#F1F5F9 !important;">
                                <div class="me-3">
                                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none" >
                                        <i class="icon-base bx bx-circle" style="font-size:25px;"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-3">
                                        <p class="mb-0 text-heading">Lorem ipsum dolor sit amet consectetur.</p>
                                    </div>
                                    <div class="user-progress">
                                        <div class="d-flex justify-content-center">
                                            <div class="avatar avatar-sm">
                                                <span class="avatar-initial rounded-circle bg-label-danger">DL</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            

            <div class="mt-5">
                <h4 class="fw-bold">Conversación del equipo </h4>
                <div>
                    <div class="d-flex overflow-hidden mb-3">
                        <div class="user-avatar flex-shrink-0 me-4">
                            <div class="avatar avatar-md">
                            <img src="{{ asset('assets/img/2.png') }}" alt="Avatar" class="rounded-circle">
                            </div>
                        </div>
                        <div class="chat-message-wrapper flex-grow-1">
                            <div class="chat-message-text p-3" style="background:#fff;border-radius:0px 12px 12px 12px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="fw-bold">
                                        Alex Rivera
                                    </div>
                                    <div>
                                        Hace 1 horas
                                    </div>
                                </div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet consectetur. Dignissim id purus suspendisse elementum. Pretium libero eget integer ridiculus.
                                </p>
                            </div>
                        </div>
                    </div>
                
                    <div class="d-flex overflow-hidden mb-3">
                        <div class="user-avatar flex-shrink-0 me-4">
                            <div class="avatar avatar-md">
                            <img src="{{ asset('assets/img/3.png') }}" alt="Avatar" class="rounded-circle">
                            </div>
                        </div>
                        <div class="chat-message-wrapper flex-grow-1">
                            <div class="chat-message-text p-3" style="background:#fff;border-radius:0px 12px 12px 12px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="fw-bold">
                                        Sarah Chen
                                    </div>
                                    <div>
                                        Hace 2 horas
                                    </div>
                                </div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet consectetur. Dignissim id purus suspendisse elementum. Pretium libero eget integer ridiculus.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <form action="">

                        <div class="d-flex overflow-hidden mb-3">
                            <div class="user-avatar flex-shrink-0 me-4">
                                <div class="avatar avatar-md">
                                <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-text">
                                    <div class="mb-0">
                                        <textarea name="" id=""  class="form-control" placeholder="Escribe un comentario"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-warning me-3">
                                <span class="icon-base bx bx-paperclip icon-sm me-2"></span>
                                Adjuntar
                            </button>
                            <button type="button" class="btn btn-warning">Publicar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-5 mb-4">
                <form action="">
                    @csrf

                    <div class="text-center mx-auto">
                        <button class="btn btn-primary btn-lg" style="width:50%;">
                            Marcar como terminada
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="background-color: transparent;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-md me-3">
                                    <img src="{{ $task->brand->image }}" alt="Avatar" class="rounded-2">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $task->brand->name }}</span>
                                </a>
                                <small>lorem ipsun</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="mb-2"><small>GERENTE DE PROYECTO</small></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-md me-3">
                                    @if( $task->user->image != null )
                                        <img src="{{ $task->user->image }}" alt="Avatar" class="rounded-2">
                                    @else 
                                        <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->user->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $task->user->name }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 mt-4"><small>RESPONSABLE</small></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-md me-3">
                                    @if( $task->assign->image != null )
                                        <img src="{{ $task->assign->image }}" alt="Avatar" class="rounded-2">
                                    @else 
                                        <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->assign->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $task->assign->name }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 mt-4"><small>FECHA LÍMITE</small></div>
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="bx bx-calendar"></i>
                        </div>
                        <div>
                            {{ Carbon\Carbon::parse($task->date_delivery)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-4">
                <div class="fw-bold">Archivos adjuntos y enlaces</div>
            </div>

            @if( count($taskMedias) > 0 )
                @foreach( $taskMedias as $taskMedia )
                    <a href="{{ $taskMedia->media->url }}" class="block" target="_blank">
                        <div class="card mt-2" style="background:transparent;box-shadow:none; border: 1px solid #e2e8f0;">
                            <div class="card-body" style="padding:10px;">
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-md me-3">
                                            <span class="avatar-initial rounded bg-label-danger"><i class="icon-base bx bx-file icon-lg"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>{{ $taskMedia->media->name }}</small>
                                        <small>{{ $taskMedia->media->size_literal }}</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>

@endsection

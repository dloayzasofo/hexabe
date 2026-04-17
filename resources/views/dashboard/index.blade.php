@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="">
            <h4 class="fw-bold"> Resumen de tareas </h4>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
        <div class="col">
            <div class="p-3 rounded back-process color-process">
                <div class="fw-bold display-6">{{ $taskCategories['PROCESS'] }}</div>
                <div>En proceso</div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 rounded back-success color-success">
                <div class="fw-bold display-6">{{ $taskCategories['FINALIZED'] }}</div>
                <div>Finalizado</div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 rounded back-mora color-mora">
                <div class="fw-bold display-6">{{ $taskCategories['DELAY'] }}</div>
                <div>Retrasado</div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 rounded back-tostart color-tostart">
                <div class="fw-bold display-6">{{ $taskCategories['TOSTART'] }}</div>
                <div>Sin empezar</div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 rounded back-pause color-pause">
                <div class="fw-bold display-6">{{ $taskCategories['PAUSED'] }}</div>
                <div>Pausado</div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h5 class="fw-bold">Mis próximas tareas</h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('task.index') }}">Ver todas</a>
        </div>

        <div>
            <div class="row">
                @foreach($tasks as $task)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="badge bg-label-secondary">{{ $task->brand->name }}</span>
                                </div>
                                <div>
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

                                    <span class="badge rounded-pill @if($task->priority == 'medium') bg-label-warning @elseif($task->priority == 'low') bg-label-primary @elseif($task->priority == 'high') bg-label-danger @endif">
                                        @switch($task->priority)
                                            @case('low')
                                                Baja
                                                @break
                                            @case('medium')
                                                Media
                                                @break
                                            @case('high')
                                                Alta
                                                @break
                                            @default
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('task.view', $task->id) }}">
                                    <h5 class="fw-bold">{{ $task->title }}</h5>
                                </a>
                            </div>
                            <hr class="border-primary opacity-50">
                            <div class="d-flex justify-content-start">
                                <div>
                                    <i class="bx bx-calendar" style="margin-top:-4px;"></i>
                                    <span class="fw-semibold">{{ $task->register_at }}</span>
                                </div>
                                @if( count($task->medias) > 0 )
                                <div class="ps-3">
                                    <i class="bx bx-paperclip"></i>
                                    {{ count($task->medias) }}
                                </div>
                                @endif

                                @if( count($task->comments) > 0 )
                                <div class="ps-3">
                                    <i class="bx bx-message"></i>
                                    {{ count($task->comments) }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">Marcas</h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('brand.index') }}">Ver todas</a>
                </div>
            </div>

            <div class="card" style="min-height:350px;">
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

                    <div class="mt-3">
                        <a href="">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-md me-4">
                                        <img src="{{ asset('assets/img/4.png') }}" class="rounded">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">Marca 2</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h5 class="fw-bold">Personas</h5>

            <div class="card" style="min-height:350px;">
                <div class="card-body">
                    <div class="card back-pause">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded" style="background:#EC5B13;">
                                            <i class="icon-base bx bx-user-plus icon-lg"></i>
                                        </span>
                                    </div>
                                    <div class="ps-3" style="margin-top:-4px;">
                                        <div class="fw-bold">Invitar a compañeros</div>
                                        <div>Acelera el trabajo en equipo</div>
                                    </div>
                                </div>
                                <div>
                                    <a type="button" class="btn btn-warning" style="background:#EC5B13;" href="{{ route('team.index') }}">Invitar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">Colaboradores frecuentes</div>
                    <div>
                        <div class="mt-3 d-flex justify-content-between">
                            <div class="d-flex justify-content-start align-items-center text-center">
                                <small>Próximamente podrás ver aquí a tus colaboradores frecuentes para acceder rápidamente a sus perfiles y tareas compartidas.</small>
                            </div>
                        </div>
                        {{-- 
                        <div class="mt-3 d-flex justify-content-between">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-md me-3">
                                        <img src="{{ asset('assets/img/2.png') }}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="app-user-view-account.html" class="text-heading text-truncate">
                                        <span class="fw-bold">Alex Rivera</span>
                                    </a>
                                    <small>Diseñador UI</small>
                                </div>
                            </div>
                            <div>
                                <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-between">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-md me-3">
                                        <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="app-user-view-account.html" class="text-heading text-truncate">
                                        <span class="fw-bold">Maria Lopez</span>
                                    </a>
                                    <small>Product Manager</small>
                                </div>
                            </div>
                            <div>
                                <span class="email-list-item-label badge badge-dot bg-secondary d-none d-md-inline-block me-2" data-label="work"></span>
                            </div>
                        </div>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
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
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                    <div class="d-flex justify-content-between align-items-center card-widget-2 pb-4 pb-sm-0">
                        <div>
                            <p class="mb-0">Tareas en curso</p>
                        </div>
                        <div class="avatar me-lg-6 w-px-42 h-px-42">
                            <span class="avatar-initial rounded bg-label-success text-heading">
                                <i class="icon-base bx bx-user icon-26px"></i>
                            </span>
                        </div>
                    </div>
                    <h4 class="card-title mb-0 fw-bold">48</h4>
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

                    <div class="d-flex align-items-center">
                        <div class="pe-2">
                            <h4 class="card-title mb-0 fw-bold">124</h4>
                        </div>
                        <div>
                            <div class="progress" style="height:8px;margin:auto;padding:0px;width:100px;">
                                <div class="progress-bar" role="progressbar" style="width: 68%;background:#0052CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                            <p class="mb-0">Proyectos Activos</p>
                        </div>
                        <div class="avatar me-lg-6 w-px-42 h-px-42">
                            <span class="avatar-initial rounded bg-label-warning text-heading">
                                <i class="icon-base bx bx-rocket icon-26px"></i>
                            </span>
                        </div>
                    </div>

                    <h4 class="card-title mb-0 fw-bold">12</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h5 class="fw-bold" style="margin-bottom:4px;"> Miembros (12)</h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="" class="fw-semibold">+ Invitar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{ asset('assets/img/2.png') }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">Zsazsa McCleverty</span>
                                </a>
                                <small>zmcclevertye@soundcloud.com</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                        </div>
                    </div>
                </div>
                <hr class="m-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">Zsazsa McCleverty</span>
                                </a>
                                <small>zmcclevertye@soundcloud.com</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                        </div>
                    </div>
                </div>
                <hr class="m-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{ asset('assets/img/3.png') }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">Zsazsa McCleverty</span>
                                </a>
                                <small>zmcclevertye@soundcloud.com</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="email-list-item-label badge badge-dot bg-secondary d-none d-md-inline-block me-2" data-label="work"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div style="margin-bottom:13px;">
                <h5 class="fw-bold" style="margin-bottom:4px;"> Tareas asignadas </h5>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center w-100">
                                <span class="badge rounded-pill bg-label-danger">Alta</span> <spam class="fw-bold ps-2">Marca</spam>
                            </div>
                            <div class="fw-bold mt-2">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </div>
                            <div class="mt-2">
                                <div class="d-flex">
                                    <div class="avatar-group d-flex align-items-center assigned-avatar">
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Bruce" data-bs-original-title="Bruce">
                                            <img src="{{ asset('assets/img/2.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Clark" data-bs-original-title="Clark">
                                            <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <small><i class="icon-base bx bx-calendar"></i> Entrega: 24 Oct</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="badge rounded-pill bg-label-primary">Primary</span>
                            <div class="progress" style="height:8px;margin-left:auto;margin-right:0px;padding:0px;width:100px;margin-top:8px;">
                                <div class="progress-bar" role="progressbar" style="width: 68%;background:#0052CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center w-100">
                                <span class="badge rounded-pill bg-label-danger">Alta</span> <spam class="fw-bold ps-2">Marca</spam>
                            </div>
                            <div class="fw-bold mt-2">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </div>
                            <div class="mt-2">
                                <div class="d-flex">
                                    <div class="avatar-group d-flex align-items-center assigned-avatar">
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Bruce" data-bs-original-title="Bruce">
                                            <img src="{{ asset('assets/img/2.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Clark" data-bs-original-title="Clark">
                                            <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <small><i class="icon-base bx bx-calendar"></i> Entrega: 24 Oct</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="badge rounded-pill bg-label-primary">Primary</span>
                            <div class="progress" style="height:8px;margin-left:auto;margin-right:0px;padding:0px;width:100px;margin-top:8px;">
                                <div class="progress-bar" role="progressbar" style="width: 68%;background:#0052CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

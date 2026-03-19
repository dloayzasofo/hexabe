@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <div class="d-flex align-items-center w-100">
                <div class="p-2 me-sm-2 rounded" style="background:#fff;">
                    <img src="{{ $brand->image }}" style="height:64px;">
                </div>
                <div>
                    <h4 class="fw-bold" style="margin-bottom:4px;"> {{ $brand->name }} </h4>
                    <small>Lorem ipsum dolor sit amet consectetur. Dignissim id purus</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Tareas Totales</span>
                <h4 class="card-title mb-0 fw-bold">1,284</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body pb-4">
                    <span class="d-block fw-medium mb-1">Progreso General</span>
                    <div class="d-flex align-items-center">
                        <div class="pe-2">
                            <h4 class="card-title mb-0 fw-bold">76%</h4>
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

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Miembros Activos</span>
                <h4 class="card-title mb-0 fw-bold">24</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Presupuesto Ejecutado</span>
                <h4 class="card-title mb-0 fw-bold">82%</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8">
            <div style="margin-bottom:13px;">
                <h5 class="fw-bold" style="margin-bottom:4px;"> Tareas Recientes </h5>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center w-100">
                                <span class="badge rounded-pill bg-label-danger">Danger</span> <spam class="fw-bold ps-2">Equipo</spam>
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
                                <span class="badge rounded-pill bg-label-danger">Danger</span> <spam class="fw-bold ps-2">Equipo</spam>
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

        <div class="col-md-4">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h5 class="fw-bold" style="margin-bottom:4px;"> Equipo </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="">Gestionar</a>
                </div>
            </div>
            <div class="card h-100">
                <div class="card-body">
                    text
                </div>
            </div>
        </div>
    </div>
@endsection

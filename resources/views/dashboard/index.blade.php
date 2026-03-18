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
                <div class="fw-bold display-6">12</div>
                <div>En proceso</div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 rounded back-success color-success">
                <div class="fw-bold display-6">45</div>
                <div>Finalizado</div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 rounded back-mora color-mora">
                <div class="fw-bold display-6">03</div>
                <div>Retrasado</div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 rounded back-tostart color-tostart">
                <div class="fw-bold display-6">08</div>
                <div>Sin empezar</div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 rounded back-pause color-pause">
                <div class="fw-bold display-6">05</div>
                <div>Pausado</div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h5 class="fw-bold">Mis próximas tareas</h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="">Ver todas</a>
        </div>

        <div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="badge bg-label-secondary">Marca</span>
                                    
                                </div>
                                <div>
                                    <span class="badge rounded-pill bg-label-danger">Alta</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h5 class="fw-bold">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h5>
                            </div>
                            <hr class="border-primary opacity-50">
                            <div class="d-flex justify-content-start">
                                <div>
                                    <i class="bx bx-calendar" style="margin-top:-4px;"></i>
                                    <span class="fw-semibold">Jueves, 14 Sept</span>
                                </div>
                                <div class="ps-3">
                                    <i class="bx bx-paperclip"></i>
                                    4
                                </div>
                                <div class="ps-3">
                                    <i class="bx bx-message"></i>
                                    12
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="badge bg-label-secondary">Marca</span>
                                    
                                </div>
                                <div>
                                    <span class="badge rounded-pill bg-label-warning">Media</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h5 class="fw-bold">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h5>
                            </div>
                            <hr class="border-primary opacity-50">
                            <div class="d-flex justify-content-start">
                                <div>
                                    <i class="bx bx-calendar" style="margin-top:-4px;"></i>
                                    <span class="fw-semibold">Jueves, 14 Sept</span>
                                </div>
                                <div class="ps-3">
                                    <i class="bx bx-paperclip"></i>
                                    4
                                </div>
                                <div class="ps-3">
                                    <i class="bx bx-message"></i>
                                    12
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="badge bg-label-secondary">Marca</span>
                                    
                                </div>
                                <div>
                                    <span class="badge rounded-pill bg-label-danger">Alta</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h5 class="fw-bold">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h5>
                            </div>
                            <hr class="border-primary opacity-50">
                            <div class="d-flex justify-content-start">
                                <div>
                                    <i class="bx bx-calendar" style="margin-top:-4px;"></i>
                                    <span class="fw-semibold">Jueves, 14 Sept</span>
                                </div>
                                <div class="ps-3">
                                    <i class="bx bx-paperclip"></i>
                                    4
                                </div>
                                <div class="ps-3">
                                    <i class="bx bx-message"></i>
                                    12
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                    <a href="">Ver todas</a>
                </div>
            </div>

            <div class="card" style="min-height:350px;">
                <div class="card-body">
                    <div>
                        <a href="">
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

                    <div class="mt-3">
                        <a href="">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-md me-4">
                                        <img src="{{ asset('assets/img/2.png') }}" class="rounded">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">Marca 1</span>
                                </div>
                            </div>
                        </a>
                    </div>

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
                                    <button type="button" class="btn btn-warning" style="background:#EC5B13;">Invitar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">Colaboradores frecuentes</div>
                    <div>
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
                    </div>

                </div>
            </div>
        </div>
    </div>
    
@endsection
@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="">
            <h4 class="fw-bold"> Usuarios </h4>
            <div>Lorem ipsum dolor sit amet consectetur. Dignissim id purus.</div>
        </div>
    </div>

    <div class="">
        <div class="card">
            <div class="table-responsive text-nowrap">
                <div class="dt-container dt-bootstrap5 dt-empty-footer  ">
                    <div class="justify-content-between dt-layout-table">
                        <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                            <table class="datatables-users table border-top dataTable dtr-column">
                                <thead>
                                    <tr>
                                        
                                        <th data-dt-column="2" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc dt-ordering-desc" aria-sort="descending" aria-label="User: Activate to remove sorting" tabindex="0">
                                            <span class="dt-column-title" role="button">Nombre</span>
                                            <span class="dt-column-order"></span>
                                        </th>
                                        <th data-dt-column="3" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc" aria-label="Role: Activate to sort" tabindex="0">
                                            <span class="dt-column-title" role="button">Rol</span>
                                            <span class="dt-column-order"></span>
                                        </th>
                                        <th data-dt-column="4" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc" aria-label="Plan: Activate to sort" tabindex="0">
                                            <span class="dt-column-title" role="button">Área</span>
                                            <span class="dt-column-order"></span>
                                        </th>
                                        <th data-dt-column="5" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc" aria-label="Billing: Activate to sort" tabindex="0">
                                            <span class="dt-column-title" role="button">Marcas Asignadas</span>
                                            <span class="dt-column-order"></span>
                                        </th>
                                        <th data-dt-column="6" rowspan="1" colspan="1" class="dt-orderable-asc dt-orderable-desc" aria-label="Status: Activate to sort" tabindex="0">
                                            <span class="dt-column-title" role="button">Estado</span>
                                            <span class="dt-column-order"></span>
                                        </th>
                                        <th data-dt-column="7" rowspan="1" colspan="1" class="dt-orderable-none text-end" aria-label="Actions">
                                            <span class="dt-column-title">Acciones</span>
                                            <span class="dt-column-order"></span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-2">
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
                                        </td>
                                        <td>
                                            <span class="badge bg-label-secondary">Super Admin</span>
                                        </td>
                                        <td>
                                            <span class="text-heading">Dirección General</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-dark">Marca 1</span> <span class="badge bg-label-dark">Marca 2</span> <span class="badge bg-label-dark">Marca 3</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center lh-1 me-4 mb-4 mb-sm-0">
                                                <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                                                Activo 
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <a href="app-user-view-account.html" class="btn btn-icon">
                                                    <i class="icon-base bx bx-pencil icon-md"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-icon delete-record">
                                                    <i class="icon-base bx bx-trash icon-md"></i>
                                                </a>
                                                <!-- 
                                                <a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end m-0">
                                                    <a href="javascript:;" class="dropdown-item">Edit</a>
                                                    <a href="javascript:;" class="dropdown-item">Suspend</a>
                                                </div>
                                                -->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-2">
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
                                        </td>
                                        <td>
                                            <span class="badge bg-label-secondary">Admin</span>
                                        </td>
                                        <td>
                                            <span class="text-heading">Dirección General</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-dark">Marca 1</span> <span class="badge bg-label-dark">Marca 2</span> <span class="badge bg-label-dark">Marca 3</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center lh-1 me-4 mb-4 mb-sm-0">
                                                <span class="email-list-item-label badge badge-dot bg-secondary d-none d-md-inline-block me-2" data-label="work"></span>
                                                Inactivo
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <a href="app-user-view-account.html" class="btn btn-icon">
                                                    <i class="icon-base bx bx-pencil icon-md"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-icon delete-record">
                                                    <i class="icon-base bx bx-trash icon-md"></i>
                                                </a>
                                                <!-- 
                                                <a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end m-0">
                                                    <a href="javascript:;" class="dropdown-item">Edit</a>
                                                    <a href="javascript:;" class="dropdown-item">Suspend</a>
                                                </div>
                                                -->
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
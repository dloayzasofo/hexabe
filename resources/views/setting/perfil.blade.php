@extends('layout')

@section('main')
    <form>
        <div class="row" style="max-width:680px;margin:auto;">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('setting.perfil.index') }}" class="nav-link active fw-bold">
                    Perfil
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('setting.notification.index') }}" class="nav-link">
                    Notificaciones
                    </a>
                </li>
            </ul>

            <div class="card mb-5 mt-5">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="pe-4">
                            <div class="perfil-picture">
                                <img src="{{ asset('assets/img/foto.png') }}">
                                <button type="button" class="btn rounded-pill btn-icon btn-warning">
                                    <i class="bx bx-camera"></i>
                                </button>
                               
                            </div>
                        </div>
                        <div>
                            <h5 class="fw-bold">Foto de perfil</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus qui eveniet. </p>
                            <div class="d-flex">
                                <button type="button" class="btn btn-warning me-3">
                                    <i class="bx bx-upload me-2"></i> Subir Nueva Foto
                                </button>
                                <button type="button" class="btn btn-label-secondary">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Nombre Completo</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Nombre del Puesto/Cargo</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder="Marketing">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Correo Electrónico</label>
                                <input type="email" class="form-control" id="basic-default-fullname" placeholder="ejemplo@correo.com">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4 pe-0">
                <button type="reset" class="btn btn-label-secondary me-sm-3">Cancelar</button>
                <button type="submit" class="btn btn-primary  me-1">Guardar Cambios</button>
            </div>
        </div>
    </form>
@endsection
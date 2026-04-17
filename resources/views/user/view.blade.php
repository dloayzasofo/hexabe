@extends('layout')
@section('title', 'Usuario view '. $model->id)

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Usuario Vista
            </h4>
        </div>
        <div class="col-sm-4 col-md-6">
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> 
                    <a href="{{route('user.index')}}" class="dt-button create-new btn btn-primary">
                        <span><i class="bx bx-arrow-back me-sm-2"></i> 
                            <span class="d-none d-sm-inline-block">Atras</span>
                        </span>
                    </a> 
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('user.change_password'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('user.change_password') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Datos</h4>
            <p><small> Creado el {{ $model->updated_at->format('d/m/Y  H:i') }} </small></p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 fw-semibold mb-3"> Nombre:</dt>
                        <dt class="col-sm-9"> {{ $model->first_name }}</dt>

                        <dt class="col-sm-3 fw-semibold mb-3"> Apellidos:</dt>
                        <dt class="col-sm-9"> {{ $model->last_name }}</dt>
                        
                        <dt class="col-sm-3 fw-semibold mb-3"> Email:</dt>
                        <dt class="col-sm-9"> {{ $model->email }}</dt>

                        <dt class="col-sm-3 fw-semibold mb-3"> Contraseña:</dt>
                        <dt class="col-sm-9"> ······ </dt>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="card-footer text-end">
            <div class="demo-inline-spacing">
                <a href="{{ route('user.edit', ['user'=> $model]) }}" class="btn btn-primary">Modificar</a>
                <a href="{{ route('user.change_password', ['user'=> $model]) }}" class="btn btn-primary">Cambiar contraseña</a>
                <button data-href="{{ route('user.delete', ['user'=> $model]) }}" class="btn btn-danger confirmDelete"
                    data-message="el usuario <b>{{$model->first_name}} {{$model->last_name}}</b>.">Eliminar</button>
            </div>
        </div>
    </div>

    @include('user._modal_delete')
@endsection

@extends('layout')
@section('title', 'Popup view '. $model->id)

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-6 col-md-6">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Popup Vista
            </h4>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> 
                    <a href="{{route('popup.index')}}" class="dt-button create-new btn btn-primary">
                        <span><i class="bx bx-arrow-back me-sm-2"></i> 
                            <span class="d-none d-sm-inline-block">Atras</span>
                        </span>
                    </a> 
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Datos</h4>
            <p><small> Creado el {{ $model->updated_at->format('d/m/Y  H:i') }} </small></p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center">
                        <div class="dropzone-image" style2="background-image: url('{{ $model->image }}')">
                            <img src="{{$model->image}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-2 fw-semibold mb-3"> Nombre:</dt>
                        <dt class="col-sm-10"> {{ $model->name }}</dt>

                        <dt class="col-sm-2 fw-semibold mb-3"> URL:</dt>
                        <dt class="col-sm-10"> {{ $model->url }}</dt>

                        <dt class="col-sm-2 fw-semibold mb-3"> Abrir:</dt>
                        <dt class="col-sm-10"> 
                            @if( $model->target )
                                Nueva pestaña
                            @else
                                Misma ventana
                            @endif
                        </dt>

                        <dt class="col-sm-2 fw-semibold mb-3"> Estado:</dt>
                        <dt class="col-sm-10"> 
                            @if( $model->active )
                                <span class="badge bg-label-success">Activado</span>
                            @else
                                <span class="badge bg-label-secondary">Desactivado</span>
                            @endif
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="card-footer text-end">
            <div class="demo-inline-spacing">
                <a href="{{ route('popup.edit', ['popup'=> $model]) }}" class="btn btn-primary">Modificar</a>
                <button data-href="{{ route('popup.delete', ['popup'=> $model]) }}" class="btn btn-danger confirmDelete"
                    data-message="el popup <b>{{$model->name}}</b>.">Eliminar</button>
            </div>
        </div>
    </div>

    @include('popup._modal_delete')
@endsection

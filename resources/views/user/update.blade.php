@extends('layout')
@section('title', 'User update '. $model->first_name)

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Modificar Usuario
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

    <form action="{{route('user.update', ['user'=> $model->id])}}" method="post">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ $model->first_name }} {{ $model->last_name }}</h4>
                <p><small> Todos los campos con * son obligatorios </small></p>
            </div>
            <div class="card-body">

                @include('user._form', ['model'=> $model])
                
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
@endsection


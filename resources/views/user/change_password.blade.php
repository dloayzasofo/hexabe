@extends('layout')
@section('title', 'Change password '. $model->first_name)

@section('main')
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Cambiar contraseña
            </h4>
        </div>
        <div class="col-md-6">
            <div class="dt-action-buttons text-end pt-3 pt-md-0">
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

    <form action="{{route('user.save_password', ['user'=> $model->id])}}" method="post">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ $model->name }} {{ $model->last_name }}</h4>
                <p><small> Todos los campos con * son obligatorios </small></p>
            </div>
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        
                        <div class="mb-3 @error('password') row-invalid  @enderror">
                            <label for="password" class="form-label">Contraseña *:</label>
                            <input id="password" type="password" name="password" class="form-control" placeholder=""
                                value="{{ old('password') }}">
                            @error('password')<p class="error">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="mb-3 @error('password_confirmation') row-invalid  @enderror">
                            <label for="password_confirmation" class="form-label">Confirmar contraseña *:</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder=""
                                value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')<p class="error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
@endsection


@extends('layout')
@section('title', 'Popup update '. $model->name)

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-6 col-md-6">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Popup Modificar
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

    <form action="{{route('popup.update', ['popup'=> $model->id])}}" method="post" enctype="multipart/form-data" >
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ $model->name }}</h4>
                <p><small> Todos los campos con * son obligatorios </small></p>
            </div>
            <div class="card-body">

                @include('popup._form', ['model'=> $model])
                
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script src="{{asset('/assets/admin/js/dropzone.js')}}"></script>
<script>
    $(document).ready(function(){
        var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'})
    });
</script>
@endsection
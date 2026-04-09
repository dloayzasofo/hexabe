{{--
@extends('layout')
@section('main')
--}}
<form id="formCreateTask" data-action="{{ route('task.save') }}" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        @include('task._form')
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning btnSaveTask">Crear tarea</button>
    </div>
</form>
{{--
@endsection
--}}
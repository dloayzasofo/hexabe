
<form id="formCreate" data-action="{{ route('team.update', ['team' => $model->id]) }}" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        @include('team._form')
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning btnSave">Agregar equipo</button>
    </div>
</form>


<form id="formBrandCreate" data-action="{{ route('team.save') }}" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        @include('team._form')
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning btnSaveBrand">Agregar equipo</button>
    </div>
</form>

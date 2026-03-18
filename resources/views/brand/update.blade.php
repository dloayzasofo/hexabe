
<form id="formBrandCreate" data-action="{{ route('brand.update', ['brand' => $model->id]) }}" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        @include('brand._form')
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning btnSaveBrand">Agregar marca</button>
    </div>
</form>

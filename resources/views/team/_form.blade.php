@csrf
<div class="mb-3">
    <label for="name" class="form-label">Nombre del equipo *</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Ej: Equipo de Diseño UX" value="{{ $model->name }}">
    <div id="errorName" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea class="form-control no-resize" id="description" name="description" placeholder="Breve descripción del equipo">{{ $model->description }}</textarea>
    <div id="errorDescription" class="error invalid-feedback"></div>
</div>


<div class="mb-3">
    <label class="switch switch-warning">
        <input id="status" type="checkbox" class="switch-input" name="status" value="1" @checked($model->status=='ACTIVE')>
        <span class="switch-toggle-slider">
            <span class="switch-on">
            <i class="icon-base bx bx-check"></i>
            </span>
            <span class="switch-off">
            <i class="icon-base bx bx-x"></i>
            </span>
        </span>
        <span class="switch-label">Activar</span>
    </label>
</div>
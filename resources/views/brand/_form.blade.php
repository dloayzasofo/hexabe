@csrf
<div class="mb-3">
    <label for="name" class="form-label">Nombre de la marca *</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Ej: Nike, Adidas" value="{{ $model->name }}">
    <div id="errorName" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="industry" class="form-label">Categoría *</label>
    <input type="text" class="form-control" id="industry" name="industry"  placeholder="categoría" value="{{ $model->industry }}">
    <div id="errorIndustry" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea class="form-control no-resize" id="description" name="description">{{ $model->description }}</textarea>
    <div id="errorDescription" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="name" class="form-label" style="margin-bottom:0px;">Subir logotipo *: </label>
    <p><small>Recomendación subir una imagen de 270x195px </small></p>
    <div class="text-center">
        <div id="dropzone" class="dropzone horizontal">
            <div class="dropzone_preview">
                <img src="{{ isset($model->image) ? $model->image : '#' }}" 
                class="{{ isset($model->image) ? '' : 'hide' }}">
            </div>
            <div class="dropzone_disclaimer">
                <h3 style="z-index:2;">
                    <svg width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.875 20C4.97917 20 3.35938 19.3438 2.01562 18.0312C0.671875 16.7188 0 15.1146 0 13.2188C0 11.5938 0.489583 10.1458 1.46875 8.875C2.44792 7.60417 3.72917 6.79167 5.3125 6.4375C5.83333 4.52083 6.875 2.96875 8.4375 1.78125C10 0.59375 11.7708 0 13.75 0C16.1875 0 18.2552 0.848959 19.9531 2.54688C21.651 4.24479 22.5 6.3125 22.5 8.75C23.9375 8.91667 25.1302 9.53646 26.0781 10.6094C27.026 11.6823 27.5 12.9375 27.5 14.375C27.5 15.9375 26.9531 17.2656 25.8594 18.3594C24.7656 19.4531 23.4375 20 21.875 20H15C14.3125 20 13.724 19.7552 13.2344 19.2656C12.7448 18.776 12.5 18.1875 12.5 17.5V11.0625L10.5 13L8.75 11.25L13.75 6.25L18.75 11.25L17 13L15 11.0625V17.5H21.875C22.75 17.5 23.4896 17.1979 24.0938 16.5938C24.6979 15.9896 25 15.25 25 14.375C25 13.5 24.6979 12.7604 24.0938 12.1562C23.4896 11.5521 22.75 11.25 21.875 11.25H20V8.75C20 7.02083 19.3906 5.54688 18.1719 4.32812C16.9531 3.10938 15.4792 2.5 13.75 2.5C12.0208 2.5 10.5469 3.10938 9.32812 4.32812C8.10938 5.54688 7.5 7.02083 7.5 8.75H6.875C5.66667 8.75 4.63542 9.17708 3.78125 10.0312C2.92708 10.8854 2.5 11.9167 2.5 13.125C2.5 14.3333 2.92708 15.3646 3.78125 16.2188C4.63542 17.0729 5.66667 17.5 6.875 17.5H10V20H6.875Z" fill="#94A3B8"/>
                    </svg>
                </h3>
                <p style="z-index:2;margin-bottom:4px;"><small> <b>Arrastra tus archivos aquí</b> o haz clic para subir </small></p>
                <p style="z-index:2;"><small> (Peso máximo 1MB)</small></p>
            </div>
        </div>
        <input type="file" name="image" id="image" class="hide" accept="image/png, image/gif, image/jpeg, image/webp">
        <div id="errorImage" class="error invalid-feedback text-start"></div>
    </div>
</div>
{{-- 
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
--}}
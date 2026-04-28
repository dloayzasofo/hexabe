@csrf
<div class="row">
    <div class="col-md-6">
        <label for="name" class="form-label">Imagen *: </label>
        <p><small>Recomendación subir una imagen de 600x500px </small></p>
        <div class="text-center">
            <div id="dropzone" class="dropzone">
                <div class="dropzone_preview">
                    <img src="{{ isset($model->image) ? $model->image : '#' }}" 
                    class="{{ isset($model->image) ? '' : 'hide' }}">
                </div>
                <div class="dropzone_disclaimer">
                <h3 style="z-index:2;">Arrastra y suelta <br> la imagen</h3>
                    <p style="z-index:2;"><small> Haz click para buscar en tu dispositivo </small></p>
                    <p style="z-index:2;"><small> (Peso máximo 1MB)</small></p>
                </div>
            </div>
            <input type="file" name="image" id="image" class="hide" accept="image/png, image/gif, image/jpeg, image/webp">
            @error('image')<p class="error">{{ $message }}</p> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3 @error('name') row-invalid  @enderror">
            <label for="name" class="form-label">Nombre *: </label>
            <input id="name" type="text" name="name" class="form-control" placeholder=""
                value="{{ old('name', $model->name) }}">
            @error('name')<p class="error">{{ $message }}</p> @enderror
            
        </div>
        <div class="mb-3 @error('url') row-invalid  @enderror">
            <label for="url" class="form-label">Enlace:</label>
            <input id="url" type="text" name="url" class="form-control" placeholder="https://"
                value="{{ old('url', $model->url) }}">
            @error('url')<p class="error">{{ $message }}</p> @enderror
            
        </div>
        <div class="mb-3">
            <label for="target" class="switch switch-success">
                <input id="target" type="checkbox" name="target" class="switch-input" value="1"
                    @if( old('target', $model->target) == '1' ) @checked(true) @endif>
                <span class="switch-toggle-slider">
                    <span class="switch-on">
                        <i class="bx bx-check"></i>
                    </span>
                    <span class="switch-off">
                        <i class="bx bx-x"></i>
                    </span>
                </span>
                <span class="switch-label">Abrir en una pestaña nueva</span>
            </label>
        </div>
        <div class="mb-3">
            <label for="active" class="switch switch-success">
                <input id="active" type="checkbox" name="active" class="switch-input" value="1"
                    @if( old('active', $model->active) == '1' ) @checked(true) @endif>
                <span class="switch-toggle-slider">
                    <span class="switch-on">
                        <i class="bx bx-check"></i>
                    </span>
                    <span class="switch-off">
                        <i class="bx bx-x"></i>
                    </span>
                </span>
                <span class="switch-label">Activar</span>
            </label>
        </div>
    </div>
</div>
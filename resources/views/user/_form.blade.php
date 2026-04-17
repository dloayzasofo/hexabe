@csrf
<div class="row">
    <div class="col-md-3">
        <div class="text-center">
            
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3 @error('name') row-invalid  @enderror">
            <label for="name" class="form-label">Nombre *: </label>
            <input id="name" type="text" name="name" class="form-control"
                value="{{ old('name', $model->name) }}" placeholder="Introduzca su nombre">
            @error('name')<p class="error">{{ $message }}</p> @enderror
            
        </div>
        <div class="mb-3 @error('last_name') row-invalid  @enderror">
            <label for="last_name" class="form-label">Apellidos *:</label>
            <input id="last_name" type="text" name="last_name" class="form-control"
                value="{{ old('last_name', $model->last_name) }}" placeholder="Introduzca sus apellidos">
            @error('last_name')<p class="error">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3 @error('email') row-invalid  @enderror">
            <label for="email" class="form-label">Email *: </label>
            <input id="email" type="email" name="email" class="form-control"
                value="{{ old('email', $model->email) }}" placeholder="Ej: ejemplo@correo.com">
            @error('email')<p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <div class="input-group input-group-lg">
                <span class="input-group-text" style="padding:5px 6px;">
                    <img src="{{ asset('assets/img/flags/flag-bo.svg') }}" style="width:26px;"> <small class="ms-1">+591</small>
                </span>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Ej: 70100001" value="{{ old('phone', $model->phone) }}"/>
            </div>
            @error('phone')<p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3 @error('role') row-invalid  @enderror">
            <label for="role" class="form-label">Rol *: </label>
            <select id="role" name="role" class="form-select">
                <option value="">Seleccione un rol</option>
                <option value="ADMIN" {{ old('role', $model->role) == 'ADMIN' ? 'selected' : '' }}>Administrador</option>
                <option value="USER" {{ old('role', $model->role) == 'USER' ? 'selected' : '' }}>Usuario</option>
            </select>
            @error('role')<p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3 @error('text') row-invalid  @enderror">
            <label for="text" class="form-label">Nombre del Puesto/Cargo *: </label>
            <input id="text" type="text" name="position" class="form-control"
                value="{{ old('position', $model->position) }}" placeholder="Ej: Gerente de Marketing">
            @error('position')<p class="error">{{ $message }}</p> @enderror
        </div>

        @if( $model->id == null )
            <div class="mb-3 @error('password') row-invalid  @enderror">
                <label for="password" class="form-label">Contraseña *:</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="******"
                    value="{{ old('password', $model->password) }}">
                @error('password')<p class="error">{{ $message }}</p> @enderror
            </div>
        @endif
    </div>
</div>
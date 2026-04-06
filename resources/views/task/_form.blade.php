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
    <label for="name" class="form-label" style="margin-bottom:0px;">Adjuntos: </label>
    <div class="text-center">
        <div id="task-files" class="dropzone horizontal">  </div>
        <div id="attach_media"></div>
        <div id="errorImage" class="error invalid-feedback text-start"></div>
    </div>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Enlaces</label>
    <div class="input-group input-group-merge">
        <span class="input-group-text" style="background:#F8FAFC;">
            <i class="icon-base bx bx-link icon-lg"></i>
        </span>
        <input type="text" id="links" name="links" class="form-control input-user-search" placeholder="https://ejemplo.com">
    </div>
    <div id="errorName" class="error invalid-feedback"></div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Prioridad *</label>
            <select class="form-select" id="priority" name="priority">
                <option value="low">Baja</option>
                <option value="medium">Media</option>
                <option value="hight">Alta</option>
            </select>
            <div id="errorName" class="error invalid-feedback"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="date_delivery" class="form-label">Fecha de entrega *</label>
            <input type="date" class="form-control" id="date_delivery" name="date_delivery" placeholder="Ej: Equipo de Diseño UX" value="{{ $model->created_at }}">
            <div id="errorDate_delivery" class="error invalid-feedback"></div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="brand" class="form-label">Asignar marca *</label>
    <select class="form-select" id="brand" name="brand">
        <option value="">Seleccione una marca</option>
        @foreach($brands as $brand)
        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
        @endforeach
    </select>
    <div id="errorBrand" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Asignar responsable *</label>
    <div class="input-group input-group-merge">
        <span class="input-group-text" style="background:#F8FAFC;">
            <div class="avatar avatar-sm me-2">
                <span id="task-responsable-avatar" class="avatar-initial rounded-circle bg-label-primary">
                    <i class="icon-base bx bx-user icon-lg"></i>
                    {{--<img src="{{ asset('/assets/img/2.png') }}" alt="Avatar" class="rounded-circle">--}}
                </span>
            </div>
        </span>
        <div class="result-search task-responsable-result"></div>
        <input type="hidden" id="user_assign" name="user_assign" value="{{ $model->user_assign }}">
        <input type="text" class="form-control task-input-responsable" id="task-input-responsable" placeholder="ejemplo@correo.com">
        <span class="input-group-text" style="background:#F8FAFC;">
            <i class="icon-base bx bx-search"></i>
        </span>
    </div>
    <div id="errorName" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Invitar miembros</label>
    
    <div class="memebers-ajax input-group hide">
        <input type="text" class="form-control task-input-member" id="task-input-member" name="task-input-member" placeholder="ejemplo@correo.com" value="">
        <div class="result-search task-members-result"></div>
    </div>

    <div class="d-flex flex-wrap align-items-center mt-2">
        <ul id="selected-members" class="list-unstyled users-list d-flex align-items-center avatar-group m-0">
            {{-- 
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Vinnie Mostowy" data-bs-original-title="Vinnie Mostowy">
                <img class="rounded-circle" src="{{ asset('assets/img/2.png') }}" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Allen Rieske" data-bs-original-title="Allen Rieske">
                <img class="rounded-circle" src="{{ asset('assets/img/4.png') }}" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Julee Rossignol" data-bs-original-title="Julee Rossignol">
                <img class="rounded-circle" src="{{ asset('assets/img/3.png') }}" alt="Avatar">
            </li>
            --}}
        </ul>
        <div class="avatar add-member">
            <span class="avatar-initial rounded-circle pull-up text-heading " data-bs-toggle="tooltip" data-bs-original-title="Agregar" style="border-style:dashed;">+</span>
        </div>
    </div>
</div>

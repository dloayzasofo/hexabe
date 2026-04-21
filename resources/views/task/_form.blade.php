@csrf
@if( isset($task) )
    <input id="parent_id" type="text" name="parent_id" value="{{ $task->id }}" class="hide">
@endif

<div class="mb-3">
    <label for="name" class="form-label">Título *</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Ej: Equipo de Diseño UX" value="{{ $model->name }}">
    <div id="errorName" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción </label>
    <div id="toolbarDescription" class="ql-toolbar ql-snow">
        <span class="ql-formats">
            <button class="ql-bold" type="button">
                <svg viewBox="0 0 18 18"> 
                    <path class="ql-stroke" d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z"></path> 
                    <path class="ql-stroke" d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z"></path> 
                </svg>
            </button>
            <button class="ql-link" type="button">
                <svg viewBox="0 0 18 18"> 
                    <line class="ql-stroke" x1="7" x2="11" y1="7" y2="11"></line> 
                    <path class="ql-even ql-stroke" d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z"></path> <path class="ql-even ql-stroke" d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z"></path> 
                </svg>
            </button>
            <button class="ql-list" value="ordered" type="button">
                <svg viewBox="0 0 18 18"> 
                    <line class="ql-stroke" x1="7" x2="15" y1="4" y2="4"></line> 
                    <line class="ql-stroke" x1="7" x2="15" y1="9" y2="9"></line> 
                    <line class="ql-stroke" x1="7" x2="15" y1="14" y2="14"></line> 
                    <line class="ql-stroke ql-thin" x1="2.5" x2="4.5" y1="5.5" y2="5.5"></line> 
                    <path class="ql-fill" d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z"></path> 
                    <path class="ql-stroke ql-thin" d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156"></path> 
                    <path class="ql-stroke ql-thin" d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109"></path>
                </svg>
            </button>
            <button class="ql-list" value="bullet" type="button">
                <svg viewBox="0 0 18 18"> 
                    <line class="ql-stroke" x1="6" x2="15" y1="4" y2="4"></line> 
                    <line class="ql-stroke" x1="6" x2="15" y1="9" y2="9"></line> 
                    <line class="ql-stroke" x1="6" x2="15" y1="14" y2="14"></line> <line class="ql-stroke" x1="3" x2="3" y1="4" y2="4"></line> <line class="ql-stroke" x1="3" x2="3" y1="9" y2="9"></line> 
                    <line class="ql-stroke" x1="3" x2="3" y1="14" y2="14"></line> 
                </svg>
            </button>
        </span>
    </div>
    <div id="editorDescription" class="quill-area" style="min-height:50px;">{!! old('description', $model->description) !!}</div>
    <textarea name="description" id="description" class="hide">{!! old('description', $model->description) !!}</textarea>
    <p id="errorDescription" class="error invalid-feedback"> @error('description') {{ $message }} @enderror</p> 
</div>

{{--
<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea class="form-control no-resize" id="description" name="description" placeholder="">{{ $model->description }}</textarea>
    <div id="errorDescription" class="error invalid-feedback"></div>
</div>
--}}
<div class="mb-3">
    <label for="attach" class="form-label" style="margin-bottom:0px;">Adjuntos </label>
    <div class="text-center">
        <div id="task-files" class="dropzone horizontal">  </div>
        <div id="attach_media"></div>
        <div id="errorImage" class="error invalid-feedback text-start"></div>
    </div>
</div>

<div class="mb-3">
    <div class="d-flex align-items-center mb-2">
        <label for="links" class="form-label" style="margin-bottom:0px;">Enlaces</label>
        <button type="button" class="btnAddLink" style="background:transparent;border:none;transform:translateY(-2px);">
            <i class="bx bx-plus"></i>
        </button>
    </div>
    <div id="links-container">
        <div class="input-group input-group-merge mb-2">
            <span class="input-group-text" style="background:#F8FAFC;">
                <i class="icon-base bx bx-link icon-lg"></i>
            </span>
            <input type="text" name="links[]" class="form-control input-user-search" placeholder="https://ejemplo.com">
        </div>
    </div>
    <div id="errorLinks" class="error invalid-feedback"></div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="priority" class="form-label">Prioridad *</label>
            <select class="form-select" id="priority" name="priority">
                <option value="low">Baja</option>
                <option value="medium">Media</option>
                <option value="high">Alta</option>
            </select>
            <div id="errorPriority" class="error invalid-feedback"></div>
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

<div class="mb-3 @if( isset($task) ) hide @endif">
    <label for="brand" class="form-label">Asignar marca *</label>
    <select class="form-select" id="brand" name="brand">
        <option value="">Seleccione una marca</option>
        @foreach($brands as $brand)
        <option value="{{ $brand->id }}" @if(isset($task) && $brand->id == $task->brand_id) selected @endif>{{ $brand->name }}</option>
        @endforeach
    </select>
    <div id="errorBrand" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="user_assign" class="form-label">Asignar responsable *</label>
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
        <input type="text" class="form-control task-input-responsable" id="task-input-responsable" placeholder="ejemplo@correo.com" autocomplete="do-not-autofill">
        <span class="input-group-text" style="background:#F8FAFC;">
            <i class="icon-base bx bx-search"></i>
        </span>
    </div>
    <div id="errorName" class="error invalid-feedback"></div>
</div>

<div class="mb-3">
    <label for="members" class="form-label">Invitar miembros</label>
    
    <div class="memebers-ajax input-group hide">
        <input type="text" class="form-control task-input-member" id="task-input-member" name="task-input-member" 
            placeholder="ejemplo@correo.com" value="" 
            autocomplete="do-not-autofill"
            readonly onfocus="this.removeAttribute('readonly');">
        <div class="result-search task-members-result"></div>
    </div>

    <div class="d-flex flex-wrap align-items-center mt-2">
        <ul id="selected-members" class="list-unstyled users-list d-flex align-items-center avatar-group m-0"></ul>
        <div class="avatar add-member">
            <span class="avatar-initial rounded-circle pull-up text-heading " data-bs-toggle="tooltip" data-bs-original-title="Agregar" style="border-style:dashed;">+</span>
        </div>
    </div>
</div>

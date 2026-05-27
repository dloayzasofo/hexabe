<div class="card mt-4">
    <div class="card-body">
        <div class="mb-2"><small>DUEÑO DEL PROYECTO</small></div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-md me-3">
                        @if( $task->user->image != null )
                            <img src="{{ $task->user->image }}" alt="Avatar" class="rounded-2">
                        @else 
                            <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->user->nameInitial }}</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="{{ route('task.user.list', [$task->user]) }}" class="text-heading text-truncate">
                        <span class="fw-medium">{{ $task->user->name }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-2 mt-4"><small>RESPONSABLE</small></div>
        <div class="d-flex justify-content-between align-items-center hoverEdit">
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                    <div id="assignImage" class="avatar avatar-md me-3">
                        @if( $task->assign->image != null )
                            <img src="{{ $task->assign->image }}" alt="Avatar" class="rounded-2">
                        @else 
                            <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->assign->nameInitial }}</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a id="assignUrl" href="{{ route('task.user.list', [$task->assign]) }}" class="text-heading text-truncate">
                        <span id="assignName" class="fw-medium">{{ $task->assign->name }}</span>
                    </a>
                </div>
            </div>
            <div>
                <button id="btnEditAssign" class="btn rounded-pill btn-icon btn-outline-secondary me-2 btnTaskEdit" data-bs-toggle="modal" data-bs-target="#userModal">
                    <i class="bx bx-pencil"></i> 
                </button>
            </div>
        </div>

        <div class="mb-2 mt-4"><small>FECHA LÍMITE</small></div>
        <div class="d-flex justify-content-between hoverEdit">
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <i class="bx bx-calendar"></i>
                </div>
                <div id="modelDate">
                    {{ Carbon\Carbon::parse($task->date_delivery)->format('d/m/Y') }}
                </div>
            </div>
            <div>
                <button id="btnEditDate" class="btn rounded-pill btn-icon btn-outline-secondary me-2 btnTaskEdit" data-bs-toggle="modal" data-bs-target="#dateModal"> 
                    <i class="bx bx-pencil"></i> 
                </button>
            </div>
        </div>

        <div class="mb-2 mt-4"><small>DEPENDENCIA</small></div>
        <div class="d-flex justify-content-between hoverEdit">
            <div class="d-flex align-items-center w-100 pe-2">
                <input type="hidden" id="dependencyId" value="{{ $task->info != null && $task->info->dependency != null ? $task->info->dependency->id : '' }}">
                @if( $task->info != null && $task->info->dependency != null )
                <div id="dependencySelect" class="d-flex align-items-center mt-2">
                    <div class="me-3">
                        @if( $task->info->dependency->status == 'FINALIZED' )
                        <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none" style="color:#22C55E;">
                            <i class="icon-base bx  bx-check-circle " style="font-size:25px;"></i>
                        </span>
                        @else
                        <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                            <i class="icon-base bx  bx-circle " style="font-size:25px;"></i>
                        </span>
                        @endif
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-3">
                            <div>
                                <a href="{{ route('task.view', [$task->info->dependency->id]) }}" class="mb-0 text-heading">
                                    {{ $task->info->dependency->title }} <br>
                                </a>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-icon text-danger btnDeleteDependency" type="button" data-id="{{ $task->info->dependency->id }}">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
                @else
                <div id="dependencySelect" class="d-flex align-items-center mt-2">
                    <small class="text-muted">S/N</small>
                </div>
                @endif
                <div id="wrapperDependency" class="w-100" style="display:none;">
                    <input id="inputDependency" class="form-control w-100" type="text" placeholder="Buscar tarea..." autocomplete="off">
                    <div id="resultDependency" class="list-group mt-2" style="max-height:200px; overflow-y:auto;"> </div>
                </div>
            </div>
            <div>
                <button id="btnEditDependency" class="btn rounded-pill btn-icon btn-outline-secondary me-2 btnTaskEdit"> 
                    <i class="bx bx-pencil"></i> 
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let btnEditDependency = document.querySelector('#btnEditDependency');
    let inputDependency = document.querySelector('#inputDependency');

    btnEditDependency.addEventListener('click', handleClickEditDependency);
    inputDependency.addEventListener('keyup', handleKeyUpDependency);

    document.addEventListener('click', function(event) {
        if( event.target.closest('.btnDeleteDependency') ){
            let element = event.target.closest('.btnDeleteDependency');
            handlerDeleteDependency(element);
        }
    });

    function handleClickEditDependency(){
        let wrapperDependency = document.querySelector('#wrapperDependency');
        let resultDependency = document.querySelector('#resultDependency');
        let dependencySelect = document.querySelector('#dependencySelect');

        if( wrapperDependency.style.display == 'block' ){
            wrapperDependency.style.display = 'none';
            resultDependency.innerHTML = '';
            dependencySelect.style.setProperty('display', 'flex', 'important');
            return true;
        }

        dependencySelect.style.setProperty('display', 'none', 'important');
        wrapperDependency.style.display = 'block';

        inputDependency.value = '';
        inputDependency.focus();

    }

    function handleKeyUpDependency(event){
        let value = inputDependency.value.trim();
        let resultContainer = document.querySelector('#resultDependency');
        resultContainer.innerHTML = '';
        
        if( value.length < 2 ){
            return true;
        }

        let brandId = {{ $task->brand_id }};
        let url = "{{ route('task.info.brand', ':id') }}".replace(':id', brandId);
        url += `?t={{ $task->id }}&s=${value}`;

        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderDependencyBrand(data.data);
            }
        })
        .catch(error => {
            //alert('Error al cargar las dependencias');
        });
    }

    function renderDependencyBrand(data){
        let resultContainer = document.querySelector('#resultDependency');
        resultContainer.innerHTML = '';

        if(data.length > 0){
            data.forEach(task => {
                let item = document.createElement('div');
                item.classList.add('list-group-item', 'list-group-item-action', 'px-2', 'cursor-pointer', 'item-dependency');
                item.setAttribute('data-id', task.id);
                item.setAttribute('data-title', task.title);
                item.setAttribute('data-status', task.status);
                item.setAttribute('data-date', task.date_delivery);

                let html = '';
                if( task.status == 'FINALIZED' ){
                    html = `<span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none" style="color:#22C55E;">
                            <i class="icon-base bx  bx-check-circle " style="font-size:25px;"></i>
                        </span>`;
                } else {
                    html = `<span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                        <i class="icon-base bx  bx-circle " style="font-size:25px;"></i>
                    </span>`;
                }

                html += `<span>${task.title}</span>`;
                item.innerHTML = html;
                item.addEventListener('click', handleSelectItemDependency);
                resultContainer.appendChild(item);
            });
            resultContainer.style.display = 'block';
        } else {
            resultContainer.innerHTML = '<div class="text-center text-muted list-group-item list-group-item-action px-2">No se encontraron resultados</div>';
        }
    }

    function handleSelectItemDependency(){
        let resultDependency = document.querySelector('#resultDependency');
        let wrapperDependency = document.querySelector('#wrapperDependency');

        let taskId = this.getAttribute('data-id');
        let taskTitle = this.getAttribute('data-title');
        let taskStatus = this.getAttribute('data-status');

        inputDependency.value = '';
        resultDependency.innerHTML = '';

        let html = '';
        if( taskStatus == 'FINALIZED' ){
            html = `<div class="me-3"><span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none" style="color:#22C55E;">
                    <i class="icon-base bx  bx-check-circle " style="font-size:25px;"></i>
                </span></div>`;
        } else {
            html = `<div class="me-3"><span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                <i class="icon-base bx  bx-circle " style="font-size:25px;"></i>
            </span></div>`;
        }

        let url = "{{ route('task.view', ':id') }}".replace(':id', taskId);

        html += `<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-3">
                        <div>
                            <a href="${url}" class="mb-0 text-heading">
                                ${taskTitle} <br>
                            </a>
                        </div>
                    </div>
                </div>
                <button class="btn btn-icon text-danger btnDeleteDependency" type="button" data-id="${taskId}">
                    <i class="bx bx-trash"></i>
                </button>`;

        let dependencySelect = document.querySelector('#dependencySelect');
        dependencySelect.innerHTML = html;

        wrapperDependency.style.display = 'none';
        dependencySelect.style.display = 'block';

        sendServerDependency(taskId);
    }

    function sendServerDependency(taskDependencyId){
        let url = "{{ route('task.api.edit.dependency', [':task', ':dependency']) }}".replace(':task', {{ $task->id }}).replace(':dependency', taskDependencyId);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                //success
            }
        })
        .catch(error => {
            console.log(error);
            alert("Error al asignar la dependencia\npor favor recargue la pantalla y vuelva a intentarlo.");
        });
    }

    function handlerDeleteDependency(element){
        let dependencyId = element.getAttribute('data-id');
        console.log(dependencyId);
        
        let url = "{{ route('task.api.delete.dependency', [':task', ':dependency']) }}".replace(':task', {{ $task->id }}).replace(':dependency', dependencyId);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let dependencySelect = document.querySelector('#dependencySelect');
                dependencySelect.innerHTML = '<small class="text-muted">S/N</small>';
            }
        })
        .catch(error => {
            console.log(error);
            alert("Error al eliminar la dependencia\npor favor recargue la pantalla y vuelva a intentarlo.");
        });
    }

</script>
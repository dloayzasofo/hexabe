<div class="modal fade hide" id="makeSubtaskModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel1">Convertir en subtarea</h5>
                    <p>Convertir esta tarea en una subtarea de otra que pertenece a la misma marca.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Buscar tarea *</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" style="background:#F8FAFC;">
                            <div class="avatar avatar-sm me-2">
                                <span id="task-responsable-avatar" class="avatar-initial rounded-circle bg-label-primary">
                                        <i class="icon-base bx bx-list-check icon-lg"></i>
                                </span>
                            </div>
                        </span>
                        <div class="result-search task-subtask-result"></div>
                        <input type="text" class="form-control task-input-subtask" id="task-input-subtask" placeholder="Ej: Implementar diseño" autocomplete="off" value="">
                        <span class="input-group-text" style="background:#F8FAFC;">
                            <i class="icon-base bx bx-search"></i>
                        </span>
                        <input type="hidden" id="make_subtask" name="make_subtask" value="">
                        <div id="errorMake_subtask" class="error invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnMakeSubtaskSave" type="button" class="btn btn-primary">Guardar cambio</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#btnMakeSubtaskSave').addEventListener('click', handleMakeSubstaskSave);
    let urlUpdateMakeSubstask = "{{ route('task.api.edit.make_subtask', ['task' => $task->id]) }}";
    document.querySelector('#btnmakeSubtask').addEventListener('click', handleMakeSubstaskOpenModal);

    function handleMakeSubstaskOpenModal(){
        let inputMemeber = document.querySelector('#task-input-subtask');
        let inputMakeSubtask = document.querySelector('#make_subtask');
        inputMemeber.value = '';
        inputMakeSubtask.value = '';
        cleanErrorMakeSubstask();
    }

    function handleMakeSubstaskSave(){
        let btnMakeSubtaskSave = document.querySelector('#btnMakeSubtaskSave');
        btnMakeSubtaskSave.disabled = true;
        let makeSubtask = document.querySelector('#make_subtask').value;

        if( validateMakeSubtask() == false ){
            btnMakeSubtaskSave.disabled = false;
            return;
        }

        fetch(urlUpdateMakeSubstask, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'subtask': makeSubtask
            })
        }).then(response => response.json())
        .then(data => {
            btnMakeSubtaskSave.disabled = false;
            if( data.success ){
                location.reload();
                //console.log(data.data);
            }
        });
    }

    function validateMakeSubtask(){
        let makeSubtask = document.querySelector('#make_subtask').value;
        if( makeSubtask.trim() == '' ){
            let elementError = document.querySelector('#errorMake_subtask');
            elementError.innerHTML = 'Debe seleccionar una subtarea';
            elementError.classList.add('is-invalid');
            let inputElement = elementError.parentNode.querySelector('#make_subtask');
            inputElement.classList.add('is-invalid');
            return false;
        }
        return true;
    }

    function cleanErrorMakeSubstask(){
        let elementError = document.querySelector('#errorMake_subtask');
        elementError.innerHTML = '';
        elementError.classList.remove('is-invalid');
        let inputElement = elementError.parentNode.querySelector('#make_subtask');
        inputElement.classList.remove('is-invalid');
    }

    document.addEventListener('keyup', (e) => {
        if (e.target.classList.contains('task-input-subtask')) {
            document.querySelector('#errorMake_subtask').innerHTML = '';
            if( e.target.value.length < 2){
                document.querySelector('.task-subtask-result').classList.remove('active');
                return;
            }
            const regex = /^[a-zA-Z0-9]$/;
            if( regex.test(e.key) || e.key == 'Backspace'){
                searchByKeyPressSubtasks(e.target.value);
            }
        }
    });

    function searchByKeyPressSubtasks(value){
        let urlSearchSubtasksByKey = "{{ route('task.api.search.subtasks', ['task' => $task->id]) }}";
        let result = document.querySelector('.task-subtask-result');
        if( value.trim() == '' ){
            result.innerHTML = '';
            result.classList.remove('active');
            return;
        }
        
        fetch(urlSearchSubtasksByKey + '?q=' + value, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                return;
            }
            console.log(data);
            handlerRenderSubtasksByKey(data.data);
        })
        .catch((e) => {
            console.log("Error Catch", e);
        });
    }

    function handlerRenderSubtasksByKey(data){
        let result = document.querySelector('.task-subtask-result');
        let inputMemeber = document.querySelector('#task-input-subtask');

        result.innerHTML = '';
        if( data.length == 0 ){
            result.classList.remove('active');
            return;
        }

        data.forEach(task => {
            const existing = null;
            if ( existing == null ) {
                let div = document.createElement('div');
                
                let icon = '<span class="avatar-initial rounded-circle bg-label-primary" style="width:32px; height:32px; display:inline-block; text-align:center; padding-top:6px;">' + task.user_assign.nameInitial + '</span> ';

                if( task.user_assign.image ) {
                    icon = '<img src="' + task.user_assign.image + '" class="avatar rounded-circle"/>';
                }

                let status = '';
                switch (task.status) {
                    case 'TOSTART':
                        status = '<span class="badge bg-label-info">Sin empezar</span>';
                        break;
                    case 'PAUSED':
                        status = '<span class="badge bg-label-warning">Pausada</span>';
                        break;
                    case 'PROCESS':
                        status = '<span class="badge bg-label-info">En Proceso</span>';
                        break;
                    case 'FINALIZED':
                        status = '<span class="badge bg-label-success">Finalizada</span>';
                        break;
                    case 'DELAY':
                        status = '<span class="badge bg-label-danger">Retrasada</span>';
                        break;
                }

                
                let htmlTable = `
                <table style="width:100%; border-collapse: collapse; border-spacing: 0;">
                    <tr>
                        <td width="45" style="padding-right:7px;">${icon}</td>
                        <td>
                            <div>${task.title}</div>
                            <div class="d-flex justify-content-between">
                                <div><small><em>${task.date_ini}</em></small></div>
                                <div>${status}</div>
                            </div>
                        </td>
                    </tr>    
                </table>
                `;

                div.innerHTML = htmlTable;
                div.classList.add('task-subtask-result-item', 'cursor-pointer');
                div.addEventListener('click', () => {
                    addSelectedSubstask(task);
                    result.classList.remove('active');
                });
                result.appendChild(div);
            }
        });

        if( result.innerHTML != '' ){
            result.classList.add('active');
        }
    }

    function addSelectedSubstask(task){
        let inputMakeSubtask = document.querySelector('#make_subtask');
        let taskInputSubtask = document.querySelector('#task-input-subtask');

        inputMakeSubtask.value = task.id;
        taskInputSubtask.value = task.title;
    }
    
</script>
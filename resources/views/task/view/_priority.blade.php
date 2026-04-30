<div class="modal fade hide" id="priorityModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar prioridad</h5>
                    <p>Seleccione la prioridad de la tarea a actualizar</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="small fw-medium fw-bold mb-2">
                        Seleccionar
                    </div>
                    <div class="switches-stacked" style="position:relative;left:50%;transform:translateX(-50%);">
                        <label class="switch">
                            <input type="radio" class="switch-input" name="switches-priority" value="low" @if( $task->priority == 'low' ) checked @endif>
                            <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Prioridad baja</span>
                        </label>

                        <label class="switch">
                            <input type="radio" class="switch-input" name="switches-priority" value="medium" @if( $task->priority == 'medium' ) checked @endif>
                            <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Prioridad media</span>
                        </label>

                        <label class="switch">
                            <input type="radio" class="switch-input" name="switches-priority" value="high" @if( $task->priority == 'high' ) checked @endif>
                            <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Prioridad alta</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnPrioritySave" type="button" class="btn btn-primary">Guardar cambio</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#btnPrioritySave').addEventListener('click', handlePrioritySave);

    let urlUpdatePriority = "{{ route('task.api.edit.priority', ['task' => $task->id]) }}";
    function handlePrioritySave(){
        document.querySelector('#btnPrioritySave').disabled = true;
        let priority = document.querySelector('input[name="switches-priority"]:checked').value;

        fetch(urlUpdatePriority, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                priority: priority
            })
        }).then(response => response.json())
        .then(data => {
            document.querySelector('#btnPrioritySave').disabled = false;
            if( data.success ){
                handleResponsePriority(data.data);
            }
        });
    }
    
    function handleResponsePriority(data){
        let priority = data.priority;
        $('#modelPriority').removeClass(['bg-label-primary','bg-label-danger','bg-label-warning']);

        if( priority == 'low' ){ 
            $('#modelPriority').addClass('bg-label-primary');
            $('#modelPriority').html('Prioridad baja');
        }
        if( priority == 'medium' ){ 
            $('#modelPriority').addClass('bg-label-warning');
            $('#modelPriority').html('Prioridad media');
        }
        if( priority == 'high' ){ 
            $('#modelPriority').addClass('bg-label-danger');
            $('#modelPriority').html('Prioridad alta');
        }
        $('#priorityModal').modal('hide');
    }
</script>
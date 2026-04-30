<div class="modal fade hide" id="statusModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar estado</h5>
                    <p>Seleccione el estado de la tarea a actualizar</p>
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
                            <input type="radio" class="switch-input" name="switches-status" value="TOSTART" @if( $task->status == 'TOSTART' ) checked @endif>
                            <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Sin empezar</span>
                        </label>

                        <label class="switch">
                            <input type="radio" class="switch-input" name="switches-status" value="PROCESS" @if( $task->status == 'PROCESS' ) checked @endif>
                            <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">En proceso</span>
                        </label>

                        <label class="switch">
                            <input type="radio" class="switch-input" name="switches-status" value="DELAY" @if( $task->status == 'DELAY' ) checked @endif>
                            <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Retrasado</span>
                        </label>

                        <label class="switch">
                            <input type="radio" class="switch-input" name="switches-status" value="PAUSED" @if( $task->status == 'PAUSED' ) checked @endif>
                            <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Pausado</span>
                        </label>

                        <label class="switch">
                            <input type="radio" class="switch-input" name="switches-status" value="FINALIZED" @if( $task->status == 'FINALIZED' ) checked @endif>
                            <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            </span>
                            <span class="switch-label">Finalizado</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnStatusSave" type="button" class="btn btn-primary">Guardar cambio</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#btnStatusSave').addEventListener('click', handleStatusSave);

    let urlUpdateStatus = "{{ route('task.api.edit.status', ['task' => $task->id]) }}";
    function handleStatusSave(){
        document.querySelector('#btnStatusSave').disabled = true;
        let status = document.querySelector('input[name="switches-status"]:checked').value;

        fetch(urlUpdateStatus, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                status: status
            })
        }).then(response => response.json())
        .then(data => {
            document.querySelector('#btnStatusSave').disabled = false;
            if( data.success ){
                handleResponseStatus(data.data);
            }
        });
    }
    
    function handleResponseStatus(data){
        let status = data.status;
        $('#modelStatus').removeClass(['bg-label-secondary','bg-label-primary','bg-label-danger','bg-label-warning','bg-label-success']);

        if( status == 'TOSTART' ){ 
            $('#modelStatus').addClass('bg-label-secondary');
            $('#modelStatus').html('Sin empezar');
        }
        if( status == 'PROCESS' ){ 
            $('#modelStatus').addClass('bg-label-primary');
            $('#modelStatus').html('En proceso');
        }
        if( status == 'DELAY' ){ 
            $('#modelStatus').addClass('bg-label-danger');
            $('#modelStatus').html('Retrasado');
        }
        if( status == 'PAUSED' ){ 
            $('#modelStatus').addClass('bg-label-warning');
            $('#modelStatus').html('Pausado');
        }
        if( status == 'FINALIZED' ){ 
            $('#modelStatus').addClass('bg-label-success');
            $('#modelStatus').html('Finalizado');
        }
        $('#statusModal').modal('hide');
    }
</script>
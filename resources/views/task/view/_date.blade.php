<div class="modal fade hide" id="dateModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar fecha de entrega</h5>
                    <p>Configure la fecha de entrega de la tarea</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Fecha *</label>
                    <div class="d-flex">
                        <input type="date" class="form-control" id="updateDate" name="updateDate" 
                            onclick="this.showPicker()"  value="{{ isset($task->date_delivery) ? Carbon\Carbon::parse($task->date_delivery)->format('Y-m-d') : '' }}">
                        <input type="time" class="form-control" id="updateTime" name="updateTime" 
                            onclick="this.showPicker()"  value="{{ isset($task->date_delivery) ? Carbon\Carbon::parse($task->date_delivery)->format('H:i') : '' }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnDateSave" type="button" class="btn btn-primary">Guardar cambio</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#btnDateSave').addEventListener('click', handleTitleSave);
    let urlUpdateDateEnd = "{{ route('task.api.edit.date', ['task' => $task->id]) }}";
    function handleTitleSave(){
        document.querySelector('#btnDateSave').disabled = true;
        let updateDate = document.querySelector('#updateDate').value;
        let updateTime = document.querySelector('#updateTime').value;

        fetch(urlUpdateDateEnd, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'date_delivery': updateDate,
                'time_delivery': updateTime,
            })
        }).then(response => response.json())
        .then(data => {
            document.querySelector('#btnDateSave').disabled = false;
            if( data.success ){
                handleResponseDate(data.data);
            }
        });
    }
    
    function handleResponseDate(data){
        let date_delivery = data.date_delivery;
        let dateTimeArray = date_delivery.split(' ');
        let dateArray = dateTimeArray[0].split('-');
        let dateString = dateArray[2] + '/' + dateArray[1] + '/' + dateArray[0] + ' ' + dateTimeArray[1];

        document.querySelector('#modelDate').innerHTML = dateString;
        $('#dateModal').modal('hide');
    }
    
</script>
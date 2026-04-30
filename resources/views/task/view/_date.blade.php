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
                    <input type="date" class="form-control" id="updateDate" name="updateDate" onclick="this.showPicker()"  value="{{ $task->date_delivery }}">
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
    let urlUpdateDate = "{{ route('task.api.edit.date', ['task' => $task->id]) }}";
    function handleTitleSave(){
        document.querySelector('#btnDateSave').disabled = true;
        let updateDate = document.querySelector('#updateDate').value;

        fetch(urlUpdateDate, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'date_delivery': updateDate,
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
        let dateArray = date_delivery.split('-');
        let dateString = dateArray[2] + '/' + dateArray[1] + '/' + dateArray[0];

        document.querySelector('#modelDate').innerHTML = dateString;
        $('#dateModal').modal('hide');
    }
    
</script>
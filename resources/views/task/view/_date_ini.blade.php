<div class="modal fade hide" id="dateModalIni" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar fecha de inicio</h5>
                    <p>Configure la fecha de inicio de la tarea</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Fecha *</label>
                    <div class="d-flex">
                        <input type="date" class="form-control" id="updateDateIni" name="updateDateIni" 
                            onclick="this.showPicker()"  value="{{ isset($task->date_ini) ? Carbon\Carbon::parse($task->date_ini)->format('Y-m-d') : '' }}">
                        <input type="time" class="form-control" id="updateTimeIni" name="updateTimeIni" 
                            onclick="this.showPicker()"  value="{{ isset($task->date_ini) ? Carbon\Carbon::parse($task->date_ini)->format('H:i') : '' }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnDateSaveIni" type="button" class="btn btn-primary">Guardar cambio</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#btnDateSaveIni').addEventListener('click', handleDateSaveIni);
    let urlUpdateDate = "{{ route('task.api.edit.date_ini', ['task' => $task->id]) }}";
    function handleDateSaveIni(){
        document.querySelector('#btnDateSaveIni').disabled = true;
        let updateDateIni = document.querySelector('#updateDateIni').value;
        let updateTimeIni = document.querySelector('#updateTimeIni').value;

        fetch(urlUpdateDate, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'date_ini': updateDateIni,
                'time_ini': updateTimeIni,
            })
        }).then(response => response.json())
        .then(data => {
            document.querySelector('#btnDateSaveIni').disabled = false;
            if( data.success ){
                handleResponseDateIni(data.data);
            }
        });
    }
    
    function handleResponseDateIni(data){
        let date_ini = data.date_ini;
        let dateTimeArray = date_ini.split(' ');
        let dateArray = dateTimeArray[0].split('-');
        let dateString = dateArray[2] + '/' + dateArray[1] + '/' + dateArray[0] + ' ' + dateTimeArray[1];

        document.querySelector('#modelDateIni').innerHTML = dateString;
        $('#dateModalIni').modal('hide');
    }
    
</script>
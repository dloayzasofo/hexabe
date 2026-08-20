@extends('layout')

@section('main')
	<div class="wrap-toast"></div>

    <div class="loading hide">
        <div class="spinner-border spinner-border-lg text-primary" role="status">
            <span class="visually-hidden"></span>
        </div>
        <div class="mt-2">
            Cargando...
        </div>
    </div>

    <div>
        <div id="calendar"></div>
    </div>

    <div class="modal fade " id="modalCenter" tabindex="-1" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title fw-bold" id="modalTitle"></h5>
						<div id="modalDescription"></div>
					</div>                    
				</div>
				<div id="popup"></div>
			</div>
		</div>
	</div>
@endsection
@section('script')
<script src="{{ asset('/assets/admin/js/fullcalendar/fullcalendar.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            editable: false, // Evita modificar el evento
            events: [],
            weekends: false,
            eventContent: function( info ) {
                return {html: info.event.title};
            },
            eventClick: function(info) {
                window.location.href = 'https://' + location.hostname + '/task/view/' + info.event.id;
            },
            eventDrop: function(info) {
                handleChangeDate(info.event);
            },
            datesSet: function(info) {
                //document.querySelector('.loading').classList.remove('hide');
                handleChangeMonth(info.startStr, info.endStr);
            }
            //dateClick: function(info) {
            //    alert('a day has been clicked!');
            //    console.log(info.dateStr);
            //}
        });
        calendar.render();
    });

    function handleChangeMonth(dateIni, dateEnd){
        let url = "{{ route('report.calendar.list') }}";
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                date_ini: dateIni,
                date_end: dateEnd
            })
        }).then(response => response.json())
        .then(data => {
            if( data.success){
                handleRenderEvents(data.data);
            }
        });
    }

    function handlerSuccessChangeDate(data){
        const wrapToast = document.querySelector('.wrap-toast');
        let classAlert = data.success ? 'bg-success' : 'bg-danger';
        let idRandom = Math.random().toString(36).substring(2, 9);
        let message = `La tarea "${data.data.title}" ha sido movida a la fecha: ${data.data.date_delivery}`;
        let html = `
            <div id="${idRandom}" class="bs-toast toast fade hide ${classAlert}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
              <div class="toast-header">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">Mensaje</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">${ message }</div>
            </div>
        `;

        wrapToast.insertAdjacentHTML('beforeend', html);
        setTimeout(() => {
            const toastElement = document.getElementById(idRandom);
            if (toastElement) {
              const toast = new bootstrap.Toast(toastElement);
              toast.show();
            }
        }, 150);
    }

    function handleRenderEvents(data){
        document.querySelector('.loading').classList.add('hide');
        calendar.removeAllEvents();
        let image = '';
        let status = '';
        let color = '';

        for(let i=0; i < data.length; i++){
            let task = data[i];

            if( task.assign.image ){
                image = `<img class="rounded-circle" src="${ task.assign.image }" title="${ task.assign.name }">`;
            }else{
                image = `<span class="avatar-initial rounded-circle bg-label-primary" title="${ task.assign.name }">${ task.assign.nameInitial }</span>`;
            }

            if( task.status == 'TOSTART' ){
                status = '<span class="badge rounded-pill bg-label-secondary">Sin empezar</span>';
                color = '#F8FAFC';
            }else if( task.status == 'PROCESS' ){
                status = '<span class="badge rounded-pill bg-label-primary">En proceso</span>';
                color = '#EFF6FF';
            }else if( task.status == 'DELAY' ){
                status = '<span class="badge rounded-pill bg-label-danger">Retrasado</span>';
                color = '#FEF2F2';
            }else if( task.status == 'PAUSED' ){
                status = '<span class="badge rounded-pill bg-label-warning">Pausado</span>';
                color = '#FFF7ED';
            }else if( task.status == 'FINALIZED' ){
                status = '<span class="badge rounded-pill bg-label-success">Finalizado</span>';
                color = '#F0FDF4';
            }else if( task.status == 'FINALIZED_DELAY' ){
                status = '<span class="badge rounded-pill bg-label-danger">Finalizado</span>';
                color = '#FEF2F2';
            }

            const hours = task.hours == '-' ? '' : task.hours;
            const htmlHours = '<span class="calendar-item-hours">' + task.hour_literal + '</span>';

            calendar.addEvent({
                id: task.id,
                title: `<div class="calendar-item ${ task.status.toLowerCase() }"> 
                    <div> 
                        ${image}
                        ${status}
                    </div> 
                    <div> 
                        ${task.title} 
                        ${htmlHours}
                    </div>
                </div>`,
                start: task.date_delivery,
                color: color,
                textColor: '#313131',
                borderColor: '#eaeaea',
            });
        }
    }
</script>
@endsection
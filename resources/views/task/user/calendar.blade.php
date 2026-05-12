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

  	<div class="btn-add-task"> 
      	<button id="btnCreate" class="btn rounded-pill btn-icon btn-primary" title="Crear nueva tarea">
          	<span><i class="bx bx-plus"></i></span>
      	</button> 
  	</div>

	<div class="row sm-vl-base mb-2">
		<div class="col-sm-8 col-md-6">
			<h4 class="fw-bold"> {{ $user->name }} {{ $user->last_name }} - tareas </h4>
		</div>
		<div class="col-sm-4 col-md-6">
			<div class="dt-action-buttons text-end pt-md-0">
				<div class="dt-buttons"> </div>
			</div>
		</div>
	</div>

	<div class="wrap-toast"></div>

	@if(Session::has('task.success'))
	<div class="alert alert-success alert-dismissible" role="alert">
		{{ Session::get('task.success') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
		</button>
	</div>
	@endif

	<div class="row sm-vl-base mb-4">
		<div>
			<ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
				<li class="nav-item" role="presentation">
                    <a href="{{ route('task.user.list', $user->id) }}" class="nav-link" aria-selected="true">
                        <i class="bx bx-list-ol"></i> Lista
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('task.user.kanban', $user->id) }}" class="nav-link" ria-selected="false" tabindex="-1">
                        <i class="bx bx-card"></i> Tarjetas
                    </a>
                </li>
				<li class="nav-item" role="presentation">
					<a href="{{ route('task.user.calendar', $user->id) }}" class="nav-link active" ria-selected="true">
                        <i class="bx bx-calendar"></i> Calendario
                    </a>
				</li>
			</ul>
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
<link href="{{ asset('/assets/admin/js/quilljs/quill.css') }}" rel="stylesheet">
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<script src="{{ asset('/assets/admin/js/quilljs/quill.js') }}"></script>
<script src="{{asset('/assets/admin/js/mieditor.js')}}"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>let urlCreate = "{{ route('task.create') }}";</script>
<script src="{{asset('/assets/admin/js/task.js')}}"></script>

<script src="{{ asset('/assets/admin/js/fullcalendar/fullcalendar.min.js') }}"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            editable: false,
            events: [],
            eventContent: function( info ) {
                return {html: info.event.title};
            },
            eventClick: function(info) {
                window.location.href = 'https://' + location.hostname + '/task/view/' + info.event.id;
            },
            datesSet: function(info) {
                document.querySelector('.loading').classList.remove('hide');
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
        let url = "{{ route('task.user.calendar.list', $user->id) }}";
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
            }

            calendar.addEvent({
                id: task.id,
                title: `<div class="calendar-item ${ task.status.toLowerCase() }"> 
                    <div> 
                        ${image}
                        ${status}
                    </div> 
                    <div> ${task.title} </div>
                </div>`,
                start: task.date_delivery,
                color: color,
                textColor: '#313131',
                borderColor: '#eaeaea',
            })
        }
    }
</script>
@endsection
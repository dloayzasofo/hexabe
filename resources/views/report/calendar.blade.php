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

    <div class="d-flex justify-content-between">
        <div>
            Filtros
        </div>
        <div class="d-flex gap-2">
            <div>   
                <div class="form-group">
                    <select id="selectUser" class="form-select">
                        <option value="all"> Todos </option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if( $user->id == Auth::user()->id ) selected @endif> {{ $user->name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>   
                <div class="form-group">
                    <select id="selectBrand" class="form-select">
                        <option value="all"> Seleccione una marca </option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"> {{ $brand->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <button class="btnFilter btn btn-primary"> Filtrar </button>
            </div>
        </div>
    </div>

    <hr>
    <div>
        <div id="calendar"></div>
    </div>

    
    <div class="mt-4">
        <h4> Marcas </h4>
        <div class="graphPie">
            <canvas id="chartPie" ></canvas>
        </div>
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
    let dateIni = null;
    let dateEnd = null;
    let loadingElem = document.querySelector('.loading');

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            editable: false, // Evita modificar el evento
            events: [],
            weekends: false,
            eventOrder: 'priority',
            eventContent: function( info ) {
                return {html: info.event.title};
            },
            eventClick: function(info) {
                if( info.event.id && info.event.id != 0 ){
                    window.location.href = 'https://' + location.hostname + '/task/view/' + info.event.id;
                }
            },
            datesSet: function(info) {
                //document.querySelector('.loading').classList.remove('hide');
                handleChangeMonth(info.startStr, info.endStr);
            }
        });
        calendar.render();

        let btnFilter = document.querySelector('.btnFilter');
        btnFilter.addEventListener('click', () =>{
             serverGetStats();
             serverPie();
        });
        let selectUser = document.querySelector('#selectUser');
        let selectBrand = document.querySelector('#selectBrand');

        selectUser.addEventListener('change', () => {
            selectBrand.selectedIndex = 0;
        });
        selectBrand.addEventListener('change', () => {
            selectUser.selectedIndex = 0;
        });
    });

    function handleChangeMonth(date_ini, date_end){
        dateIni = date_ini;
        dateEnd = date_end;
        serverGetStats();
        serverPie();
    }

    function serverGetStats(){
        loadingElem.classList.remove('hide');
        let user = document.querySelector('#selectUser');
        let brand = document.querySelector('#selectBrand');

        if( user.value != 'all' ){
            brand.selectedIndex = 0;
        }
        if( brand.value != 'all' ){
            user.selectedIndex = 0;
        }

        let url = "{{ route('report.calendar.list') }}";
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                date_ini: dateIni,
                date_end: dateEnd,
                user: user.value,
                brand: brand.value
            })
        }).then(response => response.json())
        .then(data => {
            loadingElem.classList.add('hide');

            if( data.success){
                handleRenderEvents(data);
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
        
        for(let i=0; i < data.dates.length; i++){
            let date = data.dates[i];
            if( date.have_task ){
                calendar.addEvent({
                    id: 0,
                    title: '<div class="calendar-item-resume">' + date.hour_literal + '</div>',
                    start: date.date,
                    color: "transparent",
                    priority: 1
                });
            }
        }
        
        for(let i=0; i < data.data.length; i++){
            let task = data.data[i];

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
                priority: 2
            });
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
<script>
    let chartPie = null;
    window.addEventListener('load', () => {
        Chart.defaults.plugins.tooltip.callbacks.label = function (context) {
            const total = context.dataset.data.reduce((x, y) => x + y, 0);
            const currentValue = context.parsed;
            const percentage = ((currentValue / total) * 100).toFixed(1);
            return `${currentValue} (${percentage}%)`;
        };
        Chart.defaults.plugins.tooltip.callbacks.title = function (context) {
            return context.label;
        };
        serverPie();
    });

    function serverPie(){
        let url = "{{ route('report.calendar.pie') }}";
        let user = document.querySelector('#selectUser');
        let brand = document.querySelector('#selectBrand');
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                date_ini: dateIni,
                date_end: dateEnd,
                user: user.value,
                brand: brand.value
            })
        }).then(response => response.json())
        .then(data => {
            if( data.success){
                handleRenderPie(data.data);
            }
        });
    }

    function handleRenderPie(data){
        let labels = [];
        let values = [];
        for(let i=0; i < data.length; i++){
            let item = data[i];
            labels.push(item.name);
            values.push(item.count);
        };

        if( chartPie != null ){
            chartPie.data.labels = labels;
            chartPie.data.datasets[0].data = values;
            chartPie.update();
            return;
        }

        chartPie = new Chart("chartPie", {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    //backgroundColor: barColors,
                    data: values
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        /*
                        labels: {
                            generateLabels: function(chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        var meta = chart.getDatasetMeta(0);
                                        var ds = data.datasets[0];
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        //var getValueAtIndexOrDefault = theHelp.getValueAtIndexOrDefault;
                                        //var arcOpts = chart.options.elements.arc;
                                        var fill = data.datasets[0].backgroundColor[i];
                                        var stroke = "#313131";
                                        var bw = "#000000";
                                        //var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                                        //var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                                        //var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);
                                        console.log(label);
                                        return {
                                            // And finally : 
                                            text: label + ' (' + data.datasets[0].data[i] + ')',
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                        */
                    },
                    title: {
                        display: false,
                        //text: 'Chart.js Pie Chart'
                    }
                }
            }
        });
    }
    
</script>
@endsection
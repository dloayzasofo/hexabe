@extends('layout')

@section('main')
<section class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-start filter-date">
                        <button class="filter-date-item" data-value="today" data-value="today">Hoy</button>
                        <button class="filter-date-item" data-value="week" data-value="week">Semana</button>
                        <button class="filter-date-item" data-value="month" data-value="month">Mes</button>
                        <button class="filter-date-item active" data-value="year" data-value="year">Año</button>
                        <button class="filter-date-item" data-value="custom" data-value="">Pesonalizado</button>
                        <div class="date-custom-range">
                            <div id="dateRange"></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end filter-select">
                        <div class="filter-select-wrap">
                            <button class="filter-select-item" data-value="all">
                                <span>Miembro: </span>
                                <span id="selectMember"> Todos </span>
                                <input type="hidden" id="selectMember" value="all">
                            </button>
                            <div class="filter-select-options">
                                <ul>
                                    <li data-value="all" class="filter-item" data-id="selectMember"> Todos </li>
                                    @foreach($users as $item)
                                    <li data-value="{{ $item->id }}" class="filter-item" data-id="selectMember"> {{ $item->name }} {{ $item->last_name}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-select-wrap">
                            <button class="filter-select-item" data-value="all">
                                <span>Equipo: </span>
                                <span id="selectTeam">Todos</span>
                            </button>
                            <div class="filter-select-options">
                                <ul>
                                    <li data-value="all" class="filter-item" data-id="selectTeam"> Todos </li>
                                    @foreach($teams as $item)
                                    <li data-value="{{ $item->id }}" class="filter-item" data-id="selectTeam"> {{ $item->name }} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-select-wrap">
                            <button class="filter-select-item" data-value="all">
                                <span>Marca: </span>
                                <span id="selectBrand">Todos</span>
                            </button>
                            <div class="filter-select-options">
                                <ul>
                                    <li data-value="all" class="filter-item" data-id="selectBrand"> Todos </li>
                                    @foreach($brands as $item)
                                    <li data-value="{{ $item->id }}" class="filter-item" data-id="selectBrand"> {{ $item->name }} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-select-wrap">
                            <button class="filter-select-item" data-value="all">
                                <span>Estado: </span>
                                <span id="selectStatus">Todos</span>
                            </button>
                            <div class="filter-select-options">
                                <ul>
                                    <li data-value="all" class="filter-item" data-id="selectStatus"> Todos </li>
                                    @foreach($status as $key => $item)
                                    <li data-value="{{ $key }}" class="filter-item" data-id="selectStatus"> {{ $item }} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div>
                            <button class="filter-select-item-clean">
                                Limpiar filtros
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <div class="d-flex mt-4 filter-value-status justify-content-between">
            <div class="filter-value-status-item task-totals">
                <span>TAREAS TOTALES</span>
                <b id="taskTotal"></b>
            </div>
            <div class="filter-value-status-item tostart">
                <span>SIN EMPEZAR</span>
                <b id="taskTostart"></b>
            </div>
            <div class="filter-value-status-item process">
                <span>EN PROCESO</span>
                <b id="taskProcess"></b>
            </div>
            <div class="filter-value-status-item delay">
                <span>RETRASADO</span>
                <b id="taskDelay"></b>
            </div>
            <div class="filter-value-status-item pause">
                <span>PAUSADO</span>
                <b id="taskPaused"></b>
            </div>
            <div class="filter-value-status-item finalized">
                <span>FINALIZADO</span>
                <b id="taskFinalized"></b>
            </div>
            <div class="filter-value-status-item average">
                <span>PROM. DE CIERRE</span>
                <b id="taskHours"> </b>
            </div>
        </div>
    </div>
</section>

<section class="row mt-4" style="padding-left:0px;padding-right:0px;">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div style="width: 800px;"><canvas id="myChart"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold">Lectura rápida</h5>
                <table class="table-quick-read">
                    <tr>
                        <td>
                            <span class="badge badge-dot text-bg-primary me-1" style="background-color:#3C8AEC !important;">&nbsp;</span> Sin empezar
                        </td>
                        <td align="right" style="text-align: right;">
                            <b>
                                <span id="resumeTostartPercent"></span>% (<span id="resumeTostart"></span>)
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="badge badge-dot text-bg-primary me-1" style="background-color:#6338E0 !important;">&nbsp;</span> En proceso
                        </td>
                        <td align="right" style="text-align: right;">
                            <b>
                                <span id="resumeProcessPercent"></span>% (<span id="resumeProcess"></span>)
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="badge badge-dot text-bg-primary me-1" style="background-color:#C00939 !important;">&nbsp;</span> Retrasado
                        </td>
                        <td align="right" style="text-align: right;">
                            <b>
                                <span id="resumeDelayPercent"></span>% (<span id="resumeDelay"></span>)
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="badge badge-dot text-bg-primary me-1" style="background-color:#F75620 !important;">&nbsp;</span> Pausado
                        </td>
                        <td align="right" style="text-align: right;">
                            <b>
                                <span id="resumePausedPercent"></span>% (<span id="resumePaused"></span>)
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="badge badge-dot text-bg-primary me-1" style="background-color:#16A34A !important;">&nbsp;</span> Finalizado
                        </td>
                        <td align="right" style="text-align: right;">
                            <b>
                                <span id="resumeFinalizedPercent"></span>% (<span id="resumeFinalized"></span>)
                            </b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="fw-bold pb-3">Horas promedio de cierre</h5>
                <div class="d-flex align-items-center justify-content-center mt-4 mb-4">
                    <div class="avatar flex-shrink-0 me-2">
                        <span class="avatar-initial rounded bg-label-info"><i class="icon-base bx bx-stopwatch icon-lg"></i></span>
                    </div>
                    <div>
                        <h2 class="fw-bold" style="margin-bottom:0px;"><b id="hoursAverage"></b> HRS</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="row mt-4">
    <div id="task-list" class="col-md-12 pt-4">
        <h5 class="fw-bold">Detalle de tareas del periodo</h5>

        <div class="task-list-item task-list-header d-flex no-wrap">
            <div>
                Tarea
            </div>
            <div>
                Marca
            </div>
            <div>
                Responsable
            </div>
            <div>
                Estado
            </div>
            <div>
                Prioridad
            </div>
            <div>
                Progreso
            </div>
            <div>
                Fecha de entrega
            </div>
            <div>
                Cierre
            </div>
        </div>

        <div id="table-tasks"></div>
        <div id="table-tasks-pagination" class="d-flex justify-content-between">
            <div><small id="pagination-info"></small></div>
            <div>
                <nav id="pagination-nav" class="pagination-wrapper d-flex align-items-center"></nav>
            </div>
        </div>
    </div>
</section>

<section class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center report-nav">
            <div class="d-flex justify-content-start report-nav">
                <div class="nav-item tab-filter-footer" role="presentation" data-id="table-members">
                    <a href="{{ route('task.index') }}?status=TOSTART" class="active" aria-selected="true">
                    <span class="d-none d-sm-inline-flex align-items-center">
                        Por miembro
                    </span>
                    </a>
                </div>
                <div class="nav-item tab-filter-footer" role="presentation" data-id="table-teams">
                    <a href="{{ route('task.index') }}?status=PROCESS" class="" aria-selected="true">
                    <span class="d-none d-sm-inline-flex align-items-center">
                        Por equipo
                    </span>
                    </a>
                </div>
                <div class="nav-item tab-filter-footer" role="presentation" data-id="table-brands">
                    <a href="{{ route('task.index') }}?status=DELAY" class="" aria-selected="true">
                    <span class="d-none d-sm-inline-flex align-items-center">
                        Por marca
                    </span>
                    </a>
                </div>
            </div>
            <div>
                <div type="button" class="see-all-footer"> Ver todos </div>
            </div>
        </div>
    </div>

    <div id="table-members" class="col-md-12 mt-4 table-resumen-footer active">
        <div class="task-list-item members task-list-header d-flex no-wrap">
            <div> Miembro </div>
            <div> Área </div>
            <div> Total </div>
            <div> Completadas </div>
            <div> Atrasadas </div>
            <div> En proceso </div>
            <div> Promedio </div>
        </div>
        <div id="table-members-result"> </div>
    </div>

    <div id="table-teams" class="col-md-12 mt-4 table-resumen-footer">
        <div class="task-list-item teams task-list-header d-flex no-wrap">
            <div> Equipo </div>
            <div> Miembros </div>
            <div> Total </div>
            <div> Sin empezar </div>
            <div> En proceso </div>
            <div> Pausadas </div>
            <div> Atrasadas </div>
            <div> Completadas </div>
            <div> Promedio </div>
        </div>

        <div id="table-teams-result"></div>
    </div>

    <div id="table-brands" class="col-md-12 mt-4 table-resumen-footer">
        <div class="task-list-item brands task-list-header d-flex no-wrap">
            <div> Marca </div>
            <div> Miembros </div>
            <div> Total </div>
            <div> Sin empezar </div>
            <div> En proceso </div>
            <div> Pausadas </div>
            <div> Atrasadas </div>
            <div> Completadas </div>
            <div> Promedio </div>
        </div>

        <div id="table-brands-result"> </div>
    </div>
</section>
@endsection

@section('script')
<link rel="stylesheet" href="{{ asset('assets/admin/css/report.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
<script src="{{ asset('assets/admin/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>

{{-- Datepicker --}}
<script>
    const element = document.getElementById("dateRange");
    const picker = new coreui.DateRangePicker(element, {
        locale: 'es-ES',
        //startDate: new Date(2026, 6, 1),
        //endDate: new Date(2026, 6, 15),
        inputStartDatePlaceholder: 'Fecha inicial',
        inputEndDatePlaceholder: 'Fecha final',
        inputDateFormat: date => date.toLocaleDateString('es-BO')
    });
    const startInput = document.querySelector('input[name="date-range-picker-start-date-dateRange"]');
    const endInput = document.querySelector('input[name="date-range-picker-end-date-dateRange"]');

    startInput.placeholder = 'Fecha inicial';
    endInput.placeholder = 'Fecha final';
    startInput.readOnly = true;
    endInput.readOnly = true;

    element.addEventListener(
        'startDateChange.coreui.date-range-picker',
        (event) => {
            console.log("START", event.date);
        }
    );

    element.addEventListener(
        'endDateChange.coreui.date-range-picker',
        (event) => {
            if( startInput.value != '' && endInput.value != '' ){
                let dateIni = startInput.value;
                dateIniArray = dateIni.split('/');
                let dateEnd = endInput.value;
                dateEndArray = dateEnd.split('/');

                dateIni = dateIniArray[2] + '-' + dateIniArray[1] + '-' + dateIniArray[0];
                dateEnd = dateEndArray[2] + '-' + dateEndArray[1] + '-' + dateEndArray[0];
                filter['date'] = 'custom';
                filter['start'] = dateIni;
                filter['end'] = dateEnd;
                document.querySelector('.date-custom-range').classList.remove('active');

                searchAjax();
            }
        }
    );

    element.addEventListener(
        'hide.coreui.date-range-picker', 
        () => {
            setTimeout(() => picker.show(), 0);
        }
    );
    picker.show();

    document.addEventListener('click', function (event) {
        const link = event.target.closest('a[href], a[data-href]');
        if (!link) {
            return;
        }

        const targetHref = link.getAttribute('href') || link.getAttribute('data-href');
        if (!targetHref || targetHref === '#' || targetHref.startsWith('javascript:')) {
            return;
        }

        event.preventDefault();
        event.stopImmediatePropagation();
        window.location.assign(targetHref);
    }, true);
</script>

{{-- Grafica --}}
<script>
    const ctx = document.getElementById('myChart').getContext('2d');

    let dataTostart = [];
    let dataProcess = [];
    let dataDelay = [];
    let dataPaused = [];
    let dataFinalized = [];
    let labels = [];
    let myChart = null;

    function prepareChart(data, type){
        dataTostart = [];
        dataProcess = [];
        dataDelay = [];
        dataPaused = [];
        dataFinalized = [];
        let month = 0;
        let day = 0;
        let customLabels = [];

        for(let i=0; i < data.length; i++){
            let item = data[i];
            month = item['month'];
            day = item['day'];
            dataTostart.push(item['tostart']);
            dataProcess.push(item['process']);
            dataDelay.push(item['delay']);
            dataPaused.push(item['paused']);
            dataFinalized.push(item['finalized']);
            if( item.date ){
                customLabels.push(item.date);
            }
        }

        if( type == 'year' ){
            labels = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
        }
        if( type == 'month' ){
            let months = ['ENERO', 'FEBREO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
            labels = [months[month]];
            
        }
        if( type == 'week' ){
            labels = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        }
        if( type == 'today' ){
            days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            labels = [days[day]];
        }
        if( type == 'custom' ){
            labels = customLabels;
        }

        renderChart(labels);
    }

    function renderChart(labels){
        let dataset = [
            {
                label: 'Sin empezar',
                data: dataTostart,
                backgroundColor: 'rgba(60, 138, 236, .8)'
            },
            {
                label: 'En proceso',
                data: dataProcess,
                backgroundColor: 'rgba(99, 56, 224, .8)'
            },
            {
                label: 'Retrasado',
                data: dataDelay,
                backgroundColor: 'rgba(192, 9, 57, .8)'
            },
            {
                label: 'Pausado',
                data: dataPaused,
                backgroundColor: 'rgba(247, 86, 32, .8)'
            },
            {
                label: 'Finalizado',
                data: dataFinalized,
                backgroundColor: 'rgba(22, 163, 74, .8)'
            }
        ];

        if( myChart == null ){
            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: dataset
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });
        }else{
            myChart.config.data.labels = labels;
            myChart.config.data.datasets = dataset;
            myChart.update();
        }
    }
</script>

{{-- Filtro Eventos --}}
<script>
    let filter = {
        'date': '',
        'dates': '',
        'member': '',
        'team': '',
        'brand': '',
        'status': '',
        'page': null
    }

    window.addEventListener('load', () => {
        searchAjax();
    });

    let filterDates = document.querySelectorAll('.filter-date-item');
    for(let i=0; i < filterDates.length; i++){
        filterDates[i].addEventListener('click', handleClickFilterDate);
    }

    let filterSelectItems = document.querySelectorAll('.filter-select-item');
    for(let i=0; i < filterSelectItems.length; i++){
        filterSelectItems[i].addEventListener('click', handleClickFilterSelect);
    }

    let filterItems  = document.querySelectorAll('.filter-item');
    for(let i=0; i < filterItems.length; i++){
        filterItems[i].addEventListener('click', handleClickFilterItem);
    }

    let cleanFiltersBtn = document.querySelector('.filter-select-item-clean');
    cleanFiltersBtn.addEventListener('click', handleClickCleanFilters);

    function handleClickFilterDate(){
        hideAllFilterSelectOptions();
        let value = this.getAttribute('data-value');
        filter['page'] = null;
        filter['date'] = value;

        let items = document.querySelectorAll('.filter-date-item');
        for(let i=0; i < items.length; i++){
            items[i].classList.remove('active');
        }
        this.classList.add('active');

        if( value == 'custom' ){
            document.querySelector('.date-custom-range').classList.add('active');
            return;
        }else{
            document.querySelector('.date-custom-range').classList.remove('active');
        }
        searchAjax();
    }

    function searchAjax(){
        let url = new URL("{{ route('report.stats') }}?page=" + filter['page']);
        url.searchParams.set('date', filter['date']);
        url.searchParams.set('member', filter['member']);
        url.searchParams.set('team', filter['team']);
        url.searchParams.set('brand', filter['brand']);
        url.searchParams.set('status', filter['status']);
        if( filter['start'] ){
            url.searchParams.set('start', filter['start']);
        }
        if( filter['end'] ){
            url.searchParams.set('end', filter['end']);
        }
        fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }
        ).then(response => response.json())
        .then(data => {
            renderStats(data.data);
        });
    }

    function renderStats(data){
        document.querySelector('#taskTotal').innerHTML = data.stats.total;
        document.querySelector('#taskTostart').innerHTML = data.stats.tostart;
        document.querySelector('#taskProcess').innerHTML = data.stats.process;
        document.querySelector('#taskDelay').innerHTML = data.stats.delay;
        document.querySelector('#taskPaused').innerHTML = data.stats.paused;
        document.querySelector('#taskFinalized').innerHTML = data.stats.finalized;

        let hoursLiteral = data.hours.days != 0 ? data.hours.days + 'd ' : '';
        hoursLiteral += data.hours.hours != 0 ? data.hours.hours + 'h ' : '';
        hoursLiteral += data.hours.minutes != 0 ? data.hours.minutes + 'm ' : '';

        document.querySelector('#taskHours').innerHTML = hoursLiteral;
        document.querySelector('#hoursAverage').innerHTML = data.hours.average;

        let percentTostart = data.stats.total != 0 ? data.stats.tostart * 100 / data.stats.total : 0;
        let percentProcess = data.stats.total != 0 ? data.stats.process * 100 / data.stats.total : 0;
        let percentDelay = data.stats.total != 0 ? data.stats.delay * 100 / data.stats.total : 0;
        let percentPaused = data.stats.total != 0 ? data.stats.paused * 100 / data.stats.total : 0;
        let percentFinalized = data.stats.total != 0 ? data.stats.finalized * 100 / data.stats.total : 0;

        document.querySelector('#resumeTostartPercent').innerHTML = (Math.round(percentTostart) == percentTostart) ? percentTostart : percentTostart.toFixed(2);
        document.querySelector('#resumeProcessPercent').innerHTML = (Math.round(percentProcess) == percentProcess) ? percentProcess : percentProcess.toFixed   (2);
        document.querySelector('#resumeDelayPercent').innerHTML = (Math.round(percentDelay) == percentDelay) ? percentDelay : percentDelay.toFixed (2);
        document.querySelector('#resumePausedPercent').innerHTML = (Math.round(percentPaused) == percentPaused) ? percentPaused : percentPaused.toFixed(2);
        document.querySelector('#resumeFinalizedPercent').innerHTML = (Math.round(percentFinalized) == percentFinalized) ? percentFinalized : percentFinalized.toFixed (2);
        document.querySelector('#resumeTostart').innerHTML = data.stats.tostart.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.querySelector('#resumeProcess').innerHTML = data.stats.process.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.querySelector('#resumeDelay').innerHTML = data.stats.delay.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.querySelector('#resumePaused').innerHTML = data.stats.paused.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.querySelector('#resumeFinalized').innerHTML = data.stats.finalized.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        if( filter['page'] == null ){
            prepareChart(data.graph, data.inputs.date);
        }

        renderTableDetails(data.tasks);
    }

    function handleClickFilterSelect(){
        document.querySelector('.date-custom-range').classList.remove('active');
        let parent = this.parentNode;
        let option = parent.querySelector('.filter-select-options');
        let hasClass = option.classList.contains('active');
        hideAllFilterSelectOptions();
        if( hasClass == false ){
            option.classList.toggle('active');
        }
    }

    function hideAllFilterSelectOptions(){
        let filterSelectOptions = document.querySelectorAll('.filter-select-options');
        for (let i = 0; i < filterSelectOptions.length; i++) {
            filterSelectOptions[i].classList.remove('active');
        }
    }

    function handleClickFilterItem(){
        let elementId = this.getAttribute('data-id');
        let text = this.innerHTML;
        let value = this.getAttribute('data-value');
        let element = document.getElementById(elementId);

        document.querySelector('#selectMember').innerHTML = 'Todos';
        document.querySelector('#selectTeam').innerHTML = 'Todos';
        document.querySelector('#selectBrand').innerHTML = 'Todos';
        document.querySelector('#selectStatus').innerHTML = 'Todos';


        element.innerHTML = text;
        
        let filterSelects = document.querySelectorAll('.filter-select-item');
        for (let i = 0; i < filterSelects.length; i++) {
            filterSelects[i].classList.remove('active');
        }
        if( value != 'all' ){
            element.parentNode.classList.add('active');
        }
        hideAllFilterSelectOptions();
        filter['member'] = '';
        filter['team'] = '';
        filter['brand'] = '';
        filter['status'] = '';
        filter['page'] = null;

        switch (elementId) {
            case 'selectMember':
                filter['member'] = value;
                break;
            case 'selectTeam':
                filter['team'] = value;
                break;
            case 'selectBrand':
                filter['brand'] = value;
                break;
            case 'selectStatus':
                filter['status'] = value;
                break;
        }
        
        searchAjax();
    }

    function handleClickCleanFilters(){
        filter = {
            'date': '',
            'member': '',
            'team': '',
            'brand': '',
            'status': '',
            'page': null
        };

        let filterDates = document.querySelectorAll('.filter-date-item');
        for (let i = 0; i < filterDates.length; i++) {
            filterDates[i].classList.remove('active');
            if( filterDates[i].getAttribute('data-value') == 'year' ){
                filterDates[i].classList.add('active');
            }
        }

        let filterSelects = document.querySelectorAll('.filter-select-item');
        for (let i = 0; i < filterSelects.length; i++) {
            filterSelects[i].classList.remove('active');
        }

        document.querySelector('#selectTeam').innerHTML = 'Todos';
        document.querySelector('#selectMember').innerHTML = 'Todos';
        document.querySelector('#selectBrand').innerHTML = 'Todos';
        document.querySelector('#selectStatus').innerHTML = 'Todos';

        searchAjax();
    }
    
    function renderTableDetails(data){
        let html = '';
        let tasks = data.data;
        
        if( tasks.length == 0 ){
            html = `
                <div class="d-flex justify-content-center pt-4">
                    Sin datos
                </div>
            `;
            document.querySelector('#table-tasks').innerHTML = html;
            return;
        }


        for (let i = 0; i < tasks.length; i++) {
            let task = tasks[i];
            let imageUser = `<img class="rounded-circle" src="${ task.assign.image }" alt="${ task.assign.name }">`;
            let statusHtml = `<div class="ct-select ${ task.status }" data-value="${ task.status }" data-task="${ task.id }" data-type="status">
                <div class="ct-select-view readonly text-center">`;
            let priorityHtml = `<div class="ct-select ${ task.priority }" data-value="${ task.priority }" data-task="${ task.id }" data-type="priority">
                            <div class="ct-select-view readonly">`;

            if( task.assign.image == null ){
                imageUser = `<span class="avatar-initial rounded-circle bg-label-primary">${ task.assign.nameInitial }</span>`;
            }

            if( task.status == 'TOSTART' ){
                statusHtml += 'Sin empezar';
            }else if( task.status == 'PROCESS' ){
                statusHtml += 'En proceso';
            }else if( task.status == 'DELAY' ){
                statusHtml += 'Retraso';
            }else if( task.status == 'PAUSED' ){
                statusHtml += 'Pausado';
            }else if( task.status == 'FINALIZED' ){
                statusHtml += 'Finalizado';
            }
            statusHtml += `</div></div>`;
            
            if( task.priority == 'high' ){
                priorityHtml += "ALTA";
            }else if( task.priority == 'medium' ){
                priorityHtml += "MEDIA";
            }else if( task.priority == 'low' ){
                priorityHtml += "BAJA";
            }
            priorityHtml += `</div></div>`;

            let progressHtml = '<div> Sin Subtareas </div>';
            if( task.childs_count > 0 ){
                progressHtml = `<div class="d-flex justify-content-between mb-1">
                    <div>
                        Subtareas
                    </div>
                    <div class="text-primary fw-bold">
                        ${ task.childs_done }/${ task.childs_count }
                    </div>
                    
                </div>
                <div>
                    <div class="progress" style="height: 16px;">
                        <div class="progress-bar" role="progressbar" style="width:${ task.progress }%;" aria-valuenow="${ task.progress }" aria-valuemin="0" aria-valuemax="100">
                            ${ task.progress }%
                        </div>
                    </div>
                </div>`;
            }

            html += `
                <div id="task-${ task.id }" class="task-list-item d-flex no-wrap">
                    <div>
                        <div class="d-flex flex-column">
                            <a href="/task/view/${ task.id }" class="table-link">
                                ${ task.title }
                            </a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start align-items-center user-name">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-sm me-2">
                                <img src="${ task.brand.image }" alt="Avatar" class="rounded">
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="/brand/view/${ task.brand.id }" class="table-link">
                                ${ task.brand.name.toUpperCase() }
                            </a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center user-name">
                        <div class="avatar-wrapper">
                            <a href="/task/view/${task.id}" class="text-heading">
                                <div class="avatar avatar-sm">
                                    ${ imageUser }
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        ${ statusHtml }
                    </div>

                    <div class="d-flex justify-content-center">
                        ${ priorityHtml }
                    </div>

                    <div>
                        <div>
                            ${ progressHtml }
                        </div>
                    </div>

                    <div> ${ task.date_delivery }</div>

                    <div>
                        ${ task.hoursWorkedLiteral == "" ? "-" : task.hoursWorkedLiteral }
                    </div>
                </div>
            `;
        }

        document.querySelector('#table-tasks').innerHTML = html;
        renderPagination(data);
    }

    function renderPagination(data){
        let info = document.querySelector('#pagination-info');
        info.innerHTML = `Ver del ${ data.from } al ${ data.to }, <b>Total ${ data.total }</b>`;

        let nav = document.querySelector('#pagination-nav');
        html = '';

        if(data.current_page == 1){
            html += `<span class="disabled pagination-prev">
                    <i class="bx bx-chevron-left"></i>
                </span>`;
        }else{
            html += `<a data-page="1" class="pagination-item"> <i class="bx bx-chevrons-left"></i></a>
                <a data-page="${ data.current_page - 1 }" rel="prev" class="pagination-prev pagination-item">
                    <i class="bx bx-chevron-left"></i>
                </a>`;
        }

        html += `<ul class="pagination-pages d-flex align-items-center">`;
        for(let i=0; i < data.links.length; i++){
            if( i == 0 ){continue;}
            if( i == data.links.length - 1 ){continue;}

            let element = data.links[i];
            if( element.page && element.page == data.current_page){
                html += `<li class="active"><span>${ element.page }</span></li>`;
            }else if( element.page ){
                html += `<li><a data-page="${ element.page }" class="pagination-item">${ element.page }</a></li>`;
            }else if( element.label == '...' ){
                html += `<li class="dots"><span>...</span></li>`;
            }
        }
        html += `</ul>`;

        if(data.current_page != data.last_page){
            html += `<a data-page="${ data.current_page + 1 }" rel="next" class="pagination-next pagination-item">
                <i class="bx bx-chevron-right"></i>
            </a>
            <a data-page="${ data.last_page }" class="pagination-item"> <i class="bx bx-chevrons-right"></i></a>`;
        }else{
            html += `<span class="disabled pagination-next">
                <i class="bx bx-chevron-right"></i>
            </span>`;
        }

        nav.innerHTML = html;
        bindPaginationItem();
    }

    function bindPaginationItem(){
        let items = document.querySelectorAll('.pagination-item');
        for(let i=0; i < items.length; i++){
            items[i].addEventListener('click', handleClickPagination);
        }
    }

    function handleClickPagination(){
        let page = this.getAttribute('data-page');
        filter['page'] = page;
        searchAjax();
    }

    document.addEventListener('click', function(e){
        let closestDateItem = e.target.closest('.filter-date-item');
        let closestSelectItem = e.target.closest('.filter-select-item');

        if( closestDateItem == null ){
            closestDateItem = e.target.closest('.date-picker');
        }
        if( closestDateItem == null ){
            closestDateItem = e.target.closest('.calendar-cell');
        }


        if( closestDateItem == null ){
            document.querySelector('.date-custom-range').classList.remove('active');
        }
        if( closestSelectItem == null ){
            hideAllFilterSelectOptions();
        }
        return true;
    });
</script>

<script>
    let tabs = document.querySelectorAll('.tab-filter-footer');
    let btnSeeAll = document.querySelector('.see-all-footer');

    for(let i=0; i < tabs.length; i++){
        tabs[i].addEventListener('click', handleClickTab);
    }

    btnSeeAll.addEventListener('click', handleClickShowAll);

    function handleClickTab(){
        let id = this.getAttribute('data-id');
        let tab = document.querySelector(`#${id}`);

        let tabs = document.querySelectorAll('.tab-filter-footer');
        for(let i=0; i < tabs.length; i++){
            tabs[i].querySelector('a').classList.remove('active');
        }

        let tabsContent = document.querySelectorAll('.table-resumen-footer');
        for(let i=0; i < tabsContent.length; i++){
            tabsContent[i].classList.remove('active');
        }

        tab.classList.add('active');
        this.querySelector('a').classList.add('active');
    }

    function handleClickShowAll(e){
        let tableMembers = document.querySelector('#table-members');
        let tableTeams = document.querySelector('#table-teams');
        let tableBrands = document.querySelector('#table-brands');

        if( this.classList.contains('active') ){
            this.innerHTML = 'Ver todos';
            this.classList.remove('active');

            showLessTable(tableMembers);
            showLessTable(tableTeams);
            showLessTable(tableBrands);
        }else{
            this.innerHTML = 'Ver menos';
            this.classList.add('active');

            showMoreTable(tableMembers);
            showMoreTable(tableTeams);
            showMoreTable(tableBrands);
        }
    }

    function showMoreTable(element){
        let table = element.querySelectorAll('.task-list-item');
        for(let i=0; i < table.length; i++){
            table[i].classList.remove('hide');
        }
    }

    function showLessTable(element){
        let table = element.querySelectorAll('.task-list-item');
        for(let i=0; i < table.length; i++){
            if( i > 5 ){
                table[i].classList.add('hide');
            }
        }
    }
</script>

<script>
    // POR MIEMBROS
    let MEMBERS = [];
    window.addEventListener('load', () => {
        loadInfoPerMember()
    });

    function loadInfoPerMember(){
        if( MEMBERS.length > 0 ) {
            renderResultMemeber(MEMBERS);
            return;
        }

        let url = "{{ route('report.members') }}";
        fetch(url,
            {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }
        )
        .then(response => response.json())
        .then(data => {
            MEMBERS = data.data;
            renderResultMemeber(MEMBERS);
        });
    }

    function renderResultMemeber(data){
        let html = '';
        for(let i=0; i < data.length; i++){
            let item = data[i];

            let positionHtml = (item.position) ? item.position : 'sin asignar';


            let hours = item.hours;
            let hoursWorked = '';
            if( hours.days == 0 && hours.hours == 0 && hours.minutes == 0 ){
                hoursWorked = '-';
            }
            if( hours.days != 0 ){
                hoursWorked += hours.days + 'd ';
            }
            if( hours.hours != 0 ){
                hoursWorked += hours.hours + 'h ';
            }
            if( hours.minutes != 0 ){
                hoursWorked += hours.minutes + 'm ';
            }

            let image = item.image;
            let imageHtml = '';
            if( image ){
                imageHtml = `<img class="rounded-circle" src="${ item.image }" alt="${ item.name }">` ;
            }else{
                imageHtml = `<span class="avatar-initial rounded-circle bg-label-primary">${ item.nameInitial }</span>`;
            }

            html += `
                <div id="user-${item.id}" class="task-list-item members d-flex no-wrap ${ i >= 4 ? 'hide' : '' }">
                    <div class="d-flex justify-content-start align-items-center user-name">
                        <div class="avatar-wrapper">
                            <a href="./task/staff/list/${item.id}" class="text-heading">
                                <div class="avatar avatar-sm me-2">
                                    ${ imageHtml }
                                </div>
                            </a>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="./task/staff/list/${item.id}" class="text-heading">
                                <span class="fw-medium">${item.name} ${item.last_name}</span>
                            </a>
                            <small>${positionHtml}</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="ct-select ${ positionHtml == 'sin asignar' ? 'DELAY' : 'TOSTART' }">
                            <div class="ct-select-view readonly text-center">
                                ${positionHtml}
                            </div>
                        </div>
                    </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.total} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.finalized} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.delay} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.process} </div>
                    <div class="fw-bold text-center text-negro"> ${hoursWorked} </div>
                </div>
                `;
        }

        if( data.length == 0 ){
            html = `
                <div class="d-flex justify-content-center pt-4">
                    Sin datos
                </div>
            `;
        }
        document.getElementById('table-members-result').innerHTML = html;
    }
</script>

<script>
    // POR EQUIPO
    let TEAMS = [];
    window.addEventListener('load', () => {
        loadInfoPerTeams()
    });

    function loadInfoPerTeams(){
        if( TEAMS.length > 0 ) {
            renderResultTeams(TEAMS);
            return;
        }

        let url = "{{ route('report.teams') }}";
        fetch(url,
            {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }
        )
        .then(response => response.json())
        .then(data => {
            TEAMS = data.data;
            renderResultTeams(TEAMS);
        });
    }

    function renderResultTeams(data){
        let html = '';
        for(let i=0; i < data.length; i++){
            let item = data[i];

            let hours = item.hours;
            let hoursWorked = '';
            if( hours.days == 0 && hours.hours == 0 && hours.minutes == 0 ){
                hoursWorked = '-';
            }
            if( hours.days != 0 ){
                hoursWorked += hours.days + 'd ';
            }
            if( hours.hours != 0 ){
                hoursWorked += hours.hours + 'h ';
            }
            if( hours.minutes != 0 ){
                hoursWorked += hours.minutes + 'm ';
            }

            let usersHtml = '<ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">';
            for(let j=0; j < item.users.length; j++){
                let user = item.users[j];

                let imageHtml = '';
                if( user.image ){
                    imageHtml = `<img class="rounded-circle" src="${ user.image }" alt="${ user.name }">` ;
                }else{
                    imageHtml = `<span class="avatar-initial rounded-circle bg-label-primary">${ user.nameInitial }</span>`;
                }

                usersHtml += `
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="${user.name}" data-bs-original-title="${user.name}">
                        ${imageHtml}
                    </li>
                `;

                if( (j + 1) >= 2 ) break;
            }

            if( item.users.length > 2 ){
                usersHtml += `
                    <li class="avatar">
                        <span class="avatar-initial rounded-circle pull-up text-heading" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="${ item.users.length - 2 } más">+${ item.users.length - 2 }</span>
                    </li>
                `;
            }
            usersHtml += '</ul>';

            html += `
                <div id="user-${item.id}" class="task-list-item teams d-flex no-wrap ${ i > 4 ? 'hide' : '' }">
                    <div class="d-flex justify-content-start align-items-center user-name">
                        <div class="avatar-wrapper">
                            <a href="/team/view/${item.id}" class="text-heading">
                                <div class="avatar avatar-sm me-2">
                                    <img class="rounded-circle" src="${ item.image }" alt="${ item.name }">
                                </div>
                            </a>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="/team/view/${item.id}" class="text-heading">
                                <span class="fw-medium">${item.name} </span>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        ${usersHtml}
                    </div>

                    <div class="fw-bold text-center text-negro"> ${item.stats.total} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.tostart} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.process} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.paused} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.delay} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.finalized} </div>
                    <div class="fw-bold text-center text-negro"> ${hoursWorked} </div>
                </div>
                `;
        }

        if( data.length == 0 ){
            html = `
                <div class="d-flex justify-content-center pt-4">
                    Sin datos
                </div>
            `;
        }
        document.getElementById('table-teams-result').innerHTML = html;
    }
</script>

<script>
    // POR MARCA
    let BRANDS = [];
    window.addEventListener('load', () => {
        loadInfoPerBrands()
    });

    function loadInfoPerBrands(){
        if( BRANDS.length > 0 ) {
            renderResultBrands(BRANDS);
            return;
        }

        let url = "{{ route('report.brands') }}";
        fetch(url,
            {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }
        )
        .then(response => response.json())
        .then(data => {
            BRANDS = data.data;
            renderResultBrands(BRANDS);
        });
    }

    function renderResultBrands(data){
        let html = '';
        for(let i=0; i < data.length; i++){
            let item = data[i];

            let hours = item.hours;
            let hoursWorked = '';
            if( hours.days == 0 && hours.hours == 0 && hours.minutes == 0 ){
                hoursWorked = '-';
            }
            if( hours.days != 0 ){
                hoursWorked += hours.days + 'd ';
            }
            if( hours.hours != 0 ){
                hoursWorked += hours.hours + 'h ';
            }
            if( hours.minutes != 0 ){
                hoursWorked += hours.minutes + 'm ';
            }

            let usersHtml = '<ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">';
            for(let j=0; j < item.users.length; j++){
                let user = item.users[j];

                let imageHtml = '';
                if( user.image ){
                    imageHtml = `<img class="rounded-circle" src="${ user.image }" alt="${ user.name }">` ;
                }else{
                    imageHtml = `<span class="avatar-initial rounded-circle bg-label-primary">${ user.nameInitial }</span>`;
                }

                usersHtml += `
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="${user.name}" data-bs-original-title="${user.name}">
                        ${imageHtml}
                    </li>
                `;

                if( (j + 1) >= 2 ) break;
            }

            if( item.users.length > 2 ){
                usersHtml += `
                    <li class="avatar">
                        <span class="avatar-initial rounded-circle pull-up text-heading" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="${ item.users.length - 2 } más">+${ item.users.length - 2 }</span>
                    </li>
                `;
            }
            usersHtml += '</ul>';

            html += `
                <div id="user-${item.id}" class="task-list-item teams d-flex no-wrap ${ i > 4 ? 'hide' : '' }">
                    <div class="d-flex justify-content-start align-items-center user-name">
                        <div class="avatar-wrapper">
                            <a href="/team/view/${item.id}" class="text-heading">
                                <div class="avatar avatar-sm me-2">
                                    <img class="rounded-circle" src="${ item.image }" alt="${ item.name }">
                                </div>
                            </a>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="/team/view/${item.id}" class="text-heading">
                                <span class="fw-medium">${item.name} </span>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        ${usersHtml}
                    </div>

                    <div class="fw-bold text-center text-negro"> ${item.stats.total} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.tostart} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.process} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.paused} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.delay} </div>
                    <div class="fw-bold text-center text-negro"> ${item.stats.finalized} </div>
                    <div class="fw-bold text-center text-negro"> ${hoursWorked} </div>
                </div>
                `;
        }

        if( data.length == 0 ){
            html = `
                <div class="d-flex justify-content-center pt-4">
                    Sin datos
                </div>
            `;
        }
        document.getElementById('table-brands-result').innerHTML = html;
    }
</script>
@endsection
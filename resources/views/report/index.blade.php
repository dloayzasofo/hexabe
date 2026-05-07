@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <div class="d-flex align-items-center w-100">
                <div>
                    <h4 class="fw-bold" style="margin-bottom:4px;"> Rendimiento del equipo </h4>
                    <small>Monitorea productividad, tiempos de entrega y eficiencia en tiempo real.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Total tareas completadas</span>
                <h4 class="card-title mb-0 fw-bold">{{ $taskComplete }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Tiempo promedio entrega</span>
                <h4 class="card-title mb-0 fw-bold">{{ $avergeDate }} días</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Eficiencia global</span>
                <h4 class="card-title mb-0 fw-bold">{{ $calcEfficiencyTeam }} %</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold">Métricas por miembro del equipo</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Miembro</th>
                                    <th>Tareas</th>
                                    <th>Eficiencia</th>
                                    <th>T. Entrega</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($team as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-4">
                                                    @if( $item['image'])
                                                        <img src="{{ $item['image'] }}" alt="Avatar" class="rounded-circle">
                                                    @else
                                                        <small class="avatar-initial rounded-circle bg-label-danger">{{ $item['nameInitial'] }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="{{ route('task.user.list', ['user'=> $item['id']]) }}" class="text-heading text-truncate">
                                                    <span class="fw-medium">{{ $item['name'] }} {{ $item['last_name'] }}</span>
                                                </a>
                                                <small>{{ $item['position'] }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="fw-bold">{{ $item['totalTask'] }}</small>
                                    </td>
                                    <td>
                                        <small class="fw-bold">{{ $item['efficiency'] }}%</small>
                                        <div>
                                            <div class="progress w-100" style="height: 8px;">
                                                <div class="progress-bar" style="width: {{ $item['efficiency'] }}%; background:@if($item['efficiency'] >= 85) #22C55E; @elseif ($item['efficiency'] >= 50) #EAB308; @else #EF4444; @endif" aria-valuenow="{{ $item['efficiency'] }}%" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td align="left">
                                        @if( $item['totalTask'] == 0 )
                                            -
                                        @else
                                            {{ $item['timeDelivery'] }} d
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold">Carga de trabajo actual</h5>
                        <div>
                            <select name="work" id="work" class="form-select">
                                <option value="today">Hoy</option>
                                <option value="week">Ultima semana</option>
                                <option value="month">Ultimo mes</option>
                            </select>
                        </div>
                    </div>
                    <div id="wrap-work" class="row mt-4">
                        {{-- 
                        @foreach($team as $item)
                            <div class="col-md-6 mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <div>{{ $item['name'] }} {{ $item['last_name'] }}</div>
                                    <div>
                                        @if( $item['totalTask'] == 0 )
                                            -
                                        @else
                                            {{ $item['totalFinalized'] }} / {{ $item['totalTask'] }}
                                        @endif
                                    </div>
                                </div>
                                <div class="progress w-100" style="height: 8px;">
                                    @if( $item['totalTask'] == 0 )
                                        -
                                    @else
                                        @php $progress = $item['totalFinalized'] * 100 / $item['totalTask'] @endphp
                                        <div class="progress-bar" style="width: {{ $progress }}%; background:@if($progress >= 85) #22C55E; @elseif ($progress >= 50) #EAB308; @else #EF4444; @endif" aria-valuenow="{{ $progress }}%" aria-valuemin="0" aria-valuemax="100"></div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        --}}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    window.addEventListener('load', () => {
        let time = 'today';
        serverGetReportTeam(time);

        let work = document.querySelector('#work');
        work.addEventListener('change', (e) => {
            time = e.target.value;
            serverGetReportTeam(time);
        });
    });

    function serverGetReportTeam(time){
        let url = "{{ route('report.list') }}?time=" + time;
        fetch(url,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status == 'success') {
                handleRenderWork(data.data)
            }
        });
    }

    function handleRenderWork(data){
        let html = '';
        for(let i=0; i < data.length; i++){
            let item = data[i];

            let totalHtml = '-';
            if( item.totalTask > 0 ){
                totalHtml = item.totalFinalized + ' / ' + item.totalTask;
            }

            let progressHtml = '';
            if( item.totalTask > 0 ){
                let progress = item.totalFinalized * 100 / item.totalTask;
                let color = '#EF4444';
                if( progress >= 50 ){
                    color = '#EAB308';
                }
                if( progress >= 85 ){
                    color = '#22C55E';
                }
                progressHtml = `<div class="progress-bar" style="width: ${ progress }%; background:${ color }" aria-valuenow="${ progress }%" aria-valuemin="0" aria-valuemax="100"></div>`;
            }

            html += `
                <div class="col-md-6 mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <div>${ item.name } ${ item.last_name }</div>
                        <div> ${ totalHtml }</div>
                    </div>
                    <div class="progress w-100" style="height: 8px;">
                        ${ progressHtml }
                    </div>
                </div>
            `;
        }

        $('#wrap-work').html(html);
    }

</script>
@endsection
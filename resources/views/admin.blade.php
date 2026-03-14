@extends('admin.layout')

@section('main')
	<div class="row">

		<div class="col-sm-6 col-md-3 col-lg-3 mb-4">
			<div class="card">
			  	<div class="card-body">
					<div class="card-title d-flex align-items-start justify-content-between mb-4">
						<div class="avatar flex-shrink-0">
							<span class="chart-icon primary">
								<i class="tf-icons bx bx-analyse"></i>
							</span>
						</div>
						<div class="dropdown">
							<button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-dots-vertical-rounded"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
								<a class="dropdown-item" href="{{ route('admin.blog.article.index') }}">Ver Novedades</a>
							</div>
						</div>
					</div>
					<span class="fw-semibold d-block mb-1">Novedades</span>
					<h4 class="card-title mb-2"> {{ $blog['actived'] }} activos </h4>
					<small class="text-danger fw-semibold"><i class="bx bx-minus"></i> {{ $blog['deactived'] }} desactivados </small>
			  	</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-3 col-lg-3 mb-4">
			<div class="card">
			  	<div class="card-body">
					<div class="card-title d-flex align-items-start justify-content-between mb-4">
						<div class="avatar flex-shrink-0">
							<span class="chart-icon primary">
								<i class="tf-icons bx bx-home-smile"></i>
							</span>
						</div>
						<div class="dropdown">
							<button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-dots-vertical-rounded"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
								<a class="dropdown-item" href="{{ route('admin.bursatil.article.index') }}">Ver Aula bursátil</a>
							</div>
						</div>
					</div>
					<span class="fw-semibold d-block mb-1">Aula bursátil</span>
					<h4 class="card-title mb-2"> {{ $bursatil['actived'] }} activas </h4>
					<small class="text-danger fw-semibold"><i class="bx bx-minus"></i> {{ $bursatil['deactived'] }} desactivadas </small>
			  	</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-3 col-lg-3 mb-4">
			<div class="card">
			  	<div class="card-body">
					<div class="card-title d-flex align-items-start justify-content-between mb-4">
						<div class="avatar flex-shrink-0">
							<span class="chart-icon primary">
								<i class="bx bx-task"></i>
							</span>
						</div>
						<div class="dropdown">
							<button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-dots-vertical-rounded"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
								<a class="dropdown-item" href="{{ route('admin.ask.index') }}">Ver Preguntas</a>
							</div>
						</div>
					</div>
					<span class="fw-semibold d-block mb-1">Preguntas</span>
					<h4 class="card-title mb-2"> {{ $asks['actived'] }} activas </h4>
					<small class="text-danger fw-semibold"><i class="bx bx-minus"></i> {{ $asks['deactived'] }} desactivadas </small>
			  	</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-3 col-lg-3 mb-4">
			<div class="card">
			  	<div class="card-body">
					<div class="card-title d-flex align-items-start justify-content-between mb-4">
						<div class="avatar flex-shrink-0">
							<span class="chart-icon primary">
								<i class="bx bx-copy"></i>
							</span>
						</div>
						<div class="dropdown">
							<button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-dots-vertical-rounded"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
								<a class="dropdown-item" href="{{ route('admin.popup.index') }}">Ver Popups</a>
							</div>
						</div>
					</div>
					<span class="fw-semibold d-block mb-3">Popup</span>
					<ul class="p-0 m-0">
						@if( isset($popup) )
						<li class="d-flex mb-1">
							<div class="avatar flex-shrink-0 me-3">
								<img src="{{ $popup->imageUrl }}" class="rounded">
							</div>
							<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
								<div class="me-2">
									<h6 class="mb-0">{{ $popup->name }}</h6>
									<small class="text-muted d-block mb-1">
										<a href="{{ $popup->url }}" target="_blank">{{ $popup->url }}</a>
									</small>
								</div>
							</div>
						</li>
						@else
						<li class="d-flex mb-1">
							<div class="avatar flex-shrink-0 me-3">
								<span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
							</div>
							<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
								<div class="me-2">
									<h6 class="mb-0">S/N</h6>

									<small class="text-muted d-block mb-1">
										<a>https://</a>
									</small>
								</div>
							</div>
						</li>
						@endif
					</ul>
			  	</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 mb-4">
			<div class="card">
			  	<div class="card-body">
					<div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
				  		<div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
							<div class="card-title d-flex align-items-center justify-content-between">
								<div class="avatar flex-shrink-0">
									<span class="chart-icon success"><i class='bx bx-file'></i></span>
								</div>
								<h5 class="fw-semibold d-block" style="margin-left: 10px;margin-bottom:0px;">Requisitos</h5>
							</div>
							<div class="mt-sm-auto">
								<small class="card-subtitle fw-semibold">
									Persona jurídica: @if( isset($requisitos['juridica']) ) {{ $requisitos['juridica'] }} @else S/N @endif <br>
									Persona natural: @if( isset($requisitos['natural']) ) {{ $requisitos['natural'] }} @else S/N @endif
								</small>
							</div>
				  		</div>
				  		<div class="text-right">
							<a href="{{ route('admin.service.requisitos.index') }}" class="btn btn-xs btn-info">Configurar</a>
						</div>
					</div>
			  	</div>
			</div>
		</div>

		<div class="col-md-4 mb-4">
			<div class="card">
			  	<div class="card-body">
					<div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
				  		<div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
							<div class="card-title d-flex align-items-center justify-content-between">
								<div class="avatar flex-shrink-0">
									<span class="chart-icon success"><i class='bx bx-envelope'></i></span>
								</div>
								<h5 class="fw-semibold d-block" style="margin-left: 10px;margin-bottom:0px;">Formularios</h5>
							</div>
							<div class="mt-sm-auto">
								@if( isset($contact['to']) )
					  				<small class="card-subtitle fw-semibold">
										Contacto: {{ $contact['to'] }} <br>
										Postulaciones: {{ $contact['job'] }}
									</small>
								@else
									<h6 class="mb-0">S/N</h6>
								@endif

							</div>
				  		</div>
				  		<div class="text-right">
							<a href="{{ route('admin.config.contact.index') }}" class="btn btn-xs btn-info">Configurar</a>
						</div>
					</div>
			  	</div>
			</div>
		</div>

		<div class="col-md-4 mb-4">
			<div class="card">
			  	<div class="card-body">
					<div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
				  		<div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
							<div class="card-title d-flex align-items-center justify-content-between">
								<div class="avatar flex-shrink-0">
									<span class="chart-icon success"><i class='bx bx-chart'></i></span>
								</div>
								<h5 class="fw-semibold d-block" style="margin-left: 10px;margin-bottom:0px;">Tarifario</h5>
							</div>
							<div class="mt-sm-auto">
					  			<small class="card-subtitle fw-semibold">
									@if( isset($tarifario) )
									<h6 class="mb-0">Activo: &nbsp; <span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span></h6>
									@else
									<h6 class="mb-0">Activo: &nbsp; <span class="badge badge-center bg-label-secondary"><i class="bx bx-minus"></i></span></h6>
									@endif
									Url: &nbsp; <a href="{{ isset($tarifario) ? $tarifario->pathUrl : '' }}" target="_blank"> {{ isset($tarifario) ? 'Ver archivo' : '-' }} </a>
								</small>
							</div>
				  		</div>
				  		<div class="text-right">
							<a href="" class="btn btn-xs btn-info">Configurar</a>
						</div>
					</div>
			  	</div>
			</div>
		</div>

		<div class="col-md-6 col-lg-6 mb-4">
			<div class="card h-100">
			  	<div class="card-header d-flex align-items-center justify-content-between">
					<div>
						<h5 class="card-title m-0 me-2">Formulario de contacto</h5>
						<p>Solicitud de contacto en la web <br>
							<small> 
								<a href="{{ env('STORAGE_URL') }}/contacto" target="_blank"> {{ env('STORAGE_URL') }}/contacto </a> 
							</small>
						</p>
					</div>
					<div>
						<a href="{{ route('admin.forms.contact.index') }}" class="btn btn-primary">ver todos</a>
					</div>
			  	</div>
			  	<div class="table-responsive">
					<table class="table table-borderless">
				  		<thead>
							<tr>
					  			<th>Nº</th>
					  			<th>Nombre</th>
					  			<th>Teléfono</th>
					  			<th>País</th>
					  			<th>Ciudad</th>
							</tr>
				  		</thead>
						<tbody>
							@forelse ($form as $key => $item)
								<tr>
									<td> {{ $key + 1 }} </td>
									<td> {{ $item->name }} </td>
									<td> {{ $item->phone }} </td>
									<td> {{ $item->country }} </td>
									<td> {{ $item->city }} </td>
								</tr>
							@empty
								<tr>
									<td colspan="5" align="center"> 
										<small> En esta sección se muestran los últimos datos registrados en la web </small> <br> 
										No hay datos para mostrar 
									</td>
								</tr>
							@endforelse
							
						</tbody>
					</table>
			  	</div>
			</div>
		</div>

		<div class="col-md-6 col-lg-6 mb-4">
			<div class="card h-100">
			  	<div class="card-header d-flex align-items-center justify-content-between">
					<div>
						<h5 class="card-title m-0 me-2">Postulaciones</h5>
						<p>Postulaciones realizadas en la web <br>
							<small> 
								<a href="{{ env('STORAGE_URL') }}/trabaja-con-nosotros" target="_blank"> {{ env('STORAGE_URL') }}/trabaja-con-nosotros </a> 
							</small>
						</p>
					</div>
					<div>
						<a href="{{ route('admin.forms.postulations.index') }}" class="btn btn-primary">ver todos</a>
					</div>
			  	</div>
			  	<div class="table-responsive">
					<table class="table table-borderless">
				  		<thead>
							<tr>
					  			<th>Nº</th>
					  			<th>Nombre</th>
					  			<th>Postulación</th>
					  			<th>Teléfono</th>
					  			<th>CV</th>
							</tr>
				  		</thead>
						<tbody>
							@forelse ($postulations as $key => $item)
								<tr>
									<td> {{ $key + 1 }} </td>
									<td> {{ $item->name }} </td>
									@if( isset($item->job) )
										<td> {{ $item->job->position }} </td>
									@else
										<td> - </td>
									@endif
									<td> {{ $item->city }} </td>
									<td> <a href="{{ $item->cvUrl }}" target="_blank" style="display:block;text-align:center;"> 
										<i class="bx bxs-file-pdf"></i> </a> 
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="5" align="center"> 
										<small> En esta sección se muestran las últimas postulaciones registrados en la web </small> <br> 
										No hay datos para mostrar 
									</td>
								</tr>
							@endforelse
							
						</tbody>
					</table>
			  	</div>
			</div>
		</div>

	</div>
@endsection
@extends('layout')

@section('main')
	<div class="wrap-toast"></div>
	<div class="btn-add-task"> 
		<button id="btnCreate" class="btn rounded-pill btn-icon btn-primary" title="Crear nueva tarea">
			<span><i class="bx bx-plus"></i></span>
		</button> 
	</div>

  	@include('task._form_search', ['title' => 'Mis tareas'])

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
					<a href="{{ route('task.index') }}" type="button" class="nav-link" aria-selected="false" tabindex="-1">
            <i class="bx bx-list-ol"></i> Lista
          </a>
				</li>
				<li class="nav-item" role="presentation">
					<a href="{{ route('kanban.index') }}" type="button" class="nav-link active" ria-selected="true">
            <i class="bx bx-card"></i> Tarjetas
          </a>
				</li>
				<li class="nav-item" role="presentation">
					<a href="{{ route('calendar.index') }}" type="button" class="nav-link" ria-selected="true">
            <i class="bx bx-calendar"></i> Calendario
          </a>
				</li>
			</ul>
		</div>
		<div id="myKanban" class="kanban"></div>
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

    <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css" rel="stylesheet">

    <script>
      let boards = {
        "TOSTART": [],
        "PROCESS": [],
        "DELAY": [],
        "PAUSED": [],
        "FINALIZED": []
    }
	{{--
    @foreach($tasks as $task)
        boards["{{ $task->status }}"].push({
          id: "{{ $task->id }}",
          title: `
            <div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                  <img src="{{ $task->brand->image }}" class="rounded me-1" width="30" height="30">
                    <small class="fw-bold">{{ $task->brand->name }}</small>
                </div>
                <div>
                  <small class="badge rounded-pill @if( $task->priority == 'high' ) bg-label-danger @endif @if( $task->priority == 'medium' ) bg-label-warning @endif @if( $task->priority == 'low' ) bg-label-primary @endif" >
                    @switch($task->priority)
                      @case('low')
                        BAJA
                        @break
                      @case('medium')
                        MEDIA
                        @break
                      @case('high')
                        ALTA
                        @break
                    @endswitch
                  </small>
                </div>
              </div>
              <div>
                <div class="fw-bold"> 
                  <a href="{{ route('task.view', $task->id) }}" class="no-drag"> 
                    {{ $task->title }} 
                  </a>
                </div>
              </div>
              <div class="mt-2 mb-2 d-flex justify-content-start align-items-center gap-3">
                @if( $task->medias_count > 0 )
                <div class="d-flex gap-2">
                  <i class="bx bx-paperclip"></i>
                  <span> {{ $task->medias_count }} </span>
                </div>
                @endif
                @if( $task->medias_count > 0 )
                <div class="d-flex gap-2">
                  <i class="bx bx-message" style="transform:translateY(3px);"></i>
                  <span> - </span>
                </div>
                @endif
              </div>
              <div class="mb-2">
                @if( $task->childs_count > 0 )
                <div class="d-flex justify-content-between mb-1">
                    <div>
                        <small class="fw-bold">Subtareas</small>
                    </div>
                    <div class="text-primary fw-bold">
                        {{ $task->childs_done }}/{{ $task->childs_count }}
                    </div>
                    
                </div>
                <div>
                    <div class="progress" style="height: 16px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $task->progress }}%
                        </div>
                    </div>
                </div>
                @endif
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up avatar-xs" aria-label="{{ $task->assign->name }}" data-bs-original-title="{{ $task->assign->name }}">
                      @if( $task->assign->image )
                        <img class="rounded-circle" src="{{ $task->assign->image }}" alt="{{ $task->assign->name }}">
                      @else
                        <span class="avatar-initial rounded-circle">{{ $task->assign->nameInitial }}</span>
                      @endif
                    </li>
                    @foreach($task->collaborators as $index => $collaborator)
                      @if( $index >= 2)
                          @break
                      @endif

                      <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up avatar-xs" aria-label="{{ $collaborator->user->name }}" data-bs-original-title="{{ $collaborator->user->name }}">
                        @if( $collaborator->user->image )
                          <img class="rounded-circle" src="{{ $collaborator->user->image }}" alt="{{ $collaborator->user->name }}">
                        @else
                          <span class="avatar-initial rounded-circle">{{ $collaborator->user->nameInitial }}</span>
                        @endif
                      </li>
                    @endforeach

                    @if( $task->collaborators_count >= 3 )
                      <li class="avatar">
                          <span class="avatar-initial rounded-circle pull-up text-heading avatar-xs" 
                              data-bs-toggle="tooltip" 
                              data-bs-placement="bottom" 
                              data-bs-original-title="{{ 3 - $task->collaborators_count }} más">
                              +{{ 3 - $task->collaborators_count }}
                          </span>
                      </li>
                    @endif
                  </ul>  
                </div>
                <div>
                  <small>{{ $task->register_at }}</small>
                </div>
              </div>
            </div>
          `
        });
    @endforeach
	--}}
    @foreach($taskToStart as $task)
		data = {
			id: "{{ $task->id }}",
			title: "{{ $task->title }}",
			brand: { name: "{{ $task->brand->name }}", image: "{{ $task->brand->image }}" },
			priority: getPriorityColor("{{ $task->priority }}"),
			register_at: "{{ $task->register_at }}",
			assign: { 
				name: "{{ $task->assign->name }}", 
				image: "{{ $task->assign->image }}",
				nameInitial: "{{ $task->assign->nameInitial }}"
			},
			collaborators: [
				@foreach($task->collaborators as $collaborator)
				{
					user: {
						name: "{{ $collaborator->user->name }}",
						image: "{{ $collaborator->user->image }}",
						nameInitial: "{{ $collaborator->user->nameInitial }}"
					}
				},
				@endforeach
			],
			childs_count: "{{ $task->childs_count }}",
			childs_done: "{{ $task->childs_done }}",
			progress: "{{ $task->progress }}",
			medias_count: "{{ $task->medias_count }}",
			comments_count: "{{ $task->comments_count }}",
			url: "{{ route('task.view', $task->id) }}"
		};
		
		boards['TOSTART'].push(createItemKanban(data));
    @endforeach

	@foreach($taskProcess as $task)
		data = {
			id: "{{ $task->id }}",
			title: "{{ $task->title }}",
			brand: { name: "{{ $task->brand->name }}", image: "{{ $task->brand->image }}" },
			priority: getPriorityColor("{{ $task->priority }}"),
			register_at: "{{ $task->register_at }}",
			assign: { 
				name: "{{ $task->assign->name }}", 
				image: "{{ $task->assign->image }}",
				nameInitial: "{{ $task->assign->nameInitial }}"
			},
			collaborators: [
				@foreach($task->collaborators as $collaborator)
				{
					user: {
						name: "{{ $collaborator->user->name }}",
						image: "{{ $collaborator->user->image }}",
						nameInitial: "{{ $collaborator->user->nameInitial }}"
					}
				},
				@endforeach
			],
			childs_count: "{{ $task->childs_count }}",
			childs_done: "{{ $task->childs_done }}",
			progress: "{{ $task->progress }}",
			medias_count: "{{ $task->medias_count }}",
			comments_count: "{{ $task->comments_count }}",
			url: "{{ route('task.view', $task->id) }}"
		};
		
		boards['PROCESS'].push(createItemKanban(data));
    @endforeach
	
	@foreach($taskFinalized as $task)
		data = {
			id: "{{ $task->id }}",
			title: "{{ $task->title }}",
			brand: { name: "{{ $task->brand->name }}", image: "{{ $task->brand->image }}" },
			priority: getPriorityColor("{{ $task->priority }}"),
			register_at: "{{ $task->register_at }}",
			assign: { 
				name: "{{ $task->assign->name }}", 
				image: "{{ $task->assign->image }}",
				nameInitial: "{{ $task->assign->nameInitial }}"
			},
			collaborators: [
				@foreach($task->collaborators as $collaborator)
				{
					user: {
						name: "{{ $collaborator->user->name }}",
						image: "{{ $collaborator->user->image }}",
						nameInitial: "{{ $collaborator->user->nameInitial }}"
					}
				},
				@endforeach
			],
			childs_count: "{{ $task->childs_count }}",
			childs_done: "{{ $task->childs_done }}",
			progress: "{{ $task->progress }}",
			medias_count: "{{ $task->medias_count }}",
			comments_count: "{{ $task->comments_count }}",
			url: "{{ route('task.view', $task->id) }}"
		};
		
		boards['FINALIZED'].push(createItemKanban(data));
    @endforeach
	
	@foreach($taskDelay as $task)
		data = {
			id: "{{ $task->id }}",
			title: "{{ $task->title }}",
			brand: { name: "{{ $task->brand->name }}", image: "{{ $task->brand->image }}" },
			priority: getPriorityColor("{{ $task->priority }}"),
			register_at: "{{ $task->register_at }}",
			assign: { 
				name: "{{ $task->assign->name }}", 
				image: "{{ $task->assign->image }}",
				nameInitial: "{{ $task->assign->nameInitial }}"
			},
			collaborators: [
				@foreach($task->collaborators as $collaborator)
				{
					user: {
						name: "{{ $collaborator->user->name }}",
						image: "{{ $collaborator->user->image }}",
						nameInitial: "{{ $collaborator->user->nameInitial }}"
					}
				},
				@endforeach
			],
			childs_count: "{{ $task->childs_count }}",
			childs_done: "{{ $task->childs_done }}",
			progress: "{{ $task->progress }}",
			medias_count: "{{ $task->medias_count }}",
			comments_count: "{{ $task->comments_count }}",
			url: "{{ route('task.view', $task->id) }}"
		};
		
		boards['DELAY'].push(createItemKanban(data));
    @endforeach

	@foreach($taskPaused as $task)
		data = {
			id: "{{ $task->id }}",
			title: "{{ $task->title }}",
			brand: { name: "{{ $task->brand->name }}", image: "{{ $task->brand->image }}" },
			priority: getPriorityColor("{{ $task->priority }}"),
			register_at: "{{ $task->register_at }}",
			assign: { 
				name: "{{ $task->assign->name }}", 
				image: "{{ $task->assign->image }}",
				nameInitial: "{{ $task->assign->nameInitial }}"
			},
			collaborators: [
				@foreach($task->collaborators as $collaborator)
				{
					user: {
						name: "{{ $collaborator->user->name }}",
						image: "{{ $collaborator->user->image }}",
						nameInitial: "{{ $collaborator->user->nameInitial }}"
					}
				},
				@endforeach
			],
			childs_count: "{{ $task->childs_count }}",
			childs_done: "{{ $task->childs_done }}",
			progress: "{{ $task->progress }}",
			medias_count: "{{ $task->medias_count }}",
			comments_count: "{{ $task->comments_count }}",
			url: "{{ route('task.view', $task->id) }}"
		};
		
		boards['PAUSED'].push(createItemKanban(data));
    @endforeach
	
	function getPriorityColor(priority){
		let className = '';
		let name = ''; 

		switch(priority){
			case 'low':
				className = 'bg-label-primary';
				name = 'BAJA';
			break;
			case 'medium':
				className = 'bg-label-warning';
				name = 'MEDIA';
			break;
			case 'high':
				className = 'bg-label-danger';
				name = 'ALTA';
			break;
		}

		return { class: className, name: name };
		
	}

	function createItemKanban(data){
		let medias_html = '';
		let comment_html = '';
		let tasks_html = '';
		let assign_html = '';
		let collaborators_html = '';
		
		if( data.medias_count > 0 ){
			medias_html = `<div class="d-flex gap-2">
							<i class="bx bx-paperclip"></i>
							<span> ${ data.medias_count } </span>
						  </div>`;
		}
		
		if( data.comments_count > 0 ){
			comment_html = `<div class="d-flex gap-2">
							<i class="bx bx-message" style="transform:translateY(3px);"></i>
							<span> ${ data.comments_count } </span>
						  </div>`;
		}
		
		if( data.childs_count > 0 ){
			tasks_html = `<div class="d-flex justify-content-between mb-1">
							<div>
								<small class="fw-bold">Subtareas</small>
							</div>
							<div class="text-primary fw-bold">
								${ data.childs_done }/${ data.childs_count }
							</div>
						</div>
						<div>
							<div class="progress" style="height: 16px;">
								<div class="progress-bar" role="progressbar" style="width: ${ data.progress }%;" aria-valuenow="${ data.progress }" aria-valuemin="0" aria-valuemax="100">
									${ data.progress }%
								</div>
							</div>
						</div>`;

		}
		
		if( data.assign.image ){
			assign_html = `<img class="rounded-circle" src="${ data.assign.image }" alt="${ data.assign.name }">`;
		}else{
			assign_html = `<span class="avatar-initial rounded-circle">${ data.assign.nameInitial }</span>`;
		}
		
		for(let i=0; i < data.collaborators.length; i++){
			let collaborator = data.collaborators[i];
			if( i >= 2){
				break
			}

			let imageCollaborator = `<span class="avatar-initial rounded-circle">${ collaborator.user.nameInitial }</span>`;
			if( collaborator.user.image ){
				imageCollaborator = `<img class="rounded-circle" src="${ collaborator.user.image }" alt="${ collaborator.user.name }">`;
			}

			collaborators_html += `<li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up avatar-xs" aria-label="${ collaborator.user.name }" data-bs-original-title="${ collaborator.user.name }">
					${ imageCollaborator }
			</li>`;
		}

		if( data.collaborators_count >= 3 ){
			collaborators_html += `<li class="avatar">
									<span class="avatar-initial rounded-circle pull-up text-heading avatar-xs" 
										data-bs-toggle="tooltip" 
										data-bs-placement="bottom" 
										data-bs-original-title="${ 3 - data.collaborators_count } más">
										+${ 3 - data.collaborators_count }
									</span>
								</li>`;
		}
		
		return {
			id: data.id,
			title: `
				<div>
					<div class="d-flex justify-content-between align-items-center mb-2">
						<div class="d-flex align-items-center">
						<img src="${ data.brand.image }" class="rounded me-1" width="30" height="30">
							<small class="fw-bold">${ data.brand.name }</small>
						</div>
						<div>
						<small class="badge rounded-pill ${ data.priority.class }"> ${ data.priority.name } </small>
						</div>
					</div>
					<div>
						<div class="fw-bold"> 
						<a href="${ data.url }" class="no-drag">  ${ data.title } </a>
						</div>
					</div>
					<div class="mt-2 mb-2 d-flex justify-content-start align-items-center gap-3">
						${ medias_html }
						${ comment_html }
					</div>
					<div class="mb-2">
						${ tasks_html }
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
								<li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up avatar-xs" aria-label="${ data.assign.name }" data-bs-original-title="${ data.assign.name }">
									${ assign_html }
								</li>
								${ collaborators_html }
							</ul>  
						</div>
						<div>
							<small>${ data.register_at }</small>
						</div>
					</div>
				</div>
			`
		}
	}

    var KanbanTest = new jKanban({
        //dragBoards: false, // evita mover columnas
        //dragItems: false ,// evita mover items 


        element: "#myKanban",
        gutter: "10px",
        widthBoard: "280px",
        //itemHandleOptions:{
        //  enabled: true,
        //},
        click: function(el) {
          console.log("Trigger on all items click!");
        },
        context: function(el, e) {
          console.log("Trigger on all items right-click!");
        },
        dropEl: function(el, target, source, sibling){
          console.log(target.parentElement.getAttribute('data-id'));
          console.log(el, target, source, sibling)
        },
        dragBoards : false, 
        boards: [
          {
            id: "TOSTART",
            title: "Sin empezar",
            class: "info,good",
            item: boards.TOSTART
          },
          {
            id: "PROCESS",
            title: "En proceso",
            class: "warning",
            item: boards.PROCESS
          },
          {
            id: "DELAY",
            title: "Retrasado",
            class: "success",
            item: boards.DELAY
          },
          {
            id: "PAUSED",
            title: "Pausado",
            class: "success",
            item: boards.PAUSED
          },
          {
            id: "FINALIZED",
            title: "Finalizado",
            class: "success",
            item: boards.FINALIZED
          }
        ],
        dropEl : function (el, target, source, sibling) {
          var itemId = el.getAttribute("data-eid");
          var fromBoard = source.parentElement.getAttribute("data-id");
          var toBoard = target.parentElement.getAttribute("data-id");

          var items = Array.from(target.children);
          var index = items.indexOf(el);

          var boardId = target.parentElement.getAttribute("data-id");
          var orderedItems = Array.from(target.children).map((item, index) => ({
            id: item.getAttribute("data-eid"),
            position: index
          }));

          fetch("{{ route('kanban.draganddrop') }}", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
              "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
              task_id: itemId,
              new_status: toBoard,
              position: index,
              order: {
                board: boardId,
                items: orderedItems
              }
            })
          })
          .then(response => response.json())
          .then(data => {
            handleResponseServerDragDrop(data);
            console.log("Respuesta del servidor:", data);
          });
        },
      });

      function handleResponseServerDragDrop(data) {
        if( data.success && data.message ) {
          const wrapToast = document.querySelector('.wrap-toast');
          let classAlert = data.success ? 'bg-success' : 'bg-danger';
          let idRandom = Math.random().toString(36).substring(2, 9);
          let html = `
            <div id="${idRandom}" class="bs-toast toast fade hide ${classAlert}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
              <div class="toast-header">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">Tablero</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">${ data.message }</div>
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
      }

      $(document).ready(function () {
          //Refrescar los tooltip de los usuarios en las tarjetas
          new bootstrap.Tooltip("body", {
              selector: "[data-bs-toggle='tooltip']"
          });

          //Preven click en la tarea para que pueda abrir la vista de detalle de tarea
          document.addEventListener("click", function(e) {
            if (e.target.closest(".no-drag")) {
              e.stopPropagation();
              const href = e.target.getAttribute('href');
              window.open(href, '_self');
            }
          });
      });
    </script>
@endsection
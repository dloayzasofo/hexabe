@extends('layout')

@section('main')
  <div class="row sm-vl-base mb-2">
    <div class="col-sm-8 col-md-6">
        <h4 class="fw-bold"> Mis tareas </h4>
    </div>
    <div class="col-sm-4 col-md-6">
        <div class="dt-action-buttons text-end pt-md-0">
            <div class="dt-buttons"> 
                
            </div>
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
          <a href="{{ route('task.index') }}" type="button" class="nav-link" aria-selected="false" tabindex="-1">Lista</a>
        </li>
        <li class="nav-item" role="presentation">
          <a href="{{ route('kanban.index') }}" type="button" class="nav-link active" ria-selected="true">Tarjetas</a>
        </li>
      </ul>
    </div>
    <div id="myKanban" class="kanban"></div>
  </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css" rel="stylesheet">

    <script>
      let boards = {
        "TOSTART": [],
        "PROCESS": [],
        "FINALIZED": [],
        "DELAY": [],
        "PAUSED": []
      }

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
                    @foreach($task->collaborators as $index => $collaborator)
                      @if( $index >= 2)
                          @break
                      @endif

                      <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up avatar-xs" aria-label="{{ $collaborator->user->name }}" data-bs-original-title="{{ $collaborator->user->name }}">
                          <img class="rounded-circle" src="{{ $collaborator->user->image }}" alt="{{ $collaborator->user->name }}">
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
        /*
        buttonClick: function(el, boardId) {
          console.log(el);
          console.log(boardId);
          // create a form to enter element
          var formItem = document.createElement("form");
          formItem.setAttribute("class", "itemform");
          formItem.innerHTML =
            '<div class="form-group"><textarea class="form-control" rows="2" autofocus></textarea></div><div class="form-group"><button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button><button type="button" id="CancelBtn" class="btn btn-default btn-xs pull-right">Cancel</button></div>';

          KanbanTest.addForm(boardId, formItem);
          formItem.addEventListener("submit", function(e) {
            e.preventDefault();
            var text = e.target[0].value;
            KanbanTest.addElement(boardId, {
              title: text
            });
            formItem.parentNode.removeChild(formItem);
          });
          document.getElementById("CancelBtn").onclick = function() {
            formItem.parentNode.removeChild(formItem);
          };
        },
        itemAddOptions: {
          enabled: true,
          content: '+ Add New Card',
          class: 'custom-button',
          footer: true
        },
        */
        dragBoards : false, 
        boards: [
          {
            id: "TOSTART",
            title: "Sin empezar",
            class: "info,good",
            //dragTo: ["_working"],
            item: boards.TOSTART
          },
          {
            id: "PROCESS",
            title: "En proceso",
            class: "warning",
            item: boards.PROCESS
          },
          {
            id: "FINALIZED",
            title: "Finalizado",
            class: "success",
            //dragTo: ["_working"],
            item: boards.FINALIZED
          },
          {
            id: "DELAY",
            title: "Retrasado",
            class: "success",
            //dragTo: ["_working"],
            item: boards.DELAY
          },
          {
            id: "PAUSED",
            title: "Pausado",
            class: "success",
            //dragTo: ["_working"],
            item: boards.PAUSED
          }
        ],
        dragendEl : function(el){
          //console.log(el);
        },
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

      /*
      var toDoButton = document.getElementById("addToDo");
      toDoButton.addEventListener("click", function() {
        KanbanTest.addElement("_todo", {
          title: "Test Add"
        });
      });

      var toDoButtonAtPosition = document.getElementById("addToDoAtPosition");
      toDoButtonAtPosition.addEventListener("click", function() {
        KanbanTest.addElement("_todo", {
          title: "Test Add at Pos"
        }, 1);
      });

      var addBoardDefault = document.getElementById("addDefault");
      addBoardDefault.addEventListener("click", function() {
        KanbanTest.addBoards([
          {
            id: "_default",
            title: "Kanban Default",
            item: [
              {
                title: "Default Item"
              },
              {
                title: "Default Item 2"
              },
              {
                title: "Default Item 3"
              }
            ]
          }
        ]);
      });

      var removeBoard = document.getElementById("removeBoard");
      removeBoard.addEventListener("click", function() {
        KanbanTest.removeBoard("_done");
      });

      var removeElement = document.getElementById("removeElement");
      removeElement.addEventListener("click", function() {
        KanbanTest.removeElement("_test_delete");
      });
      */  

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
              window.open(href, "_blank");
            }
          });
      });


    </script>
@endsection
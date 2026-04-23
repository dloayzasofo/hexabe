@extends('layout')

@section('main')
    @if(Session::has('task.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('task.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="btn-add-task"> 
        <button id="btnCreate" class="btn rounded-pill btn-icon btn-primary" title="Crear sub tarea"
            data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" aria-label="Crear sub tarea" data-bs-original-title="Crear sub tarea">
            <span><i class="bx bx-plus"></i></span>
        </button> 
    </div>

    <div class="row sm-vl-base mb-4">
        <div class="col-md-12">
            <div class="d-flex mb-3">
                @if( $task->status == 'TOSTART' )
                    <span class="badge rounded-pill me-2 bg-label-secondary">Por empezar</span>
                @elseif( $task->status == 'PROCCESS' )
                    <span class="badge rounded-pill me-2 bg-label-primary">Proceso</span>
                @elseif( $task->status == 'DELAY' )
                    <span class="badge rounded-pill me-2 bg-label-danger">Retrasado</span>
                @elseif( $task->status == 'PAUSED' )
                    <span class="badge rounded-pill me-2 bg-label-warning">Pausado</span>
                @elseif( $task->status == 'FINALIZED' )
                    <span class="badge rounded-pill me-2 bg-label-success">Finalizado</span>
                @endif
                
                @if( $task->priority == 'low')
                    <span class="badge rounded-pill bg-label-primary ">Prioridad baja</span>
                @elseif( $task->priority == 'medium')
                    <span class="badge rounded-pill bg-label-warning ">Prioridad media</span>
                @elseif( $task->priority == 'high')
                    <span class="badge rounded-pill bg-label-danger">Prioridad alta</span>
                @endif
            </div>
            <div class="d-flex align-items-center w-100">
                <div>
                    <h2 class="fw-bold" style="margin-bottom:4px;"> {{ $task->title }} </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            @if( trim($task->description) !== '' )
            <div class="mb-2"><b>Descripción:</b> </div>
            <div class="border rounded p-3">
                <div>{!! $task->description !!}</div>
            </div>
            @endif

            @if( count($childs) > 0 )
            <div class="mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="fw-bold">Subtareas</h5>
                            </div>
                            <div>
                                {{ $task->progress }}% Completado
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="progress" style="height: 16px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $task->progress }}%
                                </div>
                            </div>
                        </div>

                        
                        <div>
                            @foreach ($childs as $child)
                            <div class="d-flex align-items-center border-primary py-3 px-4 border rounded mt-2" style="border-color:#F1F5F9 !important;">
                                <div class="me-3">
                                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none" 
                                        @if( $child->status == 'FINALIZED' ) style="color:#22C55E;" @endif>
                                        <i class="icon-base bx @if( $child->status == 'FINALIZED' ) bx-check-circle @else bx-circle @endif" style="font-size:25px;"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-3">
                                        <div>

                                            <a href="{{ route('task.view', $child->id) }}" class="mb-0 text-heading" 
                                                @if( $child->status == 'FINALIZED' ) style="text-decoration: line-through;" @endif>
                                                {{ $child->title }} <br>
                                            </a>
                                            <small class="mt-auto mb-1 text-heading"> {{ $child->register_at }} </small>
                                        </div>
                                    </div>
                                    <div class="user-progress">
                                        <div class="d-flex justify-content-center">
                                            <div class="avatar avatar-sm">
                                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="{{ $task->assign->name }}" data-bs-original-title="{{ $task->assign->name }}">
                                                    @if( $task->assign->image != null )
                                                        <img src="{{ $task->assign->image }}" class="avatar rounded-circle">
                                                    @else
                                                        <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->assign->nameInitial }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{-- 
                            <div class="d-flex align-items-center border-primary py-3 px-4 border rounded mt-2" style="border-color:#F1F5F9 !important;">
                                <div class="me-3">
                                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                        <i class="icon-base bx bx-circle" style="font-size:25px;"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-3">
                                        <p class="mb-0 text-heading">Lorem ipsum dolor sit amet consectetur.</p>
                                    </div>
                                    <div class="user-progress">
                                        <div class="avatar avatar-sm">
                                                <span class="avatar-initial rounded-circle bg-label-danger">DL</span>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center border-primary py-3 px-4 border rounded mt-2" style="border-color:#F1F5F9 !important;">
                                <div class="me-3">
                                    <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none" >
                                        <i class="icon-base bx bx-circle" style="font-size:25px;"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-3">
                                        <p class="mb-0 text-heading">Lorem ipsum dolor sit amet consectetur.</p>
                                    </div>
                                    <div class="user-progress">
                                        <div class="d-flex justify-content-center">
                                            <div class="avatar avatar-sm">
                                                <span class="avatar-initial rounded-circle bg-label-danger">DL</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            --}}
                        </div>
                    </div>
                </div>
            </div> 
            @endif           

            <div class="mt-5">
                <h4 class="fw-bold">Conversación del equipo </h4>
                <div class="comment-wrapper">
                    {{--
                    <div class="d-flex overflow-hidden mb-3">
                        <div class="user-avatar flex-shrink-0 me-4">
                            <div class="avatar avatar-md">
                            <img src="{{ asset('assets/img/2.png') }}" alt="Avatar" class="rounded-circle">
                            </div>
                        </div>
                        <div class="chat-message-wrapper flex-grow-1">
                            <div class="chat-message-text p-3" style="background:#fff;border-radius:0px 12px 12px 12px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="fw-bold">
                                        Alex Rivera
                                    </div>
                                    <div>
                                        Hace 1 horas
                                    </div>
                                </div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet consectetur. Dignissim id purus suspendisse elementum. Pretium libero eget integer ridiculus.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex overflow-hidden mb-3">
                        <div class="user-avatar flex-shrink-0 me-4">
                            <div class="avatar avatar-md">
                            <img src="{{ asset('assets/img/3.png') }}" alt="Avatar" class="rounded-circle">
                            </div>
                        </div>
                        <div class="chat-message-wrapper flex-grow-1">
                            <div class="chat-message-text p-3" style="background:#fff;border-radius:0px 12px 12px 12px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="fw-bold">
                                        Sarah Chen
                                    </div>
                                    <div>
                                        Hace 2 horas
                                    </div>
                                </div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet consectetur. Dignissim id purus suspendisse elementum. Pretium libero eget integer ridiculus.
                                </p>
                                <div class="d-flex mt-3 ">
                                    <a href="" target="_blank" class="text-nowrap mb-0 me-2">
                                        <i class="icon-base bx bx-file align-bottom"></i> <small style="transform:translateY(2px);display:inline-block;">5 Mb</small>
                                    </a>
                                    <a href="" target="_blank" class="text-nowrap mb-0 me-2">
                                        <i class="icon-base bx bx-image align-bottom"></i> <small style="transform:translateY(2px);display:inline-block;">5 Mb</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}

                    @foreach($comments as $comment)
                        <div class="d-flex overflow-hidden mb-3">
                            <div class="user-avatar flex-shrink-0 me-4">
                                <div class="avatar avatar-md">
                                    @if( $comment->user->image )
                                        <img src="{{ $comment->user->image }}" alt="Avatar" class="rounded-circle">
                                    @else
                                        <span class="avatar-initial rounded-circle bg-label-danger">{{ $comment->user->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-text p-3" style="background:#fff;border-radius:0px 12px 12px 12px;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="fw-bold">
                                            {{ $comment->user->name }}
                                        </div>
                                        <div>
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        {{ $comment->description }}
                                    </p>
                                    <div class="d-flex mt-3 ">
                                        @foreach( $comment->commentmedias as $commentmedia )
                                        <a href="{{  $commentmedia->media->url }}" target="_blank" class="text-nowrap mb-0 me-2" download>
                                            @if( str_contains($commentmedia->media->mime, 'image') )
                                                <i class="icon-base bx bx-image align-bottom"></i>        
                                            @else
                                                <i class="icon-base bx bx-file align-bottom"></i>        
                                            @endif
                                             <small style="transform:translateY(2px);display:inline-block;">{{ $commentmedia->media->size_literal }}</small>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5">
                    <form action="">

                        <div class="d-flex overflow-hidden mb-3">
                            <div class="user-avatar flex-shrink-0 me-4">
                                <div class="avatar avatar-md">
                                    @if ( Auth::user()->image )
                                        <img src="{{ Auth::user()->image }}" alt="Avatar" class="rounded-circle">
                                    @else
                                        <span class="avatar-initial rounded-circle bg-label-danger">{{ Auth::user()->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-text">
                                    <div class="mb-0">
                                        <textarea name="comment" id="comment" class="form-control" placeholder="Escribe un comentario"></textarea>
                                    </div>

                                    <div id="wrapCommentFiles" class=""></div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button id="btnAttach" type="button" class="btn btn-outline-warning me-3">
                                <span class="icon-base bx bx-paperclip icon-sm me-2"></span>
                                Adjuntar
                            </button>
                            <button id="commentSave" type="button" class="btn btn-warning">Publicar</button>
                        </div>
                    </form>
                </div>
            </div>

            @if( $task->status != 'FINALIZED' )
                @if( Auth::user()->id == $task->user_assign OR Auth::user()->id == $task->user_id )
                    <div class="mt-5 mb-4">
                        <form action="{{ route('task.finish', ['task' => $task->id]) }}" method="post">
                            @csrf

                            <div class="text-center mx-auto">
                                <button class="btn btn-primary btn-lg" style="width:50%;">
                                    Marcar como terminada
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @endif
        </div>
        <div class="col-md-4">
            <div class="card" style="background-color: transparent;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-md me-3">
                                    <img src="{{ $task->brand->image }}" alt="Avatar" class="rounded-2">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('brand.view', ['brand' => $task->brand]) }}" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $task->brand->name }}</span>
                                </a>
                                <small>{{ $task->brand->industry }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="mb-2"><small>DUEÑO DEL PROYECTO</small></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-md me-3">
                                    @if( $task->user->image != null )
                                        <img src="{{ $task->user->image }}" alt="Avatar" class="rounded-2">
                                    @else 
                                        <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->user->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('task.user.list', [$task->user]) }}" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $task->user->name }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 mt-4"><small>RESPONSABLE</small></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-md me-3">
                                    @if( $task->assign->image != null )
                                        <img src="{{ $task->assign->image }}" alt="Avatar" class="rounded-2">
                                    @else 
                                        <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->assign->nameInitial }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('task.user.list', [$task->assign]) }}" class="text-heading text-truncate">
                                    <span class="fw-medium">{{ $task->assign->name }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 mt-4"><small>FECHA LÍMITE</small></div>
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="bx bx-calendar"></i>
                        </div>
                        <div>
                            {{ Carbon\Carbon::parse($task->date_delivery)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-4">
                <div class="fw-bold">Archivos adjuntos y enlaces</div>

                @if( count($taskMedias) == 0 && count($taskLinks) == 0 )
                    <div class="border rounded p-3 text-center mt-2" style="background:#F1F5F9;">
                        No hay archivos adjuntos ni enlaces relacionados con esta tarea.
                    </div>
                @endif
            </div>

            @if( count($taskMedias) > 0 )
                @foreach( $taskMedias as $taskMedia )
                    <a href="{{ $taskMedia->media->url }}" class="block" target="_blank">
                        <div class="card mt-2" style="background:transparent;box-shadow:none; border: 1px solid #e2e8f0;">
                            <div class="card-body" style="padding:10px;">
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-md me-3">
                                            <span class="avatar-initial rounded bg-label-danger"><i class="icon-base bx bx-file icon-lg"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>{{ $taskMedia->media->name }}</small>
                                        <small>{{ $taskMedia->media->size_literal }}</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                @endforeach
            @endif

            @if( count($taskLinks) > 0 )
                @foreach( $taskLinks as $taskLink )
                    <a href="{{ $taskLink->url }}" class="block" target="_blank">
                        <div class="card mt-2" style="background:transparent;box-shadow:none; border: 1px solid #e2e8f0;">
                            <div class="card-body" style="padding:10px;">
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-md me-3">
                                            <span class="avatar-initial rounded bg-label-danger"><i class="icon-base bx bx-link icon-lg"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>{{ $taskLink->url }}</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>


    <div class="modal fade " id="modalCenter" tabindex="-1" aria-modal="true" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
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
{{-- --}} 
<script>let urlCreate = "{{ route('task.subtask', ['task' => $task->id]) }}";</script>
<script src="{{asset('/assets/admin/js/task.js')}}"></script>
{{-- --}}


{{-- 
<script>
    let mode = null;
    let urlCreate = "{{ route('task.subtask', ['task' => $task->id]) }}";
    let myDropzone = null;

    window.addEventListener('load', () => {
        document.querySelector('#btnCreate').addEventListener('click', handleBtnCreate);
    });

    /**
     * Handle click button create task, load form in popup and open modal
     */
    function handleBtnCreate(){
        fetch(urlCreate)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#popup').innerHTML = data;
            document.querySelector('#modalTitle').innerHTML = 'Crear nueva tarea';
            document.querySelector('#modalDescription').innerHTML = 'Todos los campos con  (*) son obligatorios.';
            $('#modalCenter').modal('show');
            mode = 'CREATE';

            myDropzone = new Dropzone("#task-files", { 
                url: "/media/upload", 
                addRemoveLinks: true,
                dictDefaultMessage: '<svg width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.875 20C4.97917 20 3.35938 19.3438 2.01562 18.0312C0.671875 16.7188 0 15.1146 0 13.2188C0 11.5938 0.489583 10.1458 1.46875 8.875C2.44792 7.60417 3.72917 6.79167 5.3125 6.4375C5.83333 4.52083 6.875 2.96875 8.4375 1.78125C10 0.59375 11.7708 0 13.75 0C16.1875 0 18.2552 0.848959 19.9531 2.54688C21.651 4.24479 22.5 6.3125 22.5 8.75C23.9375 8.91667 25.1302 9.53646 26.0781 10.6094C27.026 11.6823 27.5 12.9375 27.5 14.375C27.5 15.9375 26.9531 17.2656 25.8594 18.3594C24.7656 19.4531 23.4375 20 21.875 20H15C14.3125 20 13.724 19.7552 13.2344 19.2656C12.7448 18.776 12.5 18.1875 12.5 17.5V11.0625L10.5 13L8.75 11.25L13.75 6.25L18.75 11.25L17 13L15 11.0625V17.5H21.875C22.75 17.5 23.4896 17.1979 24.0938 16.5938C24.6979 15.9896 25 15.25 25 14.375C25 13.5 24.6979 12.7604 24.0938 12.1562C23.4896 11.5521 22.75 11.25 21.875 11.25H20V8.75C20 7.02083 19.3906 5.54688 18.1719 4.32812C16.9531 3.10938 15.4792 2.5 13.75 2.5C12.0208 2.5 10.5469 3.10938 9.32812 4.32812C8.10938 5.54688 7.5 7.02083 7.5 8.75H6.875C5.66667 8.75 4.63542 9.17708 3.78125 10.0312C2.92708 10.8854 2.5 11.9167 2.5 13.125C2.5 14.3333 2.92708 15.3646 3.78125 16.2188C4.63542 17.0729 5.66667 17.5 6.875 17.5H10V20H6.875Z" fill="#94A3B8"/></svg><br><b>Arrastra tus archivos aquí</b> o haz clic para subir', // Change the main text
                dictRemoveFile: "Eliminar", 
                init: dropzoneInitHandle
            });

            var editorDescription = new MeEditor({
                toolbar: '#toolbarDescription',
                placeholder: 'Añade detalles sobre la tarea...',
                editor: '#editorDescription',
                textarea: '#description'
            });
        });
    }
</script>

<script>
    /**
     * Handle remove file in dropzone, send request to server for delete file
     */
    function dropzoneInitHandle(){
        this.on("removedfile", function(file) {
            if (file.id) {
                $.ajax({
                    type: "POST",
                    url: "/media/delete",
                    data: { id: file.id },
                    success: function(response) {
                        console.log(response);
                    }
                });
            }
        });

        this.on("success", function(file, responseText) {
             file.serverFileName = responseText.name; 
             file.id = responseText.data.id;
             let attached = document.querySelector('#attach_media');
             let input = document.createElement('input');
             input.setAttribute('type', 'hidden');
             input.setAttribute('name', 'medias[]');
             input.setAttribute('value', responseText.data.id);
             attached.appendChild(input);
             
        });
    }
</script>

<script>
    /**
     * Eventos del formulario de creacipon de tarea,
     * para buscar responsable y miembros
     * crear tarea enviando datos por fetch a controlador y mostrar errores de validacion 
     */
    window.addEventListener('load', () => {
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('task-input-responsable')) {

                console.log("Input responsable", e.target.value);
                searchByKeyPress(e.target.value);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.target.classList.contains('task-input-responsable')) {
                if( e.target.value.length < 2){
                    document.querySelector('.task-responsable-result').classList.remove('active');
                    return;
                }
                searchByKeyPress(e.target.value);
            }

            if (e.target.classList.contains('task-input-member')) {
                if( e.target.value.length < 2){
                    document.querySelector('.task-members-result').classList.remove('active');
                    return;
                }
                searchMemeberKeyPress(e.target.value);
            }

        });

        document.addEventListener('click', (e) => {
            if( e.target.closest('.add-member') ){
                document.querySelector('.memebers-ajax').classList.toggle('hide');
            }
            
            if( e.target.classList.contains('btnSaveTask') ){
                handleCreateTask();
            }
            
            if( e.target.closest('.btnAddLink') ){
                handleAddLinkInput();
            }
            if( e.target.closest('.btnDeleteLink') ){
                handleDeleteLinkInput(e);
            }
        });
    });

    /**
     * Search responsable by key press, send request to server and render result
     */
    function searchByKeyPress(value){
        fetch(urlSearchByKey + '?q=' + value, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                return;
            }
            handlerRenderUserByKey(data.data);
        })
        .catch((e) => {
            console.log("Error Catch", e);
        });
    }

    /**
     * Render result search responsable, if click in result set responsable in form
     */
    function handlerRenderUserByKey(data){
        let result = document.querySelector('.task-responsable-result');
        let inputMemeber = document.querySelector('#task-input-responsable');

        result.innerHTML = '';
        if( data.length == 0 ){
            result.classList.remove('active');
            return;
        }

        data.forEach(user => {
            const existing = null;
            if ( existing == null ) {
                let div = document.createElement('div');
                
                if( user.image ) {
                    div.innerHTML = '<img src="' + user.image + '" class="avatar rounded-circle"/> ' + user.email;
                }else{
                    div.innerHTML = '<span>' + user.initials + '</span> ' + user.email;
                }

                div.classList.add('task-responsable-result-item');
                div.addEventListener('click', () => {
                    addSelectedResponsable(user);
                    result.classList.remove('active');
                });
                result.appendChild(div);
            }
        });

        if( result.innerHTML != '' ){
            result.classList.add('active');
        }
    }

    /**
     * Add responsable en el formulario
     */
    function addSelectedResponsable(user){
        let avatar = document.querySelector('#task-responsable-avatar');
        let responsable = document.querySelector('#user_assign');
        let email = document.querySelector('#task-input-responsable');

        if (!responsable) return;

        const existing = responsable.value == user.id;
        if (existing) {
            return;
        }
    
        if( user.image ) {
            avatar.innerHTML = '<img src="' + user.image + '" class="avatar rounded-circle"/> ';
        }else{
            avatar.innerHTML = '<span>' + user.initials + '</span> ';
        }

        responsable.value = user.id;
        email.value = user.email;
        /*
        pill.className = 'badge rounded-pill selected-member-pill';
        pill.style.display = 'inline-flex';
        pill.style.alignItems = 'center';
        pill.style.gap = '0.3rem';
        pill.innerHTML = `${avatar} <button type="button" class="btn-close remove-member" aria-label="Remove"></button>`;

        const inputHidden = document.createElement('input');
        inputHidden.type = 'hidden';
        inputHidden.name = 'members[]';
        inputHidden.value = user.id;
        pill.appendChild(inputHidden);

        selectedMembers.appendChild(pill);
        */
    }

    /**
     * Search members by key press, send request to server and render result
     */
    function searchMemeberKeyPress(value){
        fetch(urlSearchByKey + '?q=' + value, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                return;
            }
            handlerRenderMemberByKey(data.data);
        })
        .catch((e) => {
            console.log("Error Catch", e);
        });
    }

    /**
     * Render result search members, if click in result set members in form
     */
    function handlerRenderMemberByKey(data){
        let result = document.querySelector('.task-members-result');
        let inputMemeber = document.querySelector('#task-input-member');
        const selectedMembers = document.querySelector('#selected-members');

        result.innerHTML = '';
        if( data.length == 0 ){
            result.classList.remove('active');
            return;
        }

        data.forEach(user => {
            const existing = selectedMembers.querySelector('input[value="' + user.id + '"]');
            if ( existing == null ) {
                let div = document.createElement('div');
                
                if( user.image ) {
                    div.innerHTML = '<img src="' + user.image + '" class="avatar rounded-circle"/> ' + user.email;
                }else{
                    div.innerHTML = '<span>' + user.initials + '</span> ' + user.email;
                }

                div.classList.add('task-responsable-result-item');
                div.addEventListener('click', () => {
                    addSelectedMember(user);
                    result.classList.remove('active');
                    inputMemeber.value = '';
                });
                result.appendChild(div);
            }
        });

        if( result.innerHTML != '' ){
            result.classList.add('active');
        }
    }

    /**
     * Add member en el formulario
     */
    function addSelectedMember(user){
        let responsable = document.querySelector('#user_assign');
        let selectedMembers = document.querySelector('#selected-members');

        if (!responsable) return;

        const existing = selectedMembers.querySelector('input[value="' + user.id + '"]');
        if (existing) {
            return;
        }


        let avatar = '';
        if( user.image ) {
            avatar = '<img src="' + user.image + '" class="avatar rounded-circle"/> ';
        }else{
            avatar = '<span class="avatar-initial rounded-circle bg-label-primary">' + user.initials + '</span> ';
        }
        
        const pill = document.createElement('li');
        pill.setAttribute('data-bs-toggle', 'tooltip');
        pill.setAttribute('data-popup', 'tooltip-custom');
        pill.setAttribute('data-bs-placement', 'top');
        pill.className = 'avatar pull-up';
        pill.setAttribute('aria-label', user.name);
        pill.setAttribute('data-bs-original-title', user.name);

        pill.innerHTML = avatar;

        const inputHidden = document.createElement('input');
        inputHidden.type = 'hidden';
        inputHidden.name = 'members[]';
        inputHidden.value = user.id;
        pill.appendChild(inputHidden);

        selectedMembers.appendChild(pill);
        $(pill).tooltip();
        $('[data-toggle="tooltip"]').tooltip();
    }

    /**
     * Create task, send data by fetch to server and handle response, if success close modal and redirect to task view, if error show errors in form
     */     
    function handleCreateTask(){
        let form = document.querySelector('#formCreateTask');

        if( validateFormTaskCreate() == false ){
            return false;
        }

        let url = form.getAttribute('data-action');
        let token = document.getElementsByName("_token")[0];
        let name = document.querySelector('#name');
        let description = document.querySelector('#description');
        let priority = document.querySelector('#priority');
        let date_delivery = document.querySelector('#date_delivery');
        let brand = document.querySelector('#brand');
        let user_assign = document.querySelector('#user_assign');
        let parent_id = document.querySelector('#parent_id');

        var data = new FormData();
        data.append('_token', token.value);
        data.append('name', name.value);
        data.append('description', description ? description.value : '');
        data.append('priority', priority.value);
        data.append('date_delivery', date_delivery.value);
        data.append('brand', brand.value);
        data.append('user_assign', user_assign.value);
        data.append('parent_id', parent_id.value);
        
        const mediaInputs = document.querySelectorAll('input[name="medias[]"]');
        mediaInputs.forEach((input) => {
            data.append('medias[]', input.value);
        });

        const memberInputs = document.querySelectorAll('input[name="members[]"]');
        memberInputs.forEach((input) => {
            data.append('members[]', input.value);
        });

        const linkInputs = document.querySelectorAll('input[name="links[]"]');
        linkInputs.forEach((input) => {
            data.append('links[]', input.value);
        });

        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: data
        })
        .then(response => response.json())
        .then(data => {
            if( data.success){
                $('#modalCenter').modal('hide');
                console.log(data);
                location.reload();
                //location.href = "/task/view/" + data.data.id;
            }
            if( data.errors){
                handleShowErrors(data.errors);
            }
        });
    }

    /**
     * Validar el formulario de tarea
     */
    function validateFormTaskCreate(){
        clearTaskErrors();

        let name = document.querySelector('#name');
        let priority = document.querySelector('#priority');
        let brand = document.querySelector('#brand');
        let date_delivery = document.querySelector('#date_delivery');
        let user_assign = document.querySelector('#user_assign');

        let isOk = true;

        if( !name || !name.value ){
            showTaskError('name', 'El campo es requerido');
            isOk = false;
        }

        if( !priority.value ){
            showTaskError('priority', 'El campo es requerido');
            isOk = false;
        }

        if( !brand.value ){
            showTaskError('brand', 'El campo es requerido');
            isOk = false;
        }

        if( !date_delivery.value ){
            showTaskError('date_delivery', 'El campo es requerido');
            isOk = false;
        }

        if( !user_assign.value ){
            showTaskError('user_assign', 'El campo es requerido');
            isOk = false;
        }

        return isOk;
    }

    /**
     * Limpiar errores del formulario de tarea
     */
    function clearTaskErrors(){
        const fields = ['name', 'description', 'members'];
        fields.forEach((field) => {
            const el = document.querySelector('#' + field);
            if (el) el.classList.remove('is-invalid');
            const err = document.querySelector('#error' + field.charAt(0).toUpperCase() + field.slice(1));
            if (err) err.innerHTML = '';
        });
    }

    /**
     * Mostrar errores en el formulario de tarea
     */
    function showTaskError(elementName, error){
        const el = document.querySelector('#' + elementName);
        if (el) el.classList.add('is-invalid');
        const label = elementName.charAt(0).toUpperCase() + elementName.slice(1);
        const err = document.querySelector('#error' + label);
        if (err) err.innerHTML = error;
    }
</script>

<script>
    function handleAddLinkInput(){
        let wrap = document.querySelector('#links-container');
        let html = `<div class="input-group input-group-merge mb-2">
            <span class="input-group-text" style="background:#F8FAFC;">
                <i class="icon-base bx bx-link icon-lg"></i>
            </span>
            <input type="text" name="links[]" class="form-control input-user-search" placeholder="https://ejemplo.com">
            <span class="input-group-text btnDeleteLink" style="background:#F8FAFC;">
                <i class="bx bx-x" ></i>
            </span>
        </div>`;
        wrap.innerHTML += html;
    }

    function handleDeleteLinkInput(e){
        console.log("E", e.target);
        let element = e.target.closest('.input-group');
        if( element ){
            element.remove();
        }
    }
</script>
--}}



{{-- COMMENTS --}}
<script>
    window.addEventListener('load', () => {
        document.addEventListener('click', (e) => {
            if( e.target.closest('.btnDeleteFileAttach') ){
                handleDeleteFileAttach(e);
            }
    
            if( e.target.closest('#btnAttach') ){
                handleBtnAttach();
            }

            if( e.target.closest('#commentSave') ){
                handleBtnSaveComment();
            }
        });
    });

    function handleBtnAttach(){
        let html = `<input class="form-control form-control" name="medias[]" type="file">
            <button type="button" class="btn btn-icon btn-outline-secondary btnDeleteFileAttach">
                <span class="icon-base bx bx-x icon-sm"></span>
            </button>`;

        let elementDiv = document.createElement('div');
        elementDiv.classList.add('mt-2', 'input-group');
        elementDiv.innerHTML = html;

        let wrap = document.querySelector('#wrapCommentFiles');
        wrap.appendChild(elementDiv);

        //wrap.innerHTML += html;
    }

    function handleDeleteFileAttach(e){
        let element = e.target.closest('.input-group');
        if( element ){
            element.remove();
        }
    }

    function handleBtnSaveComment(){
        document.querySelector('#commentSave').disabled = true;
        let comment = document.querySelector('#comment');
        let files = document.querySelectorAll('input[name="medias[]"]');

        let formData = new FormData();
        formData.append('comment', comment.value);
        files.forEach((file) => {
            formData.append('medias[]', file.files[0]);
        });

        let url = "{{ route('comment.save', ['task' => $task->id]) }}";
        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => {
            return response.json();
        }).then(data => {
            document.querySelector('#commentSave').disabled = false;
            //console.log(data);
            if( data.success ){
                //location.reload();
                //console.log("Success");
                renderComments(data.data);
            }
        });
    }
    
    function renderComments( data ){
        let wrap = document.querySelector('.comment-wrapper');
        let userImage = `<span class="avatar-initial rounded-circle bg-label-danger">${ data.user.nameInitial }</span>`;
        
        if( data.user.image ){
            userImage = `<img src="${ data.user.image }" alt="Avatar" class="rounded-circle">`;
        }

        let html = `
        <div class="d-flex overflow-hidden mb-3">
            <div class="user-avatar flex-shrink-0 me-4">
                <div class="avatar avatar-md">
                    ${ userImage }
                </div>
            </div>
            <div class="chat-message-wrapper flex-grow-1">
                <div class="chat-message-text p-3" style="background:#fff;border-radius:0px 12px 12px 12px;">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="fw-bold">
                            ${ data.user.name }
                        </div>
                        <div>
                            Ahora
                        </div>
                    </div>
                    <p class="mb-0">
                        ${ data.comment.description }
                    </p>
                    <div class="d-flex mt-3 ">`;
        
                    let htmlMedia = '';
                    for(let i=0; i < data.medias.length; i++){
                        let media = data.medias[i];
                        htmlMedia += `<a href="${ media.url }" target="_blank" class="text-nowrap mb-0 me-2">`;
                            if( media.mime.includes('image') ){
                                htmlMedia += `<i class="icon-base bx bx-image align-bottom"></i>`;
                            }else{
                                htmlMedia += `<i class="icon-base bx bx-file align-bottom"></i>`;
                            }
                            htmlMedia += `<small style="transform:translateY(2px);display:inline-block;">${ media.sizeLiteral }</small>
                        </a>`;
                    }
                    html += htmlMedia;

        html +=     `</div>
                </div>
            </div>
        </div>
        `;

        wrap.insertAdjacentHTML('afterbegin', html);
        wrap.scrollTop = 0;
        wrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
</script>
@endsection
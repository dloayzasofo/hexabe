@extends('layout')

@section('main')
    <div class="wrap-toast"></div>

    @if(Session::has('task.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('task.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif


    <div class="row sm-vl-base mb-4">
        <div class="col-md-8">
            <div class="d-flex mb-3 align-items-center">
                @if(url()->previous() !== url()->current())
                    <a href="{{ url()->previous() }}" class="btn rounded-pill btn-icon btn-primary me-2" title="Atras" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" aria-label="Atras" data-bs-original-title="Atras" style="background:#3C8AEC;border-color:#3C8AEC;">
                        <i class="bx bx-chevron-left"></i>
                    </a>
                @else
                    <a href="{{ route('task.index') }}" class="btn rounded-pill btn-icon btn-primary me-2" title="Atras" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" aria-label="Atras" data-bs-original-title="Atras" style="background:#3C8AEC;border-color:#3C8AEC;">
                        <i class="bx bx-chevron-left"></i>
                    </a>
                @endif
                
                <div>
                    @if( in_array(Auth::user()->id, [$task->user_id, $task->user_assign]) )
                    <div class="ct-select" data-value="{{ $task->status }}" data-task="{{ $task->id }}" data-type="status" style="font-size:12px;">
                        <div class="ct-select-view"></div>
                        <ul class="list-items">
                            <li class="list-items-item TOSTART" data-id="{{ $task->id }}" data-value="TOSTART"> Sin empezar </li>
                            <li class="list-items-item PROCESS" data-id="{{ $task->id }}" data-value="PROCESS"> En proceso </li>
                            <li class="list-items-item DELAY" data-id="{{ $task->id }}" data-value="DELAY"> Retraso </li>
                            <li class="list-items-item PAUSED" data-id="{{ $task->id }}" data-value="PAUSED"> Pausado </li>
                            <li class="list-items-item FINALIZED" data-id="{{ $task->id }}" data-value="FINALIZED"> Finalizado </li>
                        </ul>
                    </div>
                    @else
                    <div class="ct-select {{ $task->status }}" data-value="{{ $task->status }}" data-task="{{ $task->id }}" data-type="status" style="font-size:12px;">
                        <div class="ct-select-view readonly">
                            @if( $task->status == 'TOSTART' )
                                Sin empezar
                            @elseif( $task->status == 'PROCESS' )
                                En proceso
                            @elseif( $task->status == 'DELAY' )
                                Retraso
                            @elseif( $task->status == 'PAUSED' )
                                Pausado
                            @elseif( $task->status == 'FINALIZED' )
                                Finalizado
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="ms-2">
                    @if( in_array(Auth::user()->id, [$task->user_id, $task->user_assign]) )
                    <div class="ct-select" data-value="{{ $task->priority }}" data-task="{{ $task->id }}" data-type="priority" style="font-size:12px;">
                        <div class="ct-select-view"></div>
                        <ul class="list-items">
                            <li class="list-items-item high" data-id="{{ $task->id }}" data-value="high"> Prioridad alta </li>
                            <li class="list-items-item medium" data-id="{{ $task->id }}" data-value="medium"> Prioridad media </li>
                            <li class="list-items-item low" data-id="{{ $task->id }}" data-value="low"> Prioridad baja </li>
                        </ul>
                    </div>
                    @else
                    <div class="ct-select {{ $task->priority }}" data-value="{{ $task->priority }}" data-task="{{ $task->id }}" data-type="priority" style="font-size:12px;">
                        <div class="ct-select-view readonly">
                            @if( $task->priority == 'high' )
                                Prioridad alta
                            @elseif( $task->priority == 'medium' )
                                Prioridad media
                            @elseif( $task->priority == 'low' )
                                Prioridad baja
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="d-flex align-items-center w-100">
                <div class="d-flex align-items-top hoverEdit">
                    @if( in_array(Auth::user()->id, [$task->user_id, $task->user_assign]) )
                    <button id="btnEditTitle" class="btn rounded-pill btn-icon btn-outline-secondary me-2 btnTaskEdit" data-bs-toggle="modal" data-bs-target="#titleModal"> 
                        <i class="bx bx-pencil"></i> 
                    </button>
                    @endif
                    <h2 id="modelTitle" class="fw-bold text-negro" style="margin-bottom:4px;"> {{ $task->title }} </h2> 
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <button id="btnCreate" class="btn btn-primary" title="Crear subtarea">
                <span><i class="bx bx-plus"></i></span> Crear subtarea
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-2 text-negro"><b>Descripción:</b> </div>
            <div class="border rounded p-3">
                @if( trim($task->description) !== '' )
                <div id="modelDescription">{!! $task->description !!}</div>
                @else
                <div id="modelDescription"> S/N </div>
                @endif
            </div>

            @include('task.view_section._subtask')         

            <div class="mt-5">
                <h4 class="fw-bold">Conversación del equipo </h4>
                @include('task.view_section._comment')

                @if( $userIsPartOfTask )
                <div class="mt-5">
                    <form action="">
                        <div class="d-flex mb-3">
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
                                        <div id="commentquilljs"></div>
                                        {{--<textarea name="comment" id="comment" class="form-control" placeholder="Escribe un comentario"></textarea>--}}
                                        <div id="commentError" class="text-danger small"></div>
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
                @endif
            </div>

            @if( $task->status != 'FINALIZED' )
                @if( Auth::user()->id == $task->user_assign OR Auth::user()->id == $task->user_id )
                    <div class="mt-5 mb-4">
                        <form action="{{ route('task.finish', ['task' => $task->id]) }}" method="post">
                            @csrf

                            <div class="text-center mx-auto">
                                <button id="btnFinishTask" class="btn btn-primary btn-lg" style="width:50%;">
                                    Marcar como terminada
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center hoverEdit">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-md me-3">
                                    <img id="brandImage" src="{{ $task->brand->image }}" class="rounded-2">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a id="brandUrl" href="{{ route('brand.view', ['brand' => $task->brand]) }}" class="text-heading text-truncate">
                                    <span id="brandName" class="fw-medium"> {{ $task->brand->name }} </span>
                                </a>
                                <small id="brandIndustry"> {{ $task->brand->industry }} </small>
                            </div>
                        </div>

                        @if( in_array(Auth::user()->id, [$task->user_id, $task->user_assign]) )
                        <div class="text-end">
                            <button id="btnEditBrand" class="btn rounded-pill btn-icon btn-outline-secondary me-2 btnTaskEdit" data-bs-toggle="modal" data-bs-target="#brandModal"> 
                                <i class="bx bx-pencil"></i> 
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @include('task.view_section._info')
            @include('task.view_section._parent')
            @include('task.view_section._media')
            
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

    @include('task.view._status')
    @include('task.view._priority')
    @include('task.view._title')
    @include('task.view._brand')
    @include('task.view._user')
    @include('task.view._date')
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
<script src="{{ asset('/assets/admin/js/fobo_select.js') }}"></script>



{{-- COMMENTS --}}
{{--
<link href="https://cdn.jsdelivr.net/npm/quill-mention@2.2.6/dist/quill.mention.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill-mention@2.2.6/dist/quill.mention.min.js"></script>
--}}
<link href="{{ asset('/assets/admin/js/quilljsmention/quillmention.min.css') }}" rel="stylesheet">
<script src="{{ asset('/assets/admin/js/quilljsmention/quillmention.min.js') }}"></script>
<script>
    const atValues = [];
    @foreach($users as $user)
        atValues.push({
            id: "{{$user->id}}",
            value: "{{$user->name}} {{$user->last_name}}",
        });
    @endforeach

    const toolbarOptions = [
        ['bold', 'link', 'clean']
    ];

    const quill = new Quill('#commentquilljs', {
        theme: 'snow',
        placeholder: 'Escribe un comentario...',
        modules: {
            toolbar: toolbarOptions,
            mention: {
                allowedChars: /^[A-Za-z\sÅÄÖåäö]*$/,
                //mentionDenotationChars: ['@', '#'],
                mentionDenotationChars: ['@'],
                source: function(searchTerm, renderList, mentionChar) {
                    //const values = mentionChar === '@' ? atValues : hashValues;
                    const values = atValues;
                    const normalizedTerm = searchTerm.trim().toLowerCase();

                    if (normalizedTerm.length === 0) {
                        return renderList(values, searchTerm);
                    }

                    const matches = values.filter(item =>
                        item.value.toLowerCase().includes(normalizedTerm)
                    );

                    renderList(matches, searchTerm);
                }
            }
        }
    });

    window.addEventListener('mention-clicked', function (event) {
        console.log(event);
    });

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

    function validateFormComment(){
        document.querySelector('#commentError').innerHTML = '';
        let commentquill = quill.root.innerHTML;
        if( commentquill == '' || commentquill == '<p><br></p>' ){
            document.querySelector('#commentError').innerHTML = 'El comentario es requerido';
            return false;
        }
        return true;
    }

    function handleBtnSaveComment(){
        let btnFinishTask = document.querySelector('#btnFinishTask');
        if( btnFinishTask ) btnFinishTask.disabled = true;
        if( validateFormComment() == false ){
            if( btnFinishTask ) btnFinishTask.disabled = false;
            return false;
        }
        document.querySelector('#commentSave').disabled = true;
        //let comment = document.querySelector('#comment');
        let files = document.querySelectorAll('input[name="medias[]"]');
        let commentquill = quill.root.innerHTML;

        let formData = new FormData();
        //formData.append('comment', comment.value);
        formData.append('comment', commentquill);
        files.forEach((file) => {
            formData.append('medias[]', file.files[0]);
        });

        let url = "{{ route('comment.save', ['task' => $task->id]) }}";
        fetch(url, {
            method: 'POST',
            //headers: {
            //    'Content-Type': 'application/json',
            //    'Accept': 'application/json'
            //},
            body: formData
        }).then(response => {
            return response.json();
        }).then(data => {
            if( btnFinishTask ) btnFinishTask.disabled = false;
            document.querySelector('#commentSave').disabled = false;
            if( data.success ){
                renderComments(data.data);
                cleanFormComment();
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

    function cleanFormComment(){
        //let comment = document.querySelector('#comment');
        //comment.value = '';

        quill.root.innerHTML = '<p><br></p>';

        let wrapFiles = document.querySelector('#wrapCommentFiles');
        wrapFiles.innerHTML = '';
    }
</script>
@endsection
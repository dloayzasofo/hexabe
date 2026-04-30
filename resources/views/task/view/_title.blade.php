<div class="modal fade hide" id="titleModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar título y descripción</h5>
                    <p>Llene los campos con el contenido a actualizar</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Título *</label>
                    <input type="text" class="form-control" id="updateTitle" name="updateTitle" placeholder="Ej: Equipo de Diseño UX" value="{{ $task->title }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción </label>
                    <div id="toolbarUpdateDescription" class="ql-toolbar ql-snow">
                        <span class="ql-formats">
                            <button class="ql-bold" type="button">
                                <svg viewBox="0 0 18 18"> 
                                    <path class="ql-stroke" d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z"></path> 
                                    <path class="ql-stroke" d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z"></path> 
                                </svg>
                            </button>
                            <button class="ql-link" type="button">
                                <svg viewBox="0 0 18 18"> 
                                    <line class="ql-stroke" x1="7" x2="11" y1="7" y2="11"></line> 
                                    <path class="ql-even ql-stroke" d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z"></path> <path class="ql-even ql-stroke" d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z"></path> 
                                </svg>
                            </button>
                            <button class="ql-list" value="ordered" type="button">
                                <svg viewBox="0 0 18 18"> 
                                    <line class="ql-stroke" x1="7" x2="15" y1="4" y2="4"></line> 
                                    <line class="ql-stroke" x1="7" x2="15" y1="9" y2="9"></line> 
                                    <line class="ql-stroke" x1="7" x2="15" y1="14" y2="14"></line> 
                                    <line class="ql-stroke ql-thin" x1="2.5" x2="4.5" y1="5.5" y2="5.5"></line> 
                                    <path class="ql-fill" d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z"></path> 
                                    <path class="ql-stroke ql-thin" d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156"></path> 
                                    <path class="ql-stroke ql-thin" d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109"></path>
                                </svg>
                            </button>
                            <button class="ql-list" value="bullet" type="button">
                                <svg viewBox="0 0 18 18"> 
                                    <line class="ql-stroke" x1="6" x2="15" y1="4" y2="4"></line> 
                                    <line class="ql-stroke" x1="6" x2="15" y1="9" y2="9"></line> 
                                    <line class="ql-stroke" x1="6" x2="15" y1="14" y2="14"></line> <line class="ql-stroke" x1="3" x2="3" y1="4" y2="4"></line> <line class="ql-stroke" x1="3" x2="3" y1="9" y2="9"></line> 
                                    <line class="ql-stroke" x1="3" x2="3" y1="14" y2="14"></line> 
                                </svg>
                            </button>
                        </span>
                    </div>
                    <div id="editorUpdateDescription" class="quill-area" style="min-height:50px;">{!! $task->description !!}</div>
                    <textarea name="updateDescription" id="updateDescription" class="hide">{!! $task->description !!}</textarea>
                    <p id="errorUpdateDescription" class="error invalid-feedback"></p> 
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnTitleSave" type="button" class="btn btn-primary">Guardar cambio</button>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('/assets/admin/js/quilljs/quill.css') }}" rel="stylesheet">
<script src="{{ asset('/assets/admin/js/quilljs/quill.js') }}"></script>
<script src="{{asset('/assets/admin/js/mieditor.js')}}"></script>
<script>
    document.querySelector('#btnTitleSave').addEventListener('click', handleTitleSave);
    var editorUpdateDescription = new MeEditor({
        toolbar: '#toolbarUpdateDescription',
        placeholder: 'Añade detalles sobre la tarea...',
        editor: '#editorUpdateDescription',
        textarea: '#updateDescription'
    });

    let urlUpdateTitle = "{{ route('task.api.edit.title', ['task' => $task->id]) }}";
    function handleTitleSave(){
        document.querySelector('#btnTitleSave').disabled = true;
        let updateTitle = document.querySelector('#updateTitle').value;
        let updateDescription = document.querySelector('#updateDescription').value;

        fetch(urlUpdateTitle, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'title': updateTitle,
                'description': updateDescription
            })
        }).then(response => response.json())
        .then(data => {
            document.querySelector('#btnTitleSave').disabled = false;
            if( data.success ){
                handleResponseTitle(data.data);
            }
        });
    }
    
    function handleResponseTitle(data){
        let title = data.title;
        let description = data.description;

        if( description == null ){
            description = 'S/N';
        }

        document.querySelector('#modelTitle').innerHTML = title;
        document.querySelector('#modelDescription').innerHTML = description;
        
        $('#titleModal').modal('hide');
    }
</script>
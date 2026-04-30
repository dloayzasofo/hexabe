<div class="modal fade hide" id="userModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar responsable</h5>
                    <p>Seleccione la persona responsable de la tarea</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row gy-3 custom-col-3">
                        <div class="col-md">
                            <div class="form-check custom-option custom-option-icon checked">
                                <label class="form-check-label custom-option-content" for="updateUser{{ $task->assign->id }}">
                                    <span class="custom-option-body">
                                        <div class="avatar avatar-xl mx-auto">
                                            @if( $task->assign->image != null )
                                            <img src="{{ $task->assign->image }}" alt="{{ $task->assign->name }}" class="rounded-circle">
                                            @else
                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ $task->assign->nameInitial }}</span>
                                            @endif
                                        </div>
                                        <span class="custom-option-title mb-1 mt-2"> {{ $task->assign->name }} <br> {{ $task->assign->last_name }}</span>
                                    </span>
                                    <input name="updateUser" class="form-check-input" type="radio" value="{{ $task->assign->id }}" id="updateUser{{ $task->assign->id }}" checked>
                                </label>
                            </div>
                        </div>
                        
                        @if( $task->user->id != $task->assign->id )
                        <div class="col-md">
                            <div class="form-check custom-option custom-option-icon">
                                <label class="form-check-label custom-option-content" for="updateUser{{ $task->user->id }}">
                                    <span class="custom-option-body">
                                        <div class="avatar avatar-xl mx-auto">
                                            @if( $task->user->image != null )
                                            <img src="{{ $task->user->image }}" alt="{{ $task->user->name }}" class="rounded-circle">
                                            @else
                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ $task->user->nameInitial }}</span>
                                            @endif
                                        </div>
                                        <span class="custom-option-title mb-1 mt-2"> {{ $task->user->name }} <br> {{ $task->user->last_name }}</span>
                                    </span>
                                    <input name="updateUser" class="form-check-input" type="radio" value="{{ $task->user->id }}" id="updateUser{{ $task->user->id }}">
                                </label>
                            </div>
                        </div>
                        @endif

                        @foreach($taskCollaboratos as $collaborator)
                            @if( $collaborator->user->id == $task->user->id || $collaborator->user->id == $task->assign->id ) @continue @endif
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="updateUser{{ $collaborator->user->id }}">
                                        <span class="custom-option-body">
                                            <div class="avatar avatar-xl mx-auto">
                                                @if( $collaborator->user->image != null )
                                                    <img src="{{ $collaborator->user->image }}" alt="{{ $collaborator->user->name }}" class="rounded-circle">
                                                @else
                                                    <span class="avatar-initial rounded-circle bg-label-primary">{{ $collaborator->user->nameInitial }}</span>
                                                @endif
                                            </div>
                                            <span class="custom-option-title mb-1 mt-2"> {{ $collaborator->user->name }} <br> {{ $collaborator->user->last_name }}</span>
                                        </span>
                                        <input name="updateUser" class="form-check-input" type="radio" value="{{ $collaborator->user->id }}" id="updateUser{{ $collaborator->user->id }}">
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnUserSave" type="button" class="btn btn-primary">Guardar cambio</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.form-check-label').forEach((element) => {
        element.addEventListener('click', handleClickCheckLabel);
    });

    function handleClickCheckLabel(){
        document.querySelectorAll('.form-check-label').forEach((element) => {
            element.parentNode.classList.remove('checked');
        });

        this.parentNode.classList.add('checked');
    }

    document.querySelector('#btnUserSave').addEventListener('click', handleBrandSave);

    let urlUpdateUser = "{{ route('task.api.edit.user', ['task' => $task->id]) }}";
    function handleBrandSave(){
        document.querySelector('#btnUserSave').disabled = true;
        let user_id = document.querySelector('input[name="updateUser"]:checked').value;

        fetch(urlUpdateUser, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_id: user_id
            })
        }).then(response => response.json())
        .then(data => {
            console.log(data);
            document.querySelector('#btnUserSave').disabled = false;
            if( data.success ){
                handleResponseUser(data.data);
            }
        });
    }
    
    function handleResponseUser(data){
        let assignImage = document.querySelector('#assignImage');
        let assignUrl = document.querySelector('#assignUrl');
        let assignName = document.querySelector('#assignName');

        if( data.image == null ){
            assignImage.innerHTML = `<span class="avatar-initial rounded-circle bg-label-danger">${ data.nameInitial }</span>`;
        }else{
            assignImage.innerHTML = `<img src="${ data.image }" alt="Avatar" class="rounded-2">`;
        }

        assignUrl.href = "/task/staff/list/" + data.id;
        assignName.innerHTML = data.name; // + ' ' + data.last_name;

        $('#userModal').modal('hide');
    }
</script>
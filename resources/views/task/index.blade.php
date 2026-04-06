@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold"> Mis tareas </h4>
        </div>
        <div class="col-sm-4 col-md-6">
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> 
                    <button id="btnCreate" class="dt-button create-new btn btn-primary">
                        <span><i class="bx bx-plus me-sm-2"></i> 
                            <span class="d-none d-sm-inline-block">Agregar equipo</span>
                        </span>
                    </button> 
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('task.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('task.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="task-list-item task-list-header d-flex no-wrap">
        <div>
            TAREAS
        </div>
        <div>
            PRIORIDAD
        </div>
        <div>
            PROGRESO
        </div>
        <div>
            EQUIPO
        </div>
        <div>
            <i class="bx bx-paperclip"></i>
        </div>
        <div>
            <i class="bx bx-message"></i>
        </div>
        <div>
            FECHA
        </div>
        <div></div>
    </div>

    @foreach($tasks as $task)
    <div class="task-list-item d-flex no-wrap">
        <div class="d-flex justify-content-start align-items-center user-name">
            <div class="avatar-wrapper">
                <div class="avatar avatar-sm me-2">
                    <img src="{{ $task->brand->image }}" alt="Avatar" class="rounded">
                </div>
            </div>
            <div class="d-flex flex-column">
                <a href="{{ route('task.view', ['task'=> $task]) }}" class="text-heading text-truncate">
                    <span class="fw-medium">{{ $task->title }}</span>
                </a>
                <small>{{ strtoupper($task->brand->name) }}</small>
            </div>
        </div>  

        <div>
            @if( $task->priority == 'high' )
            <span class="badge rounded-pill bg-label-danger">ALTA</span>
            @endif
            @if( $task->priority == 'medium' )
            <span class="badge rounded-pill bg-label-warning">MEDIA</span>
            @endif
            @if( $task->priority == 'low' )
            <span class="badge rounded-pill bg-label-primary">BAJA</span>
            @endif
        </div>

        <div>
            <div>
                <div class="d-flex justify-content-between mb-1">
                    <div>
                        Subtareas
                    </div>
                    <div class="text-primary fw-bold">
                        4/5
                    </div>
                </div>
                <div>
                    <div class="progress" style="height: 16px;">
                        <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                            50%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="d-flex flex-wrap align-items-center">
                <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">

                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="{{ $task->assign->name }}" data-bs-original-title="{{ $task->assign->name }}">
                        <img class="rounded-circle" src="{{ $task->assign->image }}" alt="{{ $task->assign->name }}">
                    </li>

                    @foreach($task->collaborators as $index => $collaborator)
                        @if( $index >= 2)
                            @break
                        @endif

                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="{{ $collaborator->user->name }}" data-bs-original-title="{{ $collaborator->user->name }}">
                            <img class="rounded-circle" src="{{ $collaborator->user->image }}" alt="{{ $collaborator->user->name }}">
                        </li>
                    @endforeach

                    @if( $task->collaborators_count >= 3 )
                        <li class="avatar">
                            <span class="avatar-initial rounded-circle pull-up text-heading" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="bottom" 
                                data-bs-original-title="{{ 3 - $task->collaborators_count }} más">
                                +{{ 3 - $task->collaborators_count }}
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div> {{ $task->medias_count == 0 ? '-' : $task->medias_count }} </div>
        <div> - </div>
        <div> {{ $task->register_at}} </div>
        <div>
            <div class="dropdown">
                <button class="btn text-body-secondary p-0" type="button" id="timelineWapper" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper" style="">
                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach


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
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<script>
    let mode = null;
    let urlCreate = "{{ route('task.create') }}";
    let myDropzone = null;

    window.addEventListener('load', () => {
        document.querySelector('#btnCreate').addEventListener('click', handleBtnCreate);
        /*
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btnSave')) {
                handleCreateServer();
            }
        });

        let teamItems = document.querySelectorAll('.team-item');
        teamItems.forEach(teamItem => {
            teamItem.addEventListener('click', handleEdit);
        });
        */
    });

    function handleBtnCreate(){
        fetch(urlCreate)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#popup').innerHTML = data;
            document.querySelector('#modalTitle').innerHTML = 'Crear nuevo equipo';
            document.querySelector('#modalDescription').innerHTML = 'Define un equipo para centralizar tareas y seguimiento.';
            $('#modalCenter').modal('show');
            //setupMemberSearch();
            mode = 'CREATE';
            //var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
            //bindSearchInputAjax();

            myDropzone = new Dropzone("#task-files", { 
                url: "/media/upload", 
                addRemoveLinks: true,
                dictDefaultMessage: '<svg width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.875 20C4.97917 20 3.35938 19.3438 2.01562 18.0312C0.671875 16.7188 0 15.1146 0 13.2188C0 11.5938 0.489583 10.1458 1.46875 8.875C2.44792 7.60417 3.72917 6.79167 5.3125 6.4375C5.83333 4.52083 6.875 2.96875 8.4375 1.78125C10 0.59375 11.7708 0 13.75 0C16.1875 0 18.2552 0.848959 19.9531 2.54688C21.651 4.24479 22.5 6.3125 22.5 8.75C23.9375 8.91667 25.1302 9.53646 26.0781 10.6094C27.026 11.6823 27.5 12.9375 27.5 14.375C27.5 15.9375 26.9531 17.2656 25.8594 18.3594C24.7656 19.4531 23.4375 20 21.875 20H15C14.3125 20 13.724 19.7552 13.2344 19.2656C12.7448 18.776 12.5 18.1875 12.5 17.5V11.0625L10.5 13L8.75 11.25L13.75 6.25L18.75 11.25L17 13L15 11.0625V17.5H21.875C22.75 17.5 23.4896 17.1979 24.0938 16.5938C24.6979 15.9896 25 15.25 25 14.375C25 13.5 24.6979 12.7604 24.0938 12.1562C23.4896 11.5521 22.75 11.25 21.875 11.25H20V8.75C20 7.02083 19.3906 5.54688 18.1719 4.32812C16.9531 3.10938 15.4792 2.5 13.75 2.5C12.0208 2.5 10.5469 3.10938 9.32812 4.32812C8.10938 5.54688 7.5 7.02083 7.5 8.75H6.875C5.66667 8.75 4.63542 9.17708 3.78125 10.0312C2.92708 10.8854 2.5 11.9167 2.5 13.125C2.5 14.3333 2.92708 15.3646 3.78125 16.2188C4.63542 17.0729 5.66667 17.5 6.875 17.5H10V20H6.875Z" fill="#94A3B8"/></svg><br><b>Arrastra tus archivos aquí</b> o haz clic para subir', // Change the main text
                dictRemoveFile: "Eliminar", 
                init: dropzoneInitHandle
            });
        });
    }
</script>

<script>
    

    function dropzoneInitHandle(){
        this.on("removedfile", function(file) {
            console.log(file); 
            // Check if the file has been successfully uploaded and has a server-side identifier
            if (file.id) { // Use the identifier you store in the success callback
                // Perform an AJAX request to delete the file from the server
                $.ajax({
                    type: "POST",
                    url: "/media/delete", // Replace with your server-side deletion script URL
                    data: { id: file.id }, // Pass the file identifier
                    success: function(response) {
                        console.log(response); // Log the server response
                    }
                });
            }
        });

        // You also need to capture the server file name/ID during the success event
        this.on("success", function(file, responseText) {
             // Assuming your server returns the file name or ID in the response
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
    //myDropzone.on("complete", function(file) {
    //    myDropzone.removeFile(file);
    //});
</script>

<script>
    // let urlSearchUser,urlSearchByKey : define in header layout
    window.addEventListener('load', () => {
        document.addEventListener('keydown', (e) => {
            if (e.target.classList.contains('task-input-responsable')) {
                if( e.target.value.length <= 2){
                    document.querySelector('.task-responsable-result').classList.remove('active');
                    return;
                }
                searchByKeyPress(e.target.value);
            }

            if (e.target.classList.contains('task-input-member')) {
                if( e.target.value.length <= 2){
                    document.querySelector('.task-members-result').classList.remove('active');
                    return;
                }
                searchMemeberKeyPress(e.target.value);
            }

        });

        document.addEventListener('click', (e) => {
            if( e.target.closest('.add-member') ){
            //if( e.target.classList.contains('add-member') ){
                document.querySelector('.memebers-ajax').classList.toggle('hide');
            }
            
            if( e.target.classList.contains('btnSaveTask') ){
                handleCreateTask();
            }
        });
    });

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

    function handlerRenderUserByKey(data){
        let result = document.querySelector('.task-responsable-result');
        let inputMemeber = document.querySelector('#task-input-responsable');
        //const selectedMembers = document.querySelector('#selectedMembers');

        result.innerHTML = '';
        if( data.length == 0 ){
            result.classList.remove('active');
            return;
        }

        data.forEach(user => {
            const existing = null; //selectedMembers.querySelector('input[value="' + user.id + '"]');
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

    function addSelectedResponsable(user){
        let avatar = document.querySelector('#task-responsable-avatar');
        let responsable = document.querySelector('#user_assign');
        let email = document.querySelector('#task-input-responsable');

        if (!responsable) return;

        const existing = responsable.value == user.id;
        if (existing) {
            //document.querySelector('#errorMembers').innerHTML = 'Usuario ya está agregado';
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

    function addSelectedMember(user){
        let responsable = document.querySelector('#user_assign');
        let selectedMembers = document.querySelector('#selected-members');

        if (!responsable) return;

        const existing = selectedMembers.querySelector('input[value="' + user.id + '"]');
        if (existing) {
            //document.querySelector('#errorMembers').innerHTML = 'Usuario ya está agregado';
            return;
        }


        let avatar = '';
        if( user.image ) {
            avatar = '<img src="' + user.image + '" class="avatar rounded-circle"/> ';
        }else{
            avatar = '<span class="avatar-initial rounded-circle bg-label-primary">' + user.initials + '</span> ';
        }
        /*
        let html = `<li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="${ user.name }" data-bs-original-title="${ user.name }">
                ${avatar}
            </li>`;
        */
        
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
        //let status = document.querySelector('#status');

        var data = new FormData();
        data.append('_token', token.value);
        data.append('name', name.value);
        data.append('description', description ? description.value : '');
        data.append('priority', priority.value);
        data.append('date_delivery', date_delivery.value);
        data.append('brand', brand.value);
        data.append('user_assign', user_assign.value);
        //data.append('status', status.value);
        
        const mediaInputs = document.querySelectorAll('input[name="medias[]"]');
        mediaInputs.forEach((input) => {
            data.append('medias[]', input.value);
        });

        const memberInputs = document.querySelectorAll('input[name="members[]"]');
        memberInputs.forEach((input) => {
            data.append('members[]', input.value);
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
                //location.reload();
                location.href = "/task/view/" + data.data.id;
            }
            if( data.errors){
                handleShowErrors(data.errors);
            }
        });
    }

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

        /*
        const memberInputs = document.querySelectorAll('input[name="members[]"]');
        if( memberInputs.length == 0){
            document.querySelector('#selectedMembers').classList.add('is-invalid');
            document.querySelector('#errorMembers').innerHTML = 'Ingresa almenos un miembro al equipo';
            isOk = false;
        }
        */

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

    function clearTaskErrors(){
        const fields = ['name', 'description', 'members'];
        fields.forEach((field) => {
            const el = document.querySelector('#' + field);
            if (el) el.classList.remove('is-invalid');
            const err = document.querySelector('#error' + field.charAt(0).toUpperCase() + field.slice(1));
            if (err) err.innerHTML = '';
        });
    }

    function showTaskError(elementName, error){
        const el = document.querySelector('#' + elementName);
        if (el) el.classList.add('is-invalid');
        const label = elementName.charAt(0).toUpperCase() + elementName.slice(1);
        const err = document.querySelector('#error' + label);
        if (err) err.innerHTML = error;
    }
</script>

@endsection
let mode = null;
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

/**
 * Eventos del formulario de creacipon de tarea,
 * para buscar responsable y miembros
 * crear tarea enviando datos por fetch a controlador y mostrar errores de validacion 
 */
window.addEventListener('load', () => {
    document.addEventListener('input', (e) => {
        if (e.target.classList.contains('task-input-responsable')) {
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
        if( e.target.classList.contains('colaborator-close') ){
            handleRemoveColaborator(e);
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
    console.log(data);
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
    avatar += '<button type="button" class="btn-close remove-member colaborator-close" aria-label="Remove"></button>';
    
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
    document.querySelector('.btnSaveTask').disabled = true;
    let form = document.querySelector('#formCreateTask');

    if( validateFormTaskCreate() == false ){
        document.querySelector('.btnSaveTask').disabled = false;
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

    var data = new FormData();
    data.append('_token', token.value);
    data.append('name', name.value);
    data.append('description', description ? description.value : '');
    data.append('priority', priority.value);
    data.append('date_delivery', date_delivery.value);
    data.append('brand', brand.value);
    data.append('user_assign', user_assign.value);

    let parent_id = document.querySelector('#parent_id');
    if( parent_id){
        data.append('parent_id', parent_id.value);
    }
    
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
    let element = e.target.closest('.avatar');
    if( element ){
        element.remove();
    }
}

/**
 * Remover colaborador
 * Eliminar el colaborador que se agrego
 */
function handleRemoveColaborator(e){
    console.log(e.target);
    let element = e.target;
    let parent = element.parentNode;

    let tooltipId = parent.getAttribute('aria-describedby');
    console.log(tooltipId);
    if( tooltipId ){
        document.querySelector('#' + tooltipId).remove();
    }

    parent.remove();
}
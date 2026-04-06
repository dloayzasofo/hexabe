@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold"> Equipos </h4>
            <p>Define equipos y mejora la forma en que se ejecuta el trabajo.</p>
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

    @if(Session::has('team.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('team.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="row sm-vl-base">
        @foreach($teams as $team)
        <div class="col-lg-3 mb-4" @if($team->status=='DEACTIVE') style="opacity:.35;" @endif>
            <div class="card">
                <a href="{{ route('team.view', [$team]) }}">
                    <img class="card-img-top object-fit-cover" src="{{ asset($team->image) }}" alt="Card image cap" style="max-height:195px;">
                </a>

                <div class="card-body">
                    <h5 class="card-title fw-bold" style="margin-bottom:4px;">
                        {{--<div data-href="{{ route('team.view', [$team]) }}" class="team-item">--}}
                        <div data-href="{{ route('team.edit', [$team]) }}" class="team-item">
                            {{ $team->name }}
                        </div>
                    </h5>
                    <p class="card-text"><small>12 tareas pendientes</small></p>

                    <div class="row mb-1">
                        <div class="col-md-6">
                            <small>Progreso</small>
                        </div>
                        <div class="col-md-6 fw-bold text-end">
                            <small style="color:#0052CC;">68%</small>
                        </div>
                    </div>

                    <div class="progress" style="height: 8px;margin: auto;padding:0px;">
                        <div class="progress-bar" role="progressbar" style="width: 68%;background:#0052CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <ul class="list-unstyled m-0 avatar-group d-flex align-items-center mt-4">
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-s pull-up" aria-label="Lilian Fuller" data-bs-original-title="Lilian Fuller">
                            <img src="{{ asset('/assets/img/2.png') }}" alt="Avatar" class="rounded-circle">
                        </li>
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-s pull-up" aria-label="Sophia Wilkerson" data-bs-original-title="Sophia Wilkerson">
                            <img src="{{ asset('/assets/img/3.png') }}" alt="Avatar" class="rounded-circle">
                        </li>
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-s pull-up" aria-label="Christina Parker" data-bs-original-title="Christina Parker">
                            <img src="{{ asset('/assets/img/4.png') }}" alt="Avatar" class="rounded-circle">
                        </li>
                        <li class="avatar">
                            <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="3 more">+3</span>
                        </li>
                        <li class="avatar">
                            <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="3 more">0</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
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
<script src="{{asset('/assets/admin/js/dropzone.js')}}"></script>

<script>
    /*
    window.addEventListener('load', () => {
        document.addEventListener('keydown', (e) => {
            if (e.target.classList.contains('input-user-search')) {
                if( e.target.value.length <= 2){
                    document.querySelector('.input-search-result').classList.remove('active');
                    return;
                }
                searchByKeyPress(e.target.value);
            }
        });
    });

    function setupMemberSearch(){
        const searchInput = document.querySelector('#memberSearchInput');
        const searchButton = document.querySelector('#memberSearchButton');
        const selectedMembers = document.querySelector('#selectedMembers');
        const searchError = document.querySelector('#errorMembers');

        if (!searchInput || !searchButton || !selectedMembers) return;

        searchButton.addEventListener('click', () => {
            const email = searchInput.value.trim();
            if (!email) {
                searchError.innerHTML = 'Ingresa un email para buscar.';
                return;
            }
            searchError.innerHTML = '';
            fetch(urlSearchUser + '?q=' + encodeURIComponent(email), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    selectedMembers.classList.add('is-invalid');
                    searchError.innerHTML = data.message || 'Usuario no encontrado';
                    return;
                }
                addSelectedMember(data.user);
            })
            .catch(() => {
                selectedMembers.classList.add('is-invalid');
                searchError.innerHTML = 'Error al buscar usuario';
            });
        });

        searchInput.addEventListener('keydown', (evt) => {
            if (evt.key === 'Enter') {
                evt.preventDefault();
                searchButton.click();
            }

            document.querySelector('#selectedMembers').classList.remove('is-invalid');
        });

        selectedMembers.addEventListener('click', (evt) => {
            const btn = evt.target.closest('.remove-member');
            if (!btn) return;
            const pill = btn.closest('.selected-member-pill');
            if (pill) pill.remove();
        });
    }

    function addSelectedMember(user){
        const selectedMembers = document.querySelector('#selectedMembers');
        if (!selectedMembers) return;

        const existing = selectedMembers.querySelector('input[value="' + user.id + '"]');
        if (existing) {
            document.querySelector('#errorMembers').innerHTML = 'Usuario ya está agregado';
            return;
        }

        const pill = document.createElement('span');
    
        let avatar = '';
        if( user.image ) {
            avatar = '<img src="' + user.image + '" /> ' + user.email;
        }else{
            avatar = '<span>' + user.initials + '</span> ' + user.email;
        }

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
    }

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
        let result = document.querySelector('.input-search-result');
        let inputMemeber = document.querySelector('#memberSearchInput');
        const selectedMembers = document.querySelector('#selectedMembers');

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
                    div.innerHTML = '<img src="' + user.image + '" /> ' + user.email;
                }else{
                    div.innerHTML = '<span>' + user.initials + '</span> ' + user.email;
                }

                div.classList.add('input-search-result-item');
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
    */
</script>

<script>
    let mode = null;
    let urlCreate = "{{ route('team.create') }}";

    window.addEventListener('load', () => {
        document.querySelector('#btnCreate').addEventListener('click', handleBtnCreate);
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btnSave')) {
                handleCreateServer();
            }
        });

        let teamItems = document.querySelectorAll('.team-item');
        teamItems.forEach(teamItem => {
            teamItem.addEventListener('click', handleEdit);
        });
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
            var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
            bindSearchInputAjax();
        });
    }

    function handleCreateServer(){
        let form = document.querySelector('#formCreate');

        let url = form.getAttribute('data-action');
        let token = document.getElementsByName("_token")[0];
        let name = document.querySelector('#name');
        let description = document.querySelector('#description');
        let status = document.querySelector('#status');

        if( validateForm() == false ){
            return false;
        }

        var data = new FormData();
        data.append('_token', token.value);
        data.append('name', name ? name.value : '');
        data.append('description', description ? description.value : '');
        data.append('status', status ? status.value : '0');
        if( image.files.length > 0 ){
            data.append('image', image.files[0]);
        }

        const memberInputs = document.querySelectorAll('input[name="members[]"]');
        memberInputs.forEach((input) => {
            data.append('members[]', input.value);
        });
        const brandInputs = document.querySelectorAll('input[name="brands[]"]');
        brandInputs.forEach((input) => {
            data.append('brands[]', input.value);
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
            }
            if( data.errors){
                handleShowErrors(data.errors);
            }
        });
    }

    function handleShowErrors(errors){
        if( errors.name ){
            showError('name', errors.name[0]);
        }
        if( errors.description ){
            showError('description', errors.description[0]);
        }
        if( errors.members ){
            showError('members', errors.members[0]);
        }
    }

    function validateForm(){
        clearErrors();

        let name = document.querySelector('#name');
        let isOk = true;

        if( !name || !name.value ){
            showError('name', 'El campo es requerido');
            isOk = false;
        }

        const memberInputs = document.querySelectorAll('input[name="members[]"]');
        if( memberInputs.length == 0){
            document.querySelector('#selectedMembers').classList.add('is-invalid');
            document.querySelector('#errorMembers').innerHTML = 'Ingresa almenos un miembro al equipo';
            isOk = false;
        }

        if( mode == 'CREATE' && !image.value ){
            showError('image', 'El campo es requerido');
            isOk = false;
        }else{
            if( image.files.length > 0 ){
                const sizeInBytes = image.files[0].size;
                const sizeInMB = (sizeInBytes / (1024 * 1024)).toFixed(2);
                if( sizeInMB > 1 ){
                    showError('image', 'El peso del archivo debe ser menor a 1MB');
                    isOk = false;
                }
            }
        }

        return isOk;
    }

    function clearErrors(){
        const fields = ['name', 'description', 'members'];
        fields.forEach((field) => {
            const el = document.querySelector('#' + field);
            if (el) el.classList.remove('is-invalid');
            const err = document.querySelector('#error' + field.charAt(0).toUpperCase() + field.slice(1));
            if (err) err.innerHTML = '';
        });
    }

    function showError(elementName, error){
        const el = document.querySelector('#' + elementName);
        if (el) el.classList.add('is-invalid');
        const label = elementName.charAt(0).toUpperCase() + elementName.slice(1);
        const err = document.querySelector('#error' + label);
        if (err) err.innerHTML = error;
    }

    function handleEdit(){
        let url = this.getAttribute('data-href');
        fetch(url)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#popup').innerHTML = data;
            document.querySelector('#modalTitle').innerHTML = 'Actualizar equipo';
            document.querySelector('#modalDescription').innerHTML = 'Define un equipo para centralizar tareas y seguimiento.';
            $('#modalCenter').modal('show');
            mode = 'EDIT';
            //setupMemberSearch();
            var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
            bindSearchInputAjax();
        });
    }
</script>

<script>
    window.addEventListener('load', () => {
        let searchServers = document.querySelectorAll('.serverSearch');
        searchServers.forEach(searchServer => {
            bindElementeToServerSearch(searchServer);
        });
    });

    function bindSearchInputAjax(){
        let searchServers = document.querySelectorAll('.serverSearch');
        searchServers.forEach(searchServer => {
            bindElementeToServerSearch(searchServer);
        });
    }

    function bindElementeToServerSearch(element){
        let preview = element.querySelector('.previewItems');
        let inputSearch = element.querySelector('.inputSearch');
        let resultItems = element.querySelector('.resultItems');
        let urlSearch = element.getAttribute('data-href');
        let type = element.getAttribute('data-type');

        inputSearch.addEventListener('keydown', (e) => {
            console.log('urlSearch');
            if (e.target.value.length < 2){
                resultItems.classList.remove('active');
                return;
            }
            searchServerByKey(e.target.value);
        });

        function searchServerByKey(value){
            fetch(urlSearch + '?q=' + value, {
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
                handlerRenderServerByKey(data.data);
            })
            .catch((e) => {
                console.log("Error Catch", e);
            });
        }

        function handlerRenderServerByKey(data){
            preview.innerHTML = '';
            if( data.length == 0 ){
                preview.classList.remove('active');
                return;
            }

            data.forEach(model => {
                const existing = resultItems.querySelector('input[value="' + model.id + '"]');
                if ( existing == null ) {
                    let div = document.createElement('div');
                    
                    if( model.image ) {
                        div.innerHTML = '<img src="' + model.image + '" class="avatar avatar-xs rounded-circle"/> ' + model.name;
                    }else{
                        div.innerHTML = '<span>' + model.initials + '</span> ' + model.name;
                    }

                    div.classList.add('input-search-result-item');
                    div.addEventListener('click', () => {
                        addSelectedServerItem(model);
                        preview.classList.remove('active');
                        inputSearch.value = '';
                    });
                    preview.appendChild(div);
                }
            });

            if( preview.innerHTML != '' ){
                preview.classList.add('active');
            }
        }

        function addSelectedServerItem(model){
            if (!resultItems) return;

            const existing = resultItems.querySelector('input[value="' + model.id + '"]');
            if (existing) {
                return;
            }

            const pill = document.createElement('span');
        
            let avatar = '';
            if( model.image ) {
                avatar = '<img src="' + model.image + '" class="avatar avatar-xs rounded-circle"/> ' + model.name;
            }else{
                avatar = '<span>' + model.initials + '</span> ' + model.name;
            }

            pill.className = 'badge rounded-pill selected-member-pill';
            pill.style.display = 'inline-flex';
            pill.style.alignItems = 'center';
            pill.style.gap = '0.3rem';
            pill.innerHTML = `${avatar} <button type="button" class="btn-close remove-member" aria-label="Remove"></button>`;

            const inputHidden = document.createElement('input');
            inputHidden.type = 'hidden';
            inputHidden.name = type + '[]';
            inputHidden.value = model.id;
            pill.appendChild(inputHidden);

            resultItems.appendChild(pill);
        }
        
        resultItems.addEventListener('click', (evt) => {
            const btn = evt.target.closest('.remove-member');
            if (!btn) return;
            const pill = btn.closest('.selected-member-pill');
            if (pill) pill.remove();
        });
    }
    
</script>
@endsection
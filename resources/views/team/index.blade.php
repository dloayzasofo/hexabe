@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold"> Equipos </h4>
            <p>Lorem ipsum dolor sit amet consectetur. Dignissim id purus</p>
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

    <script type="module">
        import { Editor } from 'https://esm.sh/@tiptap/core'
        import StarterKit from 'https://esm.sh/@tiptap/starter-kit'

        import Document from 'https://esm.sh/@tiptap/extension-document'
        import Paragraph from 'https://esm.sh/@tiptap/extension-paragraph'
        import Text from 'https://esm.sh/@tiptap/extension-text'

        new Editor({
            // bind Tiptap to the `.element`
            element: document.querySelector('.element'),
            // register extensions
            extensions: [Document, Paragraph, Text],
            // set the initial content
            content: '<p>Example Text</p>',
            // place the cursor in the editor after initialization
            autofocus: true,
            // make the text editable (default is true)
            editable: true,
            // prevent loading the default ProseMirror CSS that comes with Tiptap
            // should be kept as `true` for most cases as it includes styles
            // important for Tiptap to work correctly
            injectCSS: false,
        })

    </script>

    <div class="element"></div>

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
                <div id="popup">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('/assets/admin/js/dropzone.js')}}"></script>
<script>
    let mode = null;
    let urlCreate = "{{ route('team.create') }}";
    window.addEventListener('load', () => {
        document.querySelector('#btnCreate').addEventListener('click', handleCreate);
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btnSaveteam')) {
                handleCreateteam();
            }
        });

        let teamItems = document.querySelectorAll('.team-item');
        teamItems.forEach(teamItem => {
            teamItem.addEventListener('click', handleEdit);
        });
    });

    function handleCreate(){
        fetch(urlCreate)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#popup').innerHTML = data;
            document.querySelector('#modalTitle').innerHTML = 'Crear nuevo equipo';
            document.querySelector('#modalDescription').innerHTML = 'Define un equipo para centralizar tareas y seguimiento.';
            $('#modalCenter').modal('show');
            var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
        });
    }

    function handleCreateteam(){
        let form = document.querySelector('#formteamCreate');
        let url = form.getAttribute('data-action');

        let name = document.querySelector('#name');
        let token = document.getElementsByName("_token")[0];
        let description = document.querySelector('#description');
        let status = document.querySelector('#status');

        var data = new FormData()
        data.append('_token', token.value);
        data.append('name', name.value);
        data.append('description', description.value);
        data.append('status', status.value);

        if( validateForm() == false ){
            return false;
        }

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
    }

    function validateForm(){
        clearErrors();

        let name = document.querySelector('#name');
        let description = document.querySelector('#description');
        let isOk = true;

        if( !name.value ){
            showError('name', 'El campo es requerido');
            isOk = false;
        }

        if( !industry.value ){
            showError('industry', 'El campo es requerido');
            isOk = false;
        }

        //if( !description.value ){
        //    showError('description', 'El campo es requerido');
        //    isOk = false;
        //}

        return isOk;
    }

    function clearErrors(){
        document.querySelector('#name').classList.remove('is-invalid');
        document.querySelector('#description').classList.remove('is-invalid');

        document.querySelector('#errorName').innerHTML = '';
        document.querySelector('#errorDescription').innerHTML = '';
    }

    function showError(elementName, error){
        document.querySelector('#' + elementName).classList.add('is-invalid');
        elementName = elementName.charAt(0).toUpperCase() + elementName.slice(1);
        document.querySelector('#error' + elementName).innerHTML = error;
    }

    function handleEdit(){
        console.log("Edit BRnad");
        let url = this.getAttribute('data-href');
        console.log(url);
        fetch(url)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#popup').innerHTML = data;
            document.querySelector('#modalTitle').innerHTML = 'Actualizar equipo';
            document.querySelector('#modalDescription').innerHTML = 'Define un equipo para centralizar tareas y seguimiento.';
            $('#modalCenter').modal('show');
            mode = 'EDIT';
            var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
        });
    }
</script>
@endsection
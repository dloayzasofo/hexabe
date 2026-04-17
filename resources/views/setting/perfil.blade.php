@extends('layout')

@section('main')
    

    <form action="{{ route('setting.perfil.save') }}" method="post">
        @csrf
        <div class="row" style="max-width:680px;margin:auto;">
            <div class="messages" style="padding:0px;">
                @if(Session::has('setting.perfil.success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ Session::get('setting.perfil.success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
                @endif
            </div>

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('setting.perfil.index') }}" class="nav-link active fw-bold">
                    Perfil
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('setting.notification.index') }}" class="nav-link">
                    Notificaciones
                    </a>
                </li>
            </ul>

            <div class="card mb-5 mt-5">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="pe-4">
                            <div class="perfil-picture">
                                <div class="wrap-user-picture">
                                    @if( $user->image != null )
                                        <img id="user-picture" src="{{ $user->image }}">
                                    @else
                                        <img id="user-picture" src="{{ asset('assets/img/perfil-default.jpg') }}">
                                    @endif
                                </div>
                                <input id="input-picture" type="file" accept="image/*" class="hide">
                                <button type="button" class="btn rounded-pill btn-icon btn-warning upload-picture">
                                    <i class="bx bx-camera"></i>
                                </button>
                               
                            </div>
                        </div>
                        <div>
                            <h5 class="fw-bold">Foto de perfil</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus qui eveniet. </p>
                            <div class="d-flex">
                                <button type="button" class="btn btn-warning me-3 upload-picture">
                                    <i class="bx bx-upload me-2"></i> Subir Nueva Foto
                                </button>
                                <button type="button" class="btn btn-label-secondary remove-picture">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Nombre</label>
                                <input type="text" name="name" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Apellidos</label>
                                <input type="text" name="last_name" class="form-control" id="basic-default-fullname" placeholder="John Doe" value="{{ $user->last_name }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" id="basic-default-fullname" placeholder="ejemplo@correo.com" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Nombre del Puesto/Cargo</label>
                                <input type="text" name="position" class="form-control" id="basic-default-fullname" placeholder="Marketing" value="{{ $user->position }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4 pe-0">
                <button type="reset" class="btn btn-label-secondary me-sm-3">Cancelar</button>
                <button type="submit" class="btn btn-primary  me-1">Guardar Cambios</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script>
    let urlUploadPicture = "{{ route('setting.perfil.image.upload') }}";
    let urlRemovePicture = "{{ route('setting.perfil.image.remove') }}";

    window.addEventListener('load', () => {
        let btnsUploadPicture = document.querySelectorAll('.upload-picture');
        btnsUploadPicture.forEach(btn => {
            btn.addEventListener('click', handleUploadPicture);
        });

        let inputPicture = document.querySelector('#input-picture');
        inputPicture.addEventListener('change', handleChangePicture, false);

        let btnRemovePicture = document.querySelector('.remove-picture');
        btnRemovePicture.addEventListener('click', handleRemovePicture);
    });

    function handleUploadPicture(){
        let inputPicture = document.querySelector('#input-picture');
        inputPicture.click();
    }

    function handleChangePicture(event){
        const fileList = event.target.files;
        const file = fileList[0];
        const imgPreview = document.querySelector('#user-picture');

        if( file ){
            const objectURL = URL.createObjectURL(file);
            const token = document.getElementsByName('_token')[0];
            
            var formData = new FormData();
            formData.append('image', file);
            formData.append('_token', token.value);

            fetch(urlUploadPicture, {
                method: 'POST',
                body: formData
            }).then(response => {
                return response.json();
            }).then(data => {
                console.log(data);
                if( data.success ){
                    imgPreview.src = objectURL;
                    imgPreview.style.display = 'block';

                    let messagesWrap = document.querySelector('.messages');
                    if( messagesWrap ){
                        messagesWrap.innerHTML = `
                            <div class="alert alert-success alert-dismissible" role="alert">
                                Foto de perfil actualizada
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                        `;
                    }

                }
            });
        }
    }

    function handleRemovePicture(){
        const token = document.getElementsByName('_token')[0];
        var formData = new FormData();
        formData.append('_token', token.value);

        fetch(urlRemovePicture, {
            method: 'POST',
            body: formData
        }).then(response => {
            return response.json();
        }).then(data => {
            if( data.success ){
                let imgPreview = document.querySelector('#user-picture');
                imgPreview.src = "{{ asset('assets/img/perfil-default.jpg') }}";
            }
        });
    }
</script>
@endsection
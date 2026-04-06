@extends('layout')

@section('main')
    @if(Session::has('brand.success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('brand.success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif

    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <div class="d-flex align-items-center w-100">
                <div class="p-2 me-sm-2 rounded" style="background:#fff;">
                    <img src="{{ $brand->image }}" style="height:64px;">
                </div>
                <div>
                    <h4 class="fw-bold" style="margin-bottom:4px;"> {{ $brand->name }} </h4>
                    <small>Lorem ipsum dolor sit amet consectetur. Dignissim id purus</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <button id="btnEdit" data-href="{{ route('brand.edit', [$brand]) }}" class="dt-button create-new btn btn-primary brand-item">
                <span><i class="bx bx-edit me-sm-2"></i> 
                    <span class="d-none d-sm-inline-block">Editar marca</span>
                </span>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Tareas Totales</span>
                <h4 class="card-title mb-0 fw-bold">1,284</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                    <span class="d-block fw-medium mb-1">Progreso General</span>
                    <div class="d-flex align-items-center">
                        <div class="pe-2">
                            <h4 class="card-title mb-0 fw-bold">76%</h4>
                        </div>
                        <div>
                            <div class="progress" style="height:8px;margin:auto;padding:0px;width:100px;">
                                <div class="progress-bar" role="progressbar" style="width: 68%;background:#0052CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body pb-4">
                <span class="d-block fw-medium mb-1">Miembros Activos</span>
                <h4 class="card-title mb-0 fw-bold">24</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8">
            <div style="margin-bottom:13px;">
                <h5 class="fw-bold" style="margin-bottom:4px;"> Tareas Recientes </h5>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center w-100">
                                <span class="badge rounded-pill bg-label-danger">Danger</span> <spam class="fw-bold ps-2">Marca</spam>
                            </div>
                            <div class="fw-bold mt-2">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </div>
                            <div class="mt-2">
                                <div class="d-flex">
                                    <div class="avatar-group d-flex align-items-center assigned-avatar">
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Bruce" data-bs-original-title="Bruce">
                                            <img src="{{ asset('assets/img/2.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Clark" data-bs-original-title="Clark">
                                            <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <small class="me-2"><i class="icon-base bx bx-calendar"></i> Entrega: 24 Oct</small>
                                        <small><i class="icon-base bx bx-user"></i> Responsable: Andres</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="badge rounded-pill bg-label-primary">Primary</span>
                            <div class="progress" style="height:8px;margin-left:auto;margin-right:0px;padding:0px;width:100px;margin-top:8px;">
                                <div class="progress-bar" role="progressbar" style="width: 68%;background:#0052CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center w-100">
                                <span class="badge rounded-pill bg-label-danger">Danger</span> <spam class="fw-bold ps-2">Marca</spam>
                            </div>
                            <div class="fw-bold mt-2">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </div>
                            <div class="mt-2">
                                <div class="d-flex">
                                    <div class="avatar-group d-flex align-items-center assigned-avatar">
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Bruce" data-bs-original-title="Bruce">
                                            <img src="{{ asset('assets/img/2.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                        <div class="avatar avatar-xs w-px-26 h-px-26" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Clark" data-bs-original-title="Clark">
                                            <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle pull-up">
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <small class="me-2"><i class="icon-base bx bx-calendar"></i> Entrega: 24 Oct</small>
                                        <small><i class="icon-base bx bx-user"></i> Responsable: Andres</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="badge rounded-pill bg-label-primary">Primary</span>
                            <div class="progress" style="height:8px;margin-left:auto;margin-right:0px;padding:0px;width:100px;margin-top:8px;">
                                <div class="progress-bar" role="progressbar" style="width: 68%;background:#0052CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h5 class="fw-bold" style="margin-bottom:4px;"> Equipo </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="">Gestionar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">Zsazsa McCleverty</span>
                                </a>
                                <small>zmcclevertye@soundcloud.com</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                        </div>
                    </div>
                </div>
                <hr class="m-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <img src="{{ asset('assets/img/4.png') }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">Zsazsa McCleverty</span>
                                </a>
                                <small>zmcclevertye@soundcloud.com</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="email-list-item-label badge badge-dot bg-success d-none d-md-inline-block me-2" data-label="work"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="modalCenter" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title fw-bold" id="modalTitle">Nueva marca</h5>
                        <div id="modalDescription">Define una marca para centralizar tareas y seguimiento.</div>
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
    let mode = 'EDIT';
    let urlCreate = "{{ route('brand.create') }}";
    window.addEventListener('load', () => {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btnSaveBrand')) {
                handleCreateBrand();
            }
        });

        let brandItems = document.querySelectorAll('.brand-item');
        brandItems.forEach(brandItem => {
            brandItem.addEventListener('click', handleEdit);
        });
    });

    function handleCreateBrand(){
        let form = document.querySelector('#formBrandCreate');
        let url = form.getAttribute('data-action');

        let name = document.querySelector('#name');
        let token = document.getElementsByName("_token")[0];
        let industry = document.querySelector('#industry');
        let description = document.querySelector('#description');
        let image = document.querySelector('#image');

        var data = new FormData()
        data.append('_token', token.value);
        data.append('name', name.value);
        data.append('industry', industry.value);
        data.append('description', description.value);
        if( image.files.length > 0 ){
            data.append('image', image.files[0]);
        }

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
        if( errors.industry ){
            showError('industry', errors.industry[0]);
        }
        if( errors.description ){
            showError('description', errors.description[0]);
        }
        if( errors.image ){
            showError('image', errors.image[0]);
        }
    }

    function validateForm(){
        clearErrors();

        let name = document.querySelector('#name');
        let industry = document.querySelector('#industry');
        let description = document.querySelector('#description');
        let image = document.querySelector('#image');
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
        document.querySelector('#name').classList.remove('is-invalid');
        document.querySelector('#industry').classList.remove('is-invalid');
        document.querySelector('#description').classList.remove('is-invalid');
        document.querySelector('#image').classList.remove('is-invalid');

        document.querySelector('#errorName').innerHTML = '';
        document.querySelector('#errorIndustry').innerHTML = '';
        document.querySelector('#errorDescription').innerHTML = '';
        document.querySelector('#errorImage').innerHTML = '';
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
            document.querySelector('#modalTitle').innerHTML = 'Actualizar marca';
            document.querySelector('#modalDescription').innerHTML = 'Define una marca para centralizar tareas y seguimiento.';
            $('#modalCenter').modal('show');
            mode = 'EDIT';
            var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
        });
    }
</script>
@endsection
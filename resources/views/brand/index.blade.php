@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold"> Marcas </h4>
            <p>Entiende qué está pasando en cada marca y toma mejores decisiones.</p>
        </div>
        <div class="col-sm-4 col-md-6">
            <div class="dt-action-buttons text-end pt-md-0">
                <div class="dt-buttons"> 
                    <button id="btnCreate" class="dt-button create-new btn btn-primary">
                        <span><i class="bx bx-plus me-sm-2"></i> 
                            <span class="d-none d-sm-inline-block">Agregar marca</span>
                        </span>
                    </button> 
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('brand.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('brand.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="row sm-vl-base">
        @foreach($brands as $brand)
        <div class="col-lg-3 mb-4" @if($brand->status=='DEACTIVE') style="opacity:.35;" @endif>
            <div class="card">
                <a href="{{ route('brand.view', [$brand]) }}">
                    <img class="card-img-top object-fit-cover" src="{{ asset($brand->image) }}" alt="Card image cap" style="max-height:195px;">
                </a>

                <div class="card-badget-top-right">
                    <span class="badge bg-label-secondary"> {{ $brand->industry }} </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold" style="margin-bottom:4px;">
                        <a href="{{ route('brand.view', [$brand]) }}" class="brand-item">
                            {{ $brand->name }}
                        </a>
                    </h5>
                    <p class="card-text"><small>{{ $brand->pending_count }} tareas pendientes</small></p>

                    @if( $brand->progress >= 0 )
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <small>Progreso</small>
                            </div>
                            <div class="col-md-6 fw-bold text-end">
                                <small style="color:@if($brand->progress >= 85) #22C55E; @elseif ($brand->progress >= 50) #EAB308; @else #EF4444; @endif">{{ $brand->progress }}%</small>
                            </div>
                        </div>

                        <div class="progress" style="height: 8px;margin: auto;padding:0px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $brand->progress }}%;background:@if($brand->progress >= 85) #22C55E; @elseif ($brand->progress >= 50) #EAB308; @else #EF4444; @endif" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @else
                        <small>Sin tareas</small>
                    @endif

                    <ul class="list-unstyled m-0 avatar-group d-flex align-items-center mt-4">
                        @foreach( $brand->members as $index => $member )
                            @if( $index >= 3 )
                                @break;
                            @endif

                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-s pull-up" aria-label="{{ $member->name }}" data-bs-original-title="{{ $member->name }}">
                                @if( $member->image )
                                    <img src="{{ asset($member->image) }}" alt="Avatar" class="rounded-circle">
                                @else
                                    <span class="avatar-initial rounded-circle">{{ $member->nameInitial }}</span>
                                @endif
                            </li>
                        @endforeach

                        @if( $brand->members->count() > 3 )
                            <li class="avatar">
                                <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ $brand->members->count() - 3 }} more">+{{ $brand->members->count() - 3 }}</span>
                            </li>
                        @endif
                        {{--
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
                        --}}
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
    let mode = 'CREATE';
    let urlCreate = "{{ route('brand.create') }}";
    window.addEventListener('load', () => {
        document.querySelector('#btnCreate').addEventListener('click', handleCreate);
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btnSaveBrand')) {
                handleCreateBrand();
            }
        });

        //let brandItems = document.querySelectorAll('.brand-item');
        //brandItems.forEach(brandItem => {
        //    brandItem.addEventListener('click', handleEdit);
        //});
    });

    function handleCreate(){
        fetch(urlCreate)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#popup').innerHTML = data;
            document.querySelector('#modalTitle').innerHTML = 'Nueva marca';
            document.querySelector('#modalDescription').innerHTML = 'Define una marca para centralizar tareas y seguimiento.';
            $('#modalCenter').modal('show');
            var medropzone = new DropZone({idElement: 'dropzone', idFile: 'image'});
        });
    }

    function handleCreateBrand(){
        let form = document.querySelector('#formBrandCreate');
        let url = form.getAttribute('data-action');

        let name = document.querySelector('#name');
        let token = document.getElementsByName("_token")[0];
        let industry = document.querySelector('#industry');
        let description = document.querySelector('#description');
        let image = document.querySelector('#image');
        //let status = document.querySelector('#status');

        var data = new FormData()
        data.append('_token', token.value);
        data.append('name', name.value);
        data.append('industry', industry.value);
        data.append('description', description.value);
        //data.append('status', status.value);
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
</script>
@endsection
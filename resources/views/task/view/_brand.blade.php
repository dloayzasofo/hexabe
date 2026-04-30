<div class="modal fade hide" id="brandModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar marca</h5>
                    <p>Seleccione la marca a la que pertenece la tarea</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row gy-3 custom-col-3">
                        @foreach($brands as $brand)
                        <div class="col-md">
                            <div class="form-check custom-option custom-option-icon @if( $task->brand_id == $brand->id) checked @endif">
                                <label class="form-check-label custom-option-content" for="updateBrand{{ $brand->id }}">
                                    <span class="custom-option-body">
                                        <div class="avatar avatar-xl mx-auto">
                                            <img src="{{ $brand->image }}" alt="{{ $brand->name }}" class="rounded-circle">
                                        </div>
                                        <span class="custom-option-title mb-1 mt-2"> {{ $brand->name }} </span>
                                        <small> {{ \Str::limit($brand->industry, 12) }} </small>
                                    </span>
                                    <input name="updateBrand" class="form-check-input" type="radio" value="{{ $brand->id }}" id="updateBrand{{ $brand->id }}" @if( $task->brand_id == $brand->id) checked @endif>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnBrandSave" type="button" class="btn btn-primary">Guardar cambio</button>
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

    document.querySelector('#btnBrandSave').addEventListener('click', handleBrandSave);

    let urlUpdateBrand = "{{ route('task.api.edit.brand', ['task' => $task->id]) }}";
    function handleBrandSave(){
        document.querySelector('#btnBrandSave').disabled = true;
        let brand_id = document.querySelector('input[name="updateBrand"]:checked').value;

        fetch(urlUpdateBrand, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                brand_id: brand_id
            })
        }).then(response => response.json())
        .then(data => {
            document.querySelector('#btnBrandSave').disabled = false;
            if( data.success ){
                handleResponseBrand(data.data);
            }
        });
    }
    
    function handleResponseBrand(data){
        let brandImage = document.querySelector('#brandImage');
        let brandUrl = document.querySelector('#brandUrl');
        let brandName = document.querySelector('#brandName');
        let brandIndustry = document.querySelector('#brandIndustry');

        brandImage.src = data.image;
        brandUrl.href = "/brand/view/" + data.id;
        brandName.innerHTML = data.name;
        brandIndustry.innerHTML = data.industry;

        $('#brandModal').modal('hide');
    }
</script>
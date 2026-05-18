<div class="row bg-light p-3 rounded align-items-center mb-4" style="position:sticky;top:0px;z-index:10;">
    <div class="col-md-4">
        <h4 class="fw-bold mb-0"> {{ $title }} </h4>
    </div>
    <div class="col-md-8">
        <div class="input-group input-group-merge" style="max-width:450px;margin-left:auto;margin-right:0px;">
            <span class="input-group-text" id="basic-addon-search31"><i class="icon-base bx bx-search"></i></span>
            <input id="inputSearch" type="text" class="form-control" placeholder="Buscar tarea..." aria-label="Buscar tarea..." style="padding-left:10px;">
        </div>
        <div id="searchResult" class="search-result"></div>
    </div>
</div>

<script>
    let urlSearchTask = "{{ route('task.api.search') }}";
    window.addEventListener('load', () => {
        const inputSearch = document.querySelector('#inputSearch');
        const searchResult = document.querySelector('#searchResult');

        inputSearch.addEventListener('input', handlerInputSearch);
        inputSearch.addEventListener("blur", (event) => {
            setTimeout(() => {
                searchResult.innerHTML = '';
                searchResult.classList.remove('active');
            }, 500);
        });
    });

    function handlerInputSearch(e){
        const inputSearch = document.querySelector('#inputSearch');
        const searchResult = document.querySelector('#searchResult');
        const value = inputSearch.value.trim();

        if( value.length < 2){
            searchResult.innerHTML = '';
            searchResult.classList.remove('active');
            return;
        }

        searchResult.classList.add('active');
        fetch(`${urlSearchTask}?s=${value}`,{
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            handleRenderSearchResult(data);
        });
    }

    function handleRenderSearchResult(data){
        const searchResult = document.querySelector('#searchResult');
        let html = '';

        if( data.data.length == 0 ){
            html = '<div class="search-item"><div class="py-3 text-center"> No se encontraron resultados </div></div>';
            return;
        }

        for (let index = 0; index < data.data.length; index++) {
            const task = data.data[index];
            let image = `<span class="avatar-initial rounded-circle bg-label-primary">${task.user_assign.nameInitial}</span>`;
            let status = '';

            if( task.user_assign.image ){
                image = `<img src="${task.user_assign.image}" alt="Avatar" class="rounded-circle">`;
            }

            switch (task.status) {
                case 'TOSTART':
                    status = '<span class="badge rounded-pill bg-label-warning">Sin empezar</span>';
                    break;
                case 'PROCESS':
                    status = '<span class="badge rounded-pill bg-label-info">En proceso</span>';
                    break;
                case 'DELAY':
                    status = '<span class="badge rounded-pill bg-label-danger">Retraso</span>';
                    break;
                case 'PAUSED':
                    status = '<span class="badge rounded-pill bg-label-danger">Pausado</span>';
                    break;
                case 'FINALIZED':
                    status = '<span class="badge rounded-pill bg-label-success">Finalizado</span>';
                    break;
            }

            html += `
                <div class="search-item">
                    <a href="/task/view/${task.id}">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avatar me-3">
                                    ${image}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">${task.title}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted me-1"><i class="bx bx-history"></i> ${task.date_delivery}</small>
                                        <small class="text-muted"><i class="bx bx-tag"></i> ${task.brand}</small>
                                    </div>
                                    <div>
                                        ${status}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `;
        }
        searchResult.innerHTML = html;
    }
</script>
window.addEventListener('load', () => {
    loadCtSelects();
});

function loadCtSelects(){
    let ctSelects = document.querySelectorAll('.ct-select');
    for (let i = 0; i < ctSelects.length; i++) {
        loadItemCtSelects(ctSelects[i]);
    }

    let ctSelectViews = document.querySelectorAll('.ct-select-view');
    for (let i = 0; i < ctSelectViews.length; i++) {
        ctSelectViews[i].addEventListener('click', handleClickCtSelect);
    }

    let ctSelectViewItems = document.querySelectorAll('.list-items-item');
    for (let i = 0; i < ctSelectViewItems.length; i++) {
        ctSelectViewItems[i].addEventListener('click', handleClickCtSelectItem);
    }
}

function loadItemCtSelects(element){
    let value = element.getAttribute('data-value');
    let items = element.querySelectorAll('.list-items-item');
    let view = element.querySelector('.ct-select-view');
    for (let i = 0; i < items.length; i++) {
        let item = items[i].getAttribute('data-value');
        if( item == value ){
            element.classList.remove(item);
            view.innerHTML = items[i].innerHTML;
        }
    }
    //console.log(element);
    element.classList.add(value);
}

function handleClickCtSelect(){
    let parent = this.parentNode;
    closeAllCtSelect(parent);
    if( parent.classList.contains('active') ){
        parent.classList.remove('active');
        return;
    }
    parent.classList.add('active');
}

function closeAllCtSelect(element){
    let ctSelects = document.querySelectorAll('.ct-select');
    for (let i = 0; i < ctSelects.length; i++) {
        if( ctSelects[i] != element ){
            ctSelects[i].classList.remove('active');
        }
    }
}

function handleClickCtSelectItem(){
    let value = this.getAttribute('data-value');
    let taskId = this.getAttribute('data-id');
    let parent = this.parentNode.parentNode;
    let type = parent.getAttribute('data-type');
    
    if( type == 'priority' ){
        serverCtSelectPriority(taskId, value);
    }
    if( type == 'status' ){
        serverCtSelectStatus(taskId, value);
    }

    let view = parent.querySelector('.ct-select-view');
    view.innerHTML = this.innerHTML;
    parent.className = 'ct-select';
    parent.classList.add(value);
}

function serverCtSelectPriority(taskId, priority){
    let url = "/task/api/edit/priority/:id".replace(':id', taskId);
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            priority: priority
        })
    }).then(response => response.json())
    .then(data => {
        showCtSelectToast(data);
    });
}

function serverCtSelectStatus(taskId, status){
    let url = "/task/api/edit/status/:id".replace(':id', taskId);
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status: status
        })
    }).then(response => response.json())
    .then(data => {
        showCtSelectToast(data);
    });
}

function showCtSelectToast(data){
    console.log(data, "true");
    if( data.success ) {
        const wrapToast = document.querySelector('.wrap-toast');
        let classAlert = data.success ? 'bg-success' : 'bg-danger';
        let idRandom = Math.random().toString(36).substring(2, 9);
        let html = `
        <div id="${idRandom}" class="bs-toast toast fade hide ${classAlert}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
            <div class="toast-header">
            <i class="icon-base bx bx-bell me-2"></i>
            <div class="me-auto fw-medium">Notificación</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">${ data.message }</div>
        </div>
        `;

        wrapToast.insertAdjacentHTML('beforeend', html);
        setTimeout(() => {
        const toastElement = document.getElementById(idRandom);
        if (toastElement) {
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
        }, 150);
    }
}
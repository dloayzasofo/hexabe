function DropZone(config){
    this.idElement = config.idElement;
    this.idFileElement = config.idFile;
    this.callback = config.callback ?? null;
    this.area = document.getElementById(this.idElement);
    this.file = document.getElementById(this.idFileElement);

    this.clickHandler = function(){
        this.file.click();
        this.removeErrorMessage();
    };

    this.fileChangeHandler = function(ev){
        var self = this;
        const openFile = ev.target.files[0];
        if (openFile) {
            const reader = new FileReader();
            reader.readAsDataURL(openFile);
            reader.onloadend = function () {
                const result = reader.result;
                let src = this.result;
                let imgElem = $(self.area).find('.dropzone_preview img');
                $(imgElem).attr('src', src);
                $(imgElem).removeClass('hide');
                //self.area.style.backgroundImage = "url(" + src + ")";
            }

            if( this.callback ){
                this.callback({'status': 'ok'});
            }
        }
    }

    this.dropHandler = function(ev) {
        ev.preventDefault();
        
        var file = null;
        var _isOk = true;
        if (ev.dataTransfer.items) {
            // Usar la interfaz DataTransferItemList para acceder a el/los archivos)
            for (var i = 0; i < ev.dataTransfer.items.length; i++) {
                if (ev.dataTransfer.items[i].kind !== 'file') {
                    _isOk = false;
                    break;
                }
                file = ev.dataTransfer.items[i].getAsFile();
                if( !this.isFileOfType(file, '/image.*/') ){
                    _isOk = false;
                    break;
                }

            }
        } else {
            // Usar la interfaz DataTransfer para acceder a el/los archivos
            for (var i = 0; i < ev.dataTransfer.files.length; i++) {
                file = ev.dataTransfer.files[i].getAsFile();
                if( !this.isFileOfType(file, '/image.*/') ){
                    _isOk = false;
                    break;
                }
            }
        }
        if( _isOk  ){
            this.file.files = ev.dataTransfer.files;
            if( this.callback ){
                this.callback({'status': 'ok'});
            }
        }

        var self = this;
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = function () {
            let src = this.result;
            let imgElem = $(self.area).find('.dropzone_preview img');
            $(imgElem).attr('src', src);
            $(imgElem).removeClass('hide');
            //self.area.style.backgroundImage = "url(" + src + ")";
        }

        this.area.classList.remove('dragover');
        this.removeErrorMessage();
        // Pasar el evento a removeDragData para limpiar
        this.removeDragData(ev)
    }

    this.isFileOfType = function(file, typeFile){
        if (!file.type.match(typeFile)) {
            return true;
        }
        return false;
    }

    this.dragLeaveHandler = function(ev){
        this.area.classList.remove('dragover');
        ev.preventDefault();
    }
    
    this.dragEnterHandler = function(ev){
        this.area.classList.add('dragover');
        ev.preventDefault();
    }
    
    this.dragOverHandler = function(ev){
        ev.preventDefault();
    }

    this.removeDragData = function(ev) {
        if (ev.dataTransfer.items) {
            // Use DataTransferItemList interface to remove the drag data
            ev.dataTransfer.items.clear();
        } else {
            // Use DataTransfer interface to remove the drag data
            ev.dataTransfer.clearData();
        }
    }

    this.removeErrorMessage = function(){
        var parent = this.area.parentNode;
        if (parent.hasChildNodes()) {
            var children = parent.children;
            for (var i = 0; i < children.length; i++) {
                var child = children[i];
                if( child.classList.contains('error') ){
                    child.innerHTML = '';
                }
            }
        }
    }

    this.area.addEventListener('click', this.clickHandler.bind(this), false);
    this.area.addEventListener('touchend', this.clickHandler.bind(this), false);
    this.area.addEventListener('dragleave', this.dragLeaveHandler.bind(this), false);
    this.area.addEventListener('dragenter', this.dragEnterHandler.bind(this), false);
    this.area.addEventListener('dragover', this.dragOverHandler.bind(this), false);
    this.area.addEventListener('drop', this.dropHandler.bind(this), false);
    this.file.addEventListener('change', this.fileChangeHandler.bind(this));
}

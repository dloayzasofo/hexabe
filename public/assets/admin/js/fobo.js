$(document).ready(function(){
    initDataTable();
    setActiveToMenuByUrl();
    $('input').on('focus', removeInputsErrorStyle);
    $(document).on('click','.confirmDelete', modalShowAlertMessage);
    $(document).on('click','.modal-href', modalConfirmDelete);
});

function initDataTable(){
    if( $.fn.dataTable == undefined ) return;
    $.extend( true, $.fn.dataTable.defaults, {
        "language": {
            "decimal": ",",
            "thousands": ".",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoPostFix": "",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "processing": "Procesando...",
            "search": "Buscar:",
            "searchPlaceholder": "",// "Término de búsqueda",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            //"aria": {
            //    "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
            //    "sortDescending": ": Activar para ordenar la columna de manera descendente"
            //},
            //only works for built-in buttons, not for custom buttons
            "buttons": {
                "create": "Nuevo",
                "edit": "Cambiar",
                "remove": "Borrar",
                "copy": "Copiar",
                "csv": "fichero CSV",
                "excel": "tabla Excel",
                "pdf": "documento PDF",
                "print": "Imprimir",
                "colvis": "Visibilidad columnas",
                "collection": "Colección",
                "upload": "Seleccione fichero...."
            },
            "select": {
                "rows": {
                    _: '%d filas seleccionadas',
                    0: 'clic fila para seleccionar',
                    1: 'una fila seleccionada'
                }
            }
        }           
    });
}

function setActiveToMenuByUrl(){
    var menu = {
        //'admin': "menu-admin",
        'dashboard': "menu-dashboard",
        'team': "menu-team",
        'task': "menu-task",
        'popup': "menu-popup",
        'brand': "menu-brand",
        'user': "menu-user",
        'setting': "menu-setting",
        
        'form-contact': "menu-forms-contact",
        'service': "menu-forms-service",
        'boletin': "menu-forms-boletin",
        'contact': "menu-contact",
        'blog/article': "menu-blog-article",
        'blog/categories': "menu-blog-category",
        'bursatil/article': "menu-bursatil-article",
        'bursatil/categories': "menu-bursatil-category",
        'bursatil/video': "menu-bursatil-video",
        'sorteo/ask': "menu-sorteo-ask",
    };

    var keys = Object.keys(menu);
    var url = location.pathname;
    console.log(url);

    if( url.endsWith('/') ){
        $('#menu-admin').addClass('active');
        return;
    }

    if( url.includes('logs') ){
        $('#menu-historial').addClass('active');
        return;
    }

    if( url.includes('sorteo/ask') ){
        $('#menu-sorteo-ask').addClass('active');
        return;
    }
    
    for(var i=0; i < keys.length; i++){
        var key = keys[i];
        if( url.includes(key) ){
            
            if( url.includes('tarifario') ){
                $('#menu-service').addClass('open');
                $('#menu-tarifario').addClass('active');
                return;
            }
            if( url.includes('requisitos') ){
                $('#menu-service').addClass('open');
                $('#menu-requisitos').addClass('active');
                return;
            }

            if( url.includes('forms/contact') ){
                $('#menu-forms-contact').addClass('active');
                return;
            }

            if( url.includes('structure/gestion') ){
                $('#menu-gestion').addClass('active');
                return;
            }
            if( url.includes('structure/bono') ){
                $('#menu-bono').addClass('active');
                return;
            }
            if( url.includes('structure/archivo') ){
                $('#menu-archivo').addClass('active');
                return;
            }
            
            $('#' + menu[key]).addClass('active');
            if( $('#' + menu[key]).hasClass('drop') ){
                $('#' + menu[key]).addClass('open');
            }
        }
    }
}

function removeInputsErrorStyle(){
    var parent = $(this).parent();
    $(parent).removeClass('row-invalid');
    var message = $(parent).find('.error');
    if( message ){
        $(message).html('');
    }
}

function modalShowAlertMessage(){
    var message = $(this).attr('data-message');
    var href    = $(this).attr('data-href');
    $('.modal').find('.modal-message').html(message);
    $('.modal').find('.modal-href').attr('data-href', href);
    $('#confirmDelete').modal('show');
}

function modalConfirmDelete(){
    var href = $(this).attr('data-href');
    if( href == undefined ){
        alert("ERROR: URL desconocida\nOcurrió un error al intentar obtener la url de redireccionamiento");
        return;
    }
    window.location.href = href;
    $('#confirmDelete').modal('hide');
}

function slugify(str){
    return str
    .toLowerCase()
    .trim()
    .replace(/[^\w\s-]/g, '')
    .replace(/[\s_-]+/g, '-')
    .replace(/^-+|-+$/g, '');
}

function globalInputEditable(elementHide, elementShow){
    $('.editable').attr('readonly', false);
    if( elementHide.length > 0 ){
        $(elementHide).addClass('hide');
    }
    if( elementShow.length > 0 ){
        $(elementShow).removeClass('hide');
    }
}

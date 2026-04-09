// Require https://cdn.quilljs.com/1.3.6/quill.js and
// https://cdn.quilljs.com/1.3.6/quill.snow.css

function MeEditor(config){
    this.toolbar = config.toolbar;
    this.placeholder = config.placeholder;
    this.editor = config.editor;
    this.textarea = config.textarea;
    

    this.options = {
        modules: {
            toolbar: this.toolbar
        },
        placeholder: this.placeholder, // 'Escriba la frase correspondiente al fondo ...',
        readOnly: config.readOnly,
        theme: 'snow'
    };

    this.quill = new Quill(this.editor, this.options);
    
    this.quill.on('text-change', function() {
        var myEditor = document.querySelector(this.editor);
        var html = myEditor.children[0].innerHTML;
        //console.log(this.textarea);
        $(this.textarea).html(html);
        //console.log($(this.textarea).html());
    }.bind(this));

    this.quill.on('selection-change', function(range, oldRange, source) {
        if (range === null && oldRange !== null) {
            //blur
        } else if (range !== null && oldRange === null){
            //focus
            //console.log(this.quill);
            var me = this.quill.container;
            var parent = $(me).parent();
            $(parent).removeClass('row-invalid');
            var message = $(parent).find('.error');
            if( message ){
                $(message).html('');
            }
        }
    }.bind(this));

}
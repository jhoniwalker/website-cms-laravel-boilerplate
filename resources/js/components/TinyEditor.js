import React from 'react';
import ReactDOM from 'react-dom';
import { Editor } from '@tinymce/tinymce-react';

function TinyEditor(props) {

    /*const handleEditorChange = (content, editor) => {
        console.log('Content was updated:', content);
    }*/
    return (
        <Editor
            textareaName={props.textareaName}
            initialValue={props.content}
            apiKey="selav1v8s1gu06e0cjallp93cc2we0yj9mw9d87owdyg9de5"
            init={{
                height: 500,
                language: 'es',
                menubar: 'file edit view insert format tools table tc help',
                inline_styles: true,
                plugins: [
                    'advlist autolink lists link media image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime table paste code help wordcount',
                    'textcolor',
                    'lists code emoticons',
                ],
                toolbar:
                    'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect removeformat | forecolor backcolor | \
                alignleft aligncenter alignright alignjustify | \
                bullist numlist outdent indent | charmap emoticons | link image media table | fullscreen preview code print | help',

                toolbar_sticky: true,
                toolbar_mode: 'sliding',

                /* and here's our custom image picker*/

                image_caption: true,

                relative_urls: false,

                file_picker_types: 'file image media',

                file_picker_callback: function (callback, value, meta) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                    let type = 'image' === meta.filetype ? 'Images' : 'Files',
                        url = '/laravel-filemanager?editor=tinymce5&type=' + type;

                    tinyMCE.activeEditor.windowManager.openUrl({
                        url: url,
                        title: 'Administrador de archivos',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no",
                        onMessage: (api, message) => {
                            callback(message.content);
                            //console.log(message.content);
                        }
                    });
                },

                image_advtab: true,
                image_class_list: [
                    { title: 'Estilo por defecto', value: 'img-newsbody' }

                ]

            }}
        //onEditorChange={handleEditorChange}
        />
    );
}


export default TinyEditor;

if (document.getElementById('tiny_editor')) {
    /**
     * Esto lo hago para recibir una variable de blade (php-laravel) dentro del componente de react
     */
    // find element by id.
    const element = document.getElementById('tiny_editor')

    // create new props object with element's data-attributes. data-ep en mi caso
    // result: {ep: "comodato"}
    const props = Object.assign({}, element.dataset)

    //console.log('usos superficiales cuerpos de agua')
    //console.log(props.usosSuperficialescuerposAgua)
    //paso el valor del props por parametro al componente
    ReactDOM.render(<TinyEditor {...props} />, document.getElementById('tiny_editor'));
}
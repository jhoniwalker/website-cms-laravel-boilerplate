import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import DropzoneComponent from 'react-dropzone-component';
import 'react-dropzone-component/styles/filepicker.css';
import 'dropzone/dist/min/dropzone.min.css';
import getVideoId from 'get-video-id';
import SortableGallery from './SortableGallery';
import VideoForm from './VideoForm';


var position = 0;

var componentConfig = {
    iconFiletypes: ['.jpg', '.png'],
    showFiletypeIcon: true,
    postUrl: ''
};

var djsConfig = {
    //addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png",
    dictDefaultMessage: "Arrastrá las imágenes que querés agregar o podés hacer click y buscarlas",
    //autoProcessQueue: false,
    params: {
        menu_id: null,
        position: position,
        _token: null
    }
};



function Gallery(props) {

    const [menuGallery, setMenuGallery] = useState(JSON.parse(props.menuGallery));

    const [videoId, setVideoId] = useState("");

    const [spinnerIndicator, setSpinnerIndicator] = useState(false);


    if (menuGallery.length !== 0) {
        //verifico la última posición de la galería y lo incremento en 1
        position = menuGallery[menuGallery.length - 1].position + 1
        //console.log(position)
        djsConfig.params.position = position
    }

    //asigno la url para guardar la imagen
    componentConfig.postUrl = props.postStore;
    //asigno el id del aviso a la variable 
    djsConfig.params.menu_id = props.menuId;
    //asigno el token
    djsConfig.params._token = props.csrfToken


    /***
     * Variable de la librería Dropzone
     */
    var eventHandlers = {
        complete: () => onComplete()
    }

    /**
     * Para actualizar el grid de contenidos
     * cuando subo una imagen
     */

    var onComplete = () => {

        //aumento la posiciòn de la imagen pára guardarla en la db
        position = position + 1;

        //actualizo valor de la variable djsConfig
        djsConfig.params.position = position;

        //traigo todas la imágenes y videos para mostrarla de forma ordenada y actualizo la galería
        fetch(props.getMedia)
            .then(response => response.json())
            .then(response => setMenuGallery(response));


    }

    /**
     * Para guardar los videos 
     */
    const handleSubmit = (evt) => {

        evt.preventDefault();

        //En la base de datos es link_video, pero se guarda el id
        const { id } = getVideoId(videoId);

        setVideoId("");
        setSpinnerIndicator(true);

        fetch(props.postStoreVideoId, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', "X-CSRF-Token": props.csrfToken },
            body: JSON.stringify({
                video_id: id,
                position: position,
                menu_id: props.menuId
            }),
        })
            .then(res => res.json())
            .then(() => {
                //aumentamos la pocisión y seteamos spinner
                position++;
                setSpinnerIndicator(false);
            })
            .then(() => {
                //actualizamos el grid galería
                fetch(props.getMedia)
                    .then(response => response.json())
                    .then(response => setMenuGallery(response));
            })
            .catch(error => console.error('Error:', error));

    }

    /**
     * Se pasan como props la galería como estado, el csrf_token y el id del anuncio
     * Los dos últimos props serviran para borrar las imágenes 
     */
    return (
        <>
            <div className="form-row">
                <div className="form-group col-sm-8">
                    <DropzoneComponent
                        config={componentConfig}
                        eventHandlers={eventHandlers}
                        djsConfig={djsConfig}
                    />
                </div>
                <div className="form-group col-sm-4">
                    <VideoForm
                        handleSubmit={handleSubmit}
                        videoId={videoId}
                        onChange={e => setVideoId(e.target.value)}
                        spinnerIndicator={spinnerIndicator}
                    />
                </div>

            </div>

            <SortableGallery
                menuGallery={menuGallery}
                csrfToken={props.csrfToken}
                menuId={props.menuId}
            />

        </>
    );
}

export default Gallery;

if (document.getElementById('menu-gallery')) {
    /**
     * Esto lo hago para recibir una variable de blade (php-laravel) dentro del componente de react
     */
    // find element by id.
    const element = document.getElementById('menu-gallery')

    // create new props object with element's data-attributes. data-ep en mi caso
    // result: {ep: "comodato"}
    const props = Object.assign({}, element.dataset)
    //console.log(props)
    //paso el valor del props por parametro al componente
    ReactDOM.render(<Gallery {...props} />, document.getElementById('menu-gallery'));
}
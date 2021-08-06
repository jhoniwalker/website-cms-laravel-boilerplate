import React, { useState, forwardRef, useEffect } from "react";
import { ReactSortable } from "react-sortablejs";

// This is just like a normal component, but now has a ref.
const CustomComponent = forwardRef((props, ref) => {
    return <div ref={ref} className="row">{props.children}</div>;
});

const imageStyle = {
    width: '100%',
    height: '200px',
    //backgroundImage: `url(${Background})`,
    backgroundPosition: 'center',
    backgroundSize: 'contain',
    backgroundRepeat: 'no-repeat'
};

const mediaThumbnail = (image, idVideo) => {

    if (image.includes('youtube')) {
        return <>
            <div className="draggable-handle" style={{ ...imageStyle, backgroundImage: `url(${'/storage/menu/gallery/thumb/' + image})` }}>
                <i className="fab fa-youtube"></i>
            </div>
            <img className="thumb-for-main d-none" src={'/storage/menu/gallery/thumb/' + image} alt="imagen de galería" />
        </>

    } else {

        return <>
            <div className="draggable-handle" style={{ ...imageStyle, backgroundImage: `url(${'/storage/menu/gallery/thumb/' + image})` }}>
                <i className="fas fa-image"></i>
            </div>
            <img className="thumb-for-main d-none" src={'/storage/menu/gallery/thumb/' + image} alt="imagen de galería" />
        </>

    }

}



function SortableGallery(props) {

    /*Inicializo el state con el arreglo de la galería*/

    const [state, setState] = useState(props.menuGallery);

    useEffect(() => {
        setState(props.menuGallery);
    }, [props.menuGallery]);

    return (

        <ReactSortable
            tag={CustomComponent}
            list={state}
            setList={setState}
            group="groupName"
            animation={200}
            delayOnTouchStart={true}
            delay={2}
        >

            {state.map((item) => (

                <div className="col-sm-3" key={item.id}>
                    <div className="thumbnail rounded border shadow-sm">
                        {mediaThumbnail(item.image, item.video_id)}
                        <div className="caption">
                            <form method="POST" action={'https://www.farmaciassanmartin.com/admin/menus/destroy-file/' + item.id}>
                                <input type="hidden" name="_token" id="token" value={props.csrfToken} />
                                <input type="hidden" name="_method" value="DELETE" />
                                <input type="hidden" name="menu_id" value={props.menuId} />
                                <button className="btn btn-block btn-danger btn-sm btn-flat rounded-bottom" type="submit">
                                    <i className="fa fa-trash fa-fw"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                    <input type="hidden" name="images_id[]" value={item.id} />
                </div>
            ))
            }

        </ReactSortable >
    );
}

export default SortableGallery;
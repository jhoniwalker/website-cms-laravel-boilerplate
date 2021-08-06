import React from 'react';

const spinner = (spinnerIndicator) => {

    if (spinnerIndicator) {
        return <span className="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>

    }

}

function VideoForm(props) {
    return (
        <form onSubmit={props.handleSubmit}>
            <div className="form-group">
                <label htmlFor="link_video">Enlace de Video</label>
                <div className="input-group">
                    <div className="input-group-prepend">
                        <span className="input-group-text">
                            <i className="cil-video"></i>
                        </span>
                    </div>
                    <input className="form-control" id="link_video" type="text" value={props.videoId} onChange={props.onChange} placeholder="Pega acá un enlace de youtube" />
                </div>
            </div>
            <div className="form-group form-actions">
                <button className="btn btn-sm btn-success" disabled={props.videoId === "" ? true : false} type="submit">
                    {spinner(props.spinnerIndicator)}
                    Guardar
                </button>

            </div>
        </form>
    );
}

export default VideoForm;
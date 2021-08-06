/*
 --Jhonatan Vieira makes this Entry Component--
*/
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import TinyEditor from '../TinyEditor';

export default class MenuType extends Component {
    constructor(props) {
        super(props);

        this.state = {
            value: 'DEFAULT',
            link: '',
            target: '',
            title: '',
            intro: '',
            body: '',
            image: '',
        };

        this.handleChange = this.handleChange.bind(this);

    }

    componentWillMount() {

        //console.log(this.props.provinces)
        this.setState({

            value: this.props.menuType,
            link: this.props.link,
            target: this.props.target,
            body: this.props.body,
            title: this.props.title,
            intro: this.props.intro,
            image: this.props.image,
        })

    }

    handleChange(event) {
        this.setState({ value: event.target.value });
    }


    imageMenu() {
        //console.log(this.state.image)
        if (this.state.image !== '') {
            return <>
                <div className="form-group ">
                    <img className="img-thumbnail" src={this.state.image} style={{ width: this.props.width, backgroundSize: 'contain', backgroundRepeat: 'no-repeat', height: this.props.high }} />
                </div>
                <div className="form-group ">
                    <label htmlFor="logo">Imagen principal (Puede cambiar la imagen)</label>
                    <input type="file" name="image" className="form-control" id="image" accept="image/*" />

                </div>
            </>

        } else {
            return <div className="form-group ">
                <label htmlFor="image">Imagen principal</label>
                <input type="file" name="image" className="form-control" id="image" accept="image/*" />
            </div>
        }
    }

    inputMenu() {

        if (this.state.value === 'enlace') {
            return <>
                <strong>Contenido</strong>
                <hr></hr>
                <div className="form-group">
                    <label htmlFor="link">Enlace</label>
                    <input type="text" className="form-control" name="link" id="link" defaultValue={this.state.link} />
                </div>
                <div className="form-group">
                    <label htmlFor="target">El enlace se abre en</label>
                    <select className="form-control" name="target" id="target" defaultValue={this.state.target} onChange={this.handleChangeTarget}>
                        <option value="_blank">una nueva ventana</option>
                        <option value="_top">la misma ventana</option>
                    </select>
                </div>
            </>
        } else if (this.state.value === 'pagina') {
            return <>
                <strong>Contenido</strong>
                <hr></hr>
                <div className="form-group">
                    <label htmlFor="title">Título</label>
                    <input type="text" className="form-control" name="title" defaultValue={this.state.title} />
                </div>
                <div className="form-group">
                    <label htmlFor="intro">Introducción</label>
                    <textarea className="form-control" name="intro" defaultValue={this.state.intro} />
                </div>
                { this.imageMenu()}
                <div className="form-group">
                    <label>Cuerpo</label>
                    <TinyEditor
                        content={this.state.body}
                        textareaName="body"
                    />
                </div>

            </>
        }



    }

    render() {
        return (
            <>
                <div className="form-group">
                    <label htmlFor="type">Tipo</label>
                    <select className="form-control" required name="type" id="type" defaultValue={this.state.value} onChange={this.handleChange}>
                        <option disabled selected value="">Seleccione un tipo</option>
                        <option value="menu superior">Menu superior</option>
                        <option value="enlace">Enlace</option>
                        <option value="pagina">Página</option>
                    </select>
                </div>
                {this.inputMenu()}
            </>
        );
    }
}

if (document.getElementById('menu_type')) {
    /**
     * Esto lo hago para recibir una variable de blade (php-laravel) dentro del componente de react
     */
    // find element by id.
    const element = document.getElementById('menu_type')

    // create new props object with element's data-attributes. data-ep en mi caso
    // result: {ep: "comodato"}
    const props = Object.assign({}, element.dataset)
    //console.log(props)
    //paso el valor del props por parametro al componente

    ReactDOM.render(<MenuType {...props} />, document.getElementById('menu_type'));

}

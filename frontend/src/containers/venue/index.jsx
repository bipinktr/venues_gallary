import React, {PureComponent} from 'react';
import axios from 'axios';
import '../../css/venue.css'

const API_URL = process.env.REACT_APP_BACKEND_API ? `${process.env.REACT_APP_BACKEND_API}/api/venues` : 'http://127.0.0.1:8000/api/venues';

class Venue extends PureComponent {
    constructor(props) {
        super(props);
        this.state = {
            venues: [],
            name: null,
            discountPercentage: null,
        }
    }

    componentDidMount() {
        axios.get(API_URL)
            .then((response) => {
                this.setState({venues: response.data})
            });
    }

    createSelectOptions = () => {
        const options = [<option key={0} value={0}>Select</option>];
        for (let i = 10; i <= 90; i = i + 10) {
            options.push(<option key={i} value={i}>{i}% off or more</option>);
        }
        return options;
    };

    handleChangeName = event => {
        const {value} = event.target;
        this.setState({name: value});
        let query = '';
        if (this.state.discountPercentage) {
            query = `&discount_percentage=${this.state.discountPercentage}`;
        }
        axios.get(`${API_URL}?name=${value}${query}`)
            .then((response) => {
                this.setState({venues: response.data})
            });
    };

    handleChangePercentage = event => {
        const {value} = event.target;
        this.setState({discountPercentage: value});
        let query = '';
        if (this.state.name) {
            query = `name=${this.state.name}&`;
        }
        axios.get(`${API_URL}?${query}discount_percentage=${value}`)
            .then((response) => {
                this.setState({venues: response.data})
            });
    };

    render() {
        return (
            <div>
                <div className="form">
                    <div className="heading">
                        VENUES GALLERY
                    </div>
                    <div className="form-row">
                        <div className="col-25">
                            <label htmlFor="name">Name</label>
                        </div>
                        <div className="col-75">
                            <input className="input-css" id="name" onChange={this.handleChangeName}/>
                        </div>
                    </div>
                    <div className="form-row">
                        <div className="col-25">
                            <label htmlFor="discount">Discount</label>
                        </div>
                        <div className="col-75">
                            <select id="discount" className="select-css" onChange={this.handleChangePercentage}>
                                {this.createSelectOptions()}
                            </select>
                        </div>
                    </div>
                    <div className="form-row">
                        <div className="col-25">
                            <label htmlFor="total">Total</label>
                        </div>
                        <div className="col-75">
                            <div className="label-input"> {this.state.venues.length} Venues</div>
                        </div>
                    </div>
                </div>
                <div className="container" style={{clear: 'both'}}>
                    {this.state.venues.map(venue => (
                        <div className="container-row" key={venue.id}>
                            <img src={venue.image} alt={venue.image}/>
                            <div className="row-label">{venue.name}</div>
                            <div className="row-label">{venue.discount_percentage}% off</div>
                        </div>
                    ))}
                </div>
            </div>
        )
    }
}

export default Venue;
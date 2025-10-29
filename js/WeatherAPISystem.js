//array of cities from file Cities.js
import { cityNames } from "./cities.js"

//Weather Class System 
//Note: will need to adjust the class to follow the design models discussed in class
export class WeatherAPISystem {

    api_key = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" //this is Carter's key for the free version of OpenWeatherMapAPI
    latitude = null;
    longitude = null;
    cityName = "";
    
    //default constructor
    constructor() {
        this.cityName = this.getRandomCity();
        this.getCityCoords();
    }

    //gets a random city from the array of cities
    getRandomCity() {
        return cityNames[Math.floor(Math.random() * cityNames.length)]
    }

    //Sends a fetch to return the weather data from OpenWeatherAPI
    getWeatherData() {
        let Forecast_URL = `https://api.openweathermap.org/data/2.5/weather?lat=${this.latitude}&lon=${this.longitude}&appid=${this.api_key}`;

        fetch(Forecast_URL).then(res => res.json()).then(data => {
            console.log(data);
        }).catch(() => {
            alert('Failed to get current weather');
        });
    }

    //Sends a fetch to return the Geocoding data from OpenWeatherAPI
    //This is for transforming city names to Latitudes and Longitudes using OpenWeatherAPI's Geocoding API. 
    //Only problem so far is some names are off when getting the weather data
    //ex: Ottawa is WyWard Market
    getCityCoords() {
        let Geocode_URL = `http://api.openweathermap.org/geo/1.0/direct?q=${this.cityName}&limit=1&appid=${this.api_key}`;

        fetch(Geocode_URL).then(res => res.json()).then(data => {
            this.latitude = data[0].lat;
            this.longitude = data[0].lon;
            this.getWeatherData();
        }).catch(() => {
            alert(`Failed to reach the coordinates of ${this.cityName}`);
        });
    }

    //gets latitude for use in main.js
    getLatitude() {
        return this.latitude
    }
    
    //gets longitude for use in main.js
    getLongitude() {
        return this.longitude
    }

}
export default WeatherAPISystem;


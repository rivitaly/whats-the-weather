//Weather Class System 
//Note: will need to adjust the class to follow the design models discussed in class
export class WeatherAPISystem {

    api_key = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" //this is Carter's key for the free version of OpenWeatherMapAPI
    type = null;    //update this value, then can access as weather.type from main.js

    async init() {
        await this.setWeatherData();
    }
    
    //Sends a fetch to return the weather data from OpenWeatherAPI
    async setWeatherData(long, lat) {
        let Forecast_URL = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${long}&appid=${this.api_key}`;
        try {
            const res = await fetch(Forecast_URL);
            const data = await res.json();
            this.type = data.weather[0].main;
        }
        catch {
            alert('Failed to get current weather');
        }
    }

}
export default WeatherAPISystem;
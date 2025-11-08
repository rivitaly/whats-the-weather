var api_key = "XXXXXXXXXXXXXXXXXXXXXXXXX" //this is Carter's key for the free version of OpenWeatherMapAPI

var atmosphereTypes = ["Mist", "Smoke", "Haze", "Dust", "Fog", "Sand", "Dust", "Ash", "Squall", "Tornado"];

//Weather Class System 
//Note: will need to adjust the class to follow the design models discussed in class
export class WeatherAPISystem {
    type = null;    //update this value, then can access as weather.type from main.js
    cities = [];
    city = null;
    countryCode = null;
    country = null;
    long = null;
    lat = null;
    main = null;     //contains temp, feels_like, etc

    async init() {
        if(this.cities.length == 0) //Only want to set once
            await this.getCityData();
        await this.getRandomCity();
        await this.setWeatherData();
    }

    //Sends a fetch to return the weather data from OpenWeatherAPI
    async setWeatherData(long, lat) {
        let Forecast_URL = `https://api.openweathermap.org/data/2.5/weather?lat=${this.lat}&lon=${this.long}&appid=${api_key}`;
        try {
            const res = await fetch(Forecast_URL);
            const data = await res.json();
            this.type = data.weather[0].main;
            this.main = data.main;
            //If of Atmosphere type, set to Atmosphere
            if (atmosphereTypes.includes(this.main)){
                this.type = "Atmosphere";
            }
        }
        catch {
            alert('Failed to get current weather');
        }
    }

    async getCityData() {
        try {
            const res = await fetch('./assets/city.list.json') //This JSON is provided at https://openweathermap.org/current#cityid
            const data = await res.json();
            this.cities = data;
        }
        catch {
            alert('Failed to get city data')
        }
    }

    async getRandomCity() {
        let cityName = this.cities[Math.floor(Math.random() * this.cities.length)];
        let countryFormatter = new Intl.DisplayNames(['en'], { type: 'region' });
        this.city = cityName.name;
        this.countryCode = cityName.country
        this.country = countryFormatter.of(this.countryCode)
        this.long = cityName.coord.lon;
        this.lat = cityName.coord.lat;
    }

}
export default WeatherAPISystem;
import {getRandomCity} from './cities.js'
import Weather from './weather.js'

//Variables
let city, country, long, lat = null;
const weather = new Weather();

//Elements
const locationDisplay = document.getElementById("location-display");

//Events
const button = document.getElementById("start-button")
button.addEventListener('click', async () => {
  const {city, country, long, lat} = getRandomCity(); //Assigns to variables without needing to set additional local var
  await weather.setWeatherData(long, lat); //Call weather.type to access the weather classification
  locationDisplay.innerHTML = `${city}, ${country}`;
})
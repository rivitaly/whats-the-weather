import Weather from './weather.js'

//Variables
let city, country, long, lat = null;
const weather = new Weather();

//Elements
const locationDisplay = document.getElementById("location-display");

//Events
const button = document.getElementById("start-button")
button.addEventListener('click', async () => {
  await weather.init(); //Call weather.type to access the weather classification
  locationDisplay.innerHTML = `${weather.city}, ${weather.country}`;
  console.log(weather.main);
})
let cities = null;
fetch('../assets/city.list.json') //This JSON is provided at https://openweathermap.org/current#cityid
.then(response => {
  if (response.ok) {
    return response.json();
  }
})
.then(data => {
  cities = data;
})

//Function returns a table providing the city name, country name, longitude and latitude
//Need to make accessible from main.js
function getRandomCity() {
  let cityName = cities[Math.floor(Math.random() * cities.length)];
  let countryFormatter = new Intl.DisplayNames(['en'], {type: 'region'});
  let city = cityName.name;
  let countryCode = cityName.country
  let country = countryFormatter.of(countryCode)
  let long = cityName.coord.lon;
  let lat = cityName.coord.lat;
  return {city, country, long, lat};
}

export {getRandomCity}
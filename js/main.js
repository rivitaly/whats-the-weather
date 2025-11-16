import Weather from './weather.js'

//Variables
let matchStarted = false, guessed = false;
const weather = new Weather();

//Elements
const locationDisplay = document.getElementById("location-title");
const mainButton = document.getElementById("main-button")
const weatherButtons = document.getElementById("weather-button-container");

//Functions
function correct(button){
  //Visual Update
  button.classList.add("correct")

  //Database Update
  fetch("../insertGuessScript.php", {method: "POST"})
}

function incorrect(button, correctButton){
  //Visual Update
  button.classList.add("incorrect");
  correctButton.classList.add("correct");

}

//Events
mainButton.addEventListener('click', async () => {
  //Start Game
  await weather.init(); //Call weather.type to access the weather classification
  locationDisplay.innerHTML = `${weather.city}, ${weather.country}`;
  if (!matchStarted)
    matchStarted = true;  //Designed so it only starts when player clicks start everytime page opens
  else
  {
    //Clear all correct/incorrect visuals
    document.querySelectorAll(".weather-button").forEach(button => {
      button.classList.remove("correct", "incorrect");
    });

    //Reset guess
    guessed = false;
  }
  //Hide Start Button, Unhide guess buttons
  //Opted for *.style.visibility over .hidden so elements dont move,
  //Potential change to make: convert to id to animate fade in/out
  mainButton.style.visibility = "hidden";
  weatherButtons.style.visibility = "visible";
  mainButton.innerHTML = "Next Round";
})

document.querySelectorAll(".weather-button").forEach(button => {
  button.addEventListener('click', async => {
    //Only consider button inputs when round is going
    if (!matchStarted || guessed) { return; }
    guessed = true;
    console.log("Weather: " + weather.type)

    if (button.id === weather.type) {
      //Correct guess
      correct(button)
    }
    else {
      //Incorrect guess
      var correctButton = document.getElementById(weather.type);
      incorrect(button, correctButton);
    }

    //Show Next Round button
    mainButton.style.visibility = "visible";
  })
});
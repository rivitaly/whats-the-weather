import Weather from './weather.js'

//Variables
let matchStarted = false, guessed = false;
const weather = new Weather();

//Elements
const locationDisplay = document.getElementById("location-title");
const mainButton = document.getElementById("main-button")
const weatherButtons = document.getElementById("weather-button-container");
const leaderBoardDaily = document.getElementById("leaderboard-daily");
const leaderBoardWeekly = document.getElementById("leaderboard-weekly");
const leaderBoardMonthly = document.getElementById("leaderboard-monthly");
const table = document.getElementById("leaderboard-table");


//Functions
function correct(button){
  //Visual Update
  button.classList.add("correct")

  //Database Update
  fetch("./insertGuessScript.php", {
    method: "POST",
    credentials: "include"
  })
}

function incorrect(button, correctButton){
  //Visual Update
  button.classList.add("incorrect");
  correctButton.classList.add("correct");

}

// Set button text if user is NOT logged in
if (!USER_LOGGED_IN) {
    mainButton.innerHTML = "Login";

    mainButton.addEventListener("click", () => {
        window.location.href = "./signin.php";
    });

    // Stop the game logic from attaching to this button
    return;
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
  locationDisplay.classList.remove("location-title-hide");
})

function updateLeaderboard(type) {
    fetch(`getLeaderboard.php?type=${type}`)
        .then(response => response.json())
        .then(data => {
            // Clear existing rows except header
            table.innerHTML = `
                <tr>
                    <th>Username</th>
                    <th class="leaderboard-value">Score</th>
                </tr>
            `;
            
            // Add new rows
            data.forEach(player => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <th>${player.display_name}</th>
                    <th class="leaderboard-value">${player.score}</th>
                `;
                table.appendChild(row);
            });
        })
        .catch(err => console.error('Error fetching leaderboard:', err));
}

leaderBoardDaily.addEventListener('click', () => updateLeaderboard('daily'));
leaderBoardWeekly.addEventListener('click', () => updateLeaderboard('weekly'));
leaderBoardMonthly.addEventListener('click', () => updateLeaderboard('monthly'));

// Load daily leaderboard by default
updateLeaderboard('daily');

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
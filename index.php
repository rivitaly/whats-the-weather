<!DOCTYPE html>
<html>
    <head>
        <title>What's the Weather</title>
        <script type="importmap">
            {
                "imports": {
                    "three": "https://cdn.jsdelivr.net/npm/three@v0.180.0/build/three.module.js",
                    "three/addons/": "https://cdn.jsdelivr.net/npm/three@v0.180.0/examples/jsm/"
                }
            }
        </script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
      <header>
        <div class="header">
          <a href="index.php">
            <h1 id="header-title">What's the Weather</h1>
          </a>
            <nav>
                <ul>
                    <li><a id="header-buttons" href="index.php">Home</a></li>
                    <li><a id="header-buttons" href="signin.php">Sign In</a></li>
                    <li><a id="header-buttons" href="signup.php">Sign Up</a></li>
                </ul>
            </nav>
        </div>
      </header>
        <div id="location-display">
          <p id="location-title">City, Country</p>
        </div>
        <div id="planet"></div> 
        <button id="main-button">Start Guessing</button>
        <div id="weather-button-container" style="visibility: hidden">
            <button class="weather-button" id="Thunderstorm">Thunderstorm</button>
            <button class="weather-button" id="Drizzle">Drizzle</button>
            <button class="weather-button" id="Rain">Rain</button>
            <button class="weather-button" id="Snow">Snow</button>
            <button class="weather-button" id="Atmosphere">Atmosphere</button>
            <button class="weather-button" id="Clear">Clear</button>
            <button class="weather-button" id="Clouds">Clouds</button>
        </div>
        <script type="module" src="js/main.js"></script>
        <script type="module" src="js/render.js"></script>
      </div>
    </body>
</html>
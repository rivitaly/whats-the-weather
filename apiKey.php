<?php
$apiKey = getenv("API_KEY");

if (!$apiKey) {
    throw new Exception("API_KEY environment variable not set!");
}

define("API_KEY", $apiKey);

echo json_encode(["api_key" => API_KEY]);

?>

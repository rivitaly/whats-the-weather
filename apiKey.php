<?php
define("API_KEY", getenv("API_KEY"));

echo json_encode(["api_key" => API_KEY]);

?>

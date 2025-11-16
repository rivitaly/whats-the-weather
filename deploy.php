<?php
// deploy.php

// Optional: a secret for security, set this in GitHub webhook settings
$secret = 'my-super-secret';

// Verify GitHub signature (optional but recommended)
$payload = file_get_contents('php://input');
$signature = 'sha1=' . hash_hmac('sha1', $payload, $secret);

if (!empty($_SERVER['HTTP_X_HUB_SIGNATURE']) && hash_equals($signature, $_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    // Pull latest code
    exec('cd /var/www/html && git fetch && git reset --hard origin/server-side && git pull 2>&1', $output, $return_var);

    echo "Return code: $return_var\n";
    echo implode("\n", $output);
} else {
    http_response_code(403);
    echo "Invalid signature!";
}
?>
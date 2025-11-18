<?php
// Run git commands
exec("cd /var/www/html && git fetch && git reset --hard origin/MVC-/-Factory-Adaptation && git pull 2>&1", $output, $return_var);

// Output result for debugging
echo "Return code: $return_var\n";
echo implode("\n", $output);
?>
<?php
// Run git commands
exec("cd /var/www/html && git fetch --all && git reset --hard origin/main && git clean -fd 2>&1", $output, $return_var);

// Output result for debugging
echo "Return code: $return_var\n";
echo implode("\n", $output);
?>
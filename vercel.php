<?php
if (isset($_ENV['VERCEL_DEPLOYMENT_URL'])) {
    $_SERVER['SCRIPT_NAME'] = '/api/index.php';
}
?> 
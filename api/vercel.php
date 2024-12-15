<?php
declare(strict_types=1);

if (isset($_ENV['VERCEL_DEPLOYMENT_URL'])) {
    $_SERVER['HTTP_HOST'] = $_ENV['VERCEL_DEPLOYMENT_URL'];
    $_SERVER['SERVER_NAME'] = $_ENV['VERCEL_DEPLOYMENT_URL'];
} 
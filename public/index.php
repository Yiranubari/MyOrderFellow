<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$_SERVER['REQUEST_URI'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($_SERVER['REQUEST_URI']) {
    case '/register':
        $authController = new AuthController();
        $authController->register();
        break;

    case '/login':
        $authController = new AuthController();
        $authController->login();
        break;

    case '/dashboard':
        $dashboardController = new DashboardController();
        $dashboardController->index();
        break;

    case '/logout':
        $authController = new AuthController();
        $authController->logout();
        break;

    case '/verify';
        $authController = new AuthController();
        $authController->verifyOTP();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}

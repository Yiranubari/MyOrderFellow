<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

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

    case '/verify':
        $authController = new AuthController();
        $authController->verifyOTP();
        break;

    case '/dashboard/generate-key':
        require __DIR__ . '/../app/Controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->generateKey();
        break;

    case '/webhook':
        require __DIR__ . '/../app/Controllers/WebhookController.php';
        $webhookController = new App\Controllers\WebhookController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $webhookController->handleOrder();
        } else {
            http_response_code(405);
            echo "Method Not Allowed";
        }
        break;

    case '/dashboard/submit-kyc':
        require __DIR__ . '/../app/Controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->submitKyc();
        break;

    case '/admin/register':
        require __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new \App\Controllers\AdminController();
        $controller->register();
        break;

    case '/admin/login':
        require __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new \App\Controllers\AdminController();
        $controller->login();
        break;

    case '/admin/logout':
        require __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new \App\Controllers\AdminController();
        $controller->logout();
        break;

    case '/admin/dashboard':
        require __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new \App\Controllers\AdminController();
        $controller->dashboard();
        break;

    case '/admin/approve':
        require __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new \App\Controllers\AdminController();
        $controller->approve();
        break;

    case '/admin/reject':
        require __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new \App\Controllers\AdminController();
        $controller->reject();
        break;
    case '/admin/orders':
        $controller = new \App\Controllers\AdminController();
        $controller->index();
        break;

    case '/admin/order/details':
        $controller = new \App\Controllers\AdminController();
        $controller->details();
        break;

    case '/track':
        $controller = new \App\Controllers\TrackingController();
        $controller->index();
        break;

    case '/track/result':
        $controller = new \App\Controllers\TrackingController();
        $controller->track();
        break;

    case '/':
        $controller = new \App\Controllers\HomeController();
        $controller->index();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/../views/404.php';
        break;
}

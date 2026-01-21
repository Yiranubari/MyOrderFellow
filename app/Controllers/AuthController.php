<?php

namespace App\Controllers;



use App\Models\User;
use App\Core\Controller;


class AuthController
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $userModel = new User();

            $userModel->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            header('Location: /login');
            exit();
        }
        require_once __DIR__ . '/../../views/auth/register.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['company_id'] = $user['id'];
                $_SESSION['company_name'] = $user['name'];

                header('Location: /dashboard');
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        }
        require_once __DIR__ . '/../../views/auth/login.php';
    }
}

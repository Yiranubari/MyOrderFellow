<?php

namespace App\Controllers;



use App\Models\User;
use App\Core\Controller;
use App\Services\MailService;

class AuthController
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $otp = rand(100000, 999999);

            $userModel = new User();

            // $userModel->create([
            //     'name' => $name,
            //     'email' => $email,
            //     'password' => $password,
            // ]);

            // header('Location: /login');
            // exit();
            try {
                // Attempt to create the user
                $userModel->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'otp_code' => $otp,
                ]);
            } catch (\PDOException $e) {
                // If it fails (likely duplicate email), show an error and stop
                if (strpos($e->getMessage(), 'Unique violation') !== false || $e->getCode() == 23505) {
                    $error = "That email is already registered.";
                    require_once __DIR__ . '/../../views/auth/register.php';
                    return;
                }
                throw $e; // Throw other errors normally
            }
        }
        require_once __DIR__ . '/../../views/auth/register.php';

        // Send OTP Email
        $mailer = new MailService();
        $mailer->sendOTP($email, $otp);
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
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }

    public function verifyOTP()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $otp_code = trim($_POST['otp_code']);

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // Check if user exists AND if the OTP matches the database
            if ($user && $user['otp_code'] === $otp_code) {

                // 1. Mark the user as verified in the database
                $userModel->verifyUser($email);

                // 2. Log them in (Start Session)
                session_start();
                $_SESSION['company_id'] = $user['id'];
                $_SESSION['company_name'] = $user['name'];

                // 3. Redirect to Dashboard
                header('Location: /dashboard');
                exit();
            } else {
                $error = "Invalid OTP code.";
            }
        }

        require_once __DIR__ . '/../../views/auth/verify_otp.php';
    }
}

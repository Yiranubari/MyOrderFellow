<?php

namespace App\Controllers;



use App\Models\User;
use App\Core\Controller;
use App\Services\MailService;


class AuthController
{
    public $error = null;
    public function register()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($name) || empty($email) || empty($password)) {
                $this->error = "All fields are required.";
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            $userModel = new User();

            if ($userModel->findByEmail($email)) {
                $this->error = "Email is already registered.";
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            // Generate OTP
            $otp_code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $userModel->create([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'otp_code' => $otp_code,
            ]);

            // Send OTP via email
            $mailService = new MailService();
            $mailService->sendOTP($email, $otp_code);

            session_start();
            $_SESSION['verify_email'] = $email;

            header('Location: /verify');
            exit();
        }
        $error = $this->error;
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
                $this->error = "Invalid email or password.";
                require_once __DIR__ . '/../../views/auth/login.php';
                return;
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
        session_start();
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
                $this->error = "Invalid OTP code.";
            }
        }
        $email = $_SESSION['verify_email'] ?? ($_GET['email'] ?? '');
        $error = $this->error;
        require_once __DIR__ . '/../../views/auth/verify_otp.php';
    }
}

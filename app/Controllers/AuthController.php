<?php

namespace App\Controllers;



use App\Models\User;
use App\Services\MailService;


class AuthController
{
    public $error = null;
    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if (empty($name) || empty($email) || empty($password)) {
                $this->error = "All fields are required.";
                $error = $this->error;
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            $userModel = new User();

            if ($userModel->findByEmail($email)) {
                $this->error = "Email is already registered.";
                $error = $this->error;
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            $otp_code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);


            $userModel->create([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'otp_code' => $otp_code,
            ]);

            $_SESSION['verify_email'] = $email;
            $_SESSION['success'] = "Please verify your email to complete registration.";

            $mailService = new MailService();
            $mailService->sendOTP($email, $otp_code);

            header('Location: /verify');
            exit();
        }
        $error = $this->error;
        require_once __DIR__ . '/../../views/auth/register.php';
    }

    public function verifyOTP()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $otp_code = trim($_POST['otp_code']);

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && $user['otp_code'] === $otp_code) {
                $userModel->verifyUser($email);

                $_SESSION['company_id'] = $user['id'];
                $_SESSION['company_name'] = $user['name'];

                unset($_SESSION['verify_email']);

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



    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);


            if (isset($_SESSION['pending_registration']) && $_SESSION['pending_registration']['email'] === $email) {
                $pending = $_SESSION['pending_registration'];
                if (password_verify($password, $pending['password'])) {
                    $_SESSION['verify_email'] = $email;
                    session_destroy();
                    header('Location: /verify');
                    exit();
                }
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {

                if (empty($user['is_verified']) || !$user['is_verified']) {
                    $_SESSION['verify_email'] = $user['email'];
                    header('Location: /verify');
                    exit();
                }

                $_SESSION['company_id'] = $user['id'];
                $_SESSION['company_name'] = $user['name'];

                header('Location: /dashboard');
                exit();
            } else {
                $this->error = "Invalid email or password.";
                $error = $this->error;
                require_once __DIR__ . '/../../views/auth/login.php';
                return;
            }
        }
        $error = $this->error;
        require_once __DIR__ . '/../../views/auth/login.php';
    }
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}

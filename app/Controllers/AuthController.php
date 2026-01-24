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

            // Generate OTP
            $otp_code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store registration data in session (NOT in database yet)
            session_start();
            $_SESSION['pending_registration'] = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'otp_code' => $otp_code,
            ];
            $_SESSION['verify_email'] = $email;
            $_SESSION['success'] = "Please verify your email to complete registration.";

            // Send OTP via email
            $mailService = new MailService();
            $mailService->sendOTP($email, $otp_code);

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

                // Check if user is verified
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

    public function verifyOTP()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $otp_code = trim($_POST['otp_code']);

            // Check if this is a new registration (pending in session)
            if (isset($_SESSION['pending_registration'])) {
                $pending = $_SESSION['pending_registration'];

                // Verify OTP matches session
                if ($pending['email'] === $email && $pending['otp_code'] === $otp_code) {
                    $userModel = new User();

                    // Now create the user in database
                    $userModel->create([
                        'name' => $pending['name'],
                        'email' => $pending['email'],
                        'password' => $pending['password'],
                        'is_verified' => true,
                    ]);

                    // Get the newly created user
                    $user = $userModel->findByEmail($email);

                    // Clear pending registration
                    unset($_SESSION['pending_registration']);
                    unset($_SESSION['verify_email']);

                    // Log them in
                    $_SESSION['company_id'] = $user['id'];
                    $_SESSION['company_name'] = $user['name'];

                    header('Location: /dashboard');
                    exit();
                } else {
                    $this->error = "Invalid OTP code.";
                }
            } else {
                // Existing user trying to verify (e.g., from login redirect)
                $userModel = new User();
                $user = $userModel->findByEmail($email);

                if ($user && $user['otp_code'] === $otp_code) {
                    $userModel->verifyUser($email);

                    $_SESSION['company_id'] = $user['id'];
                    $_SESSION['company_name'] = $user['name'];

                    header('Location: /dashboard');
                    exit();
                } else {
                    $this->error = "Invalid OTP code.";
                }
            }
        }
        $email = $_SESSION['verify_email'] ?? ($_GET['email'] ?? '');
        $error = $this->error;
        require_once __DIR__ . '/../../views/auth/verify_otp.php';
    }
}

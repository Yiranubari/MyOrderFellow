<?php

namespace App\Controllers;

namespace App\Services;

use App\Models\User;
use App\Services\MailService;

class ResendOtp
{
    public function resend()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if (empty($email)) {
                $_SESSION['error'] = "Email is required to resend OTP.";
                header('Location: /verify');
                exit();
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if (!$user) {
                $_SESSION['error'] = "No account found with that email.";
                header('Location: /verify');
                exit();
            }

            $otp_code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $userModel->updateOtpCode($email, $otp_code);

            $mailService = new MailService();
            $mailService->sendOTP($email, $otp_code);

            $_SESSION['success'] = "A new OTP has been sent to your email.";
            header('Location: /verify');
            exit();
        } else {
            header('Location: /verify');
            exit();
        }
    }
}

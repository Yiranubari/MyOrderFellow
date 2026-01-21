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
        }
    }
}

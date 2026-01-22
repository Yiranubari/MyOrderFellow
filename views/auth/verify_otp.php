<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Order Fellow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Verify Account</h2>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <p class="text-gray-600 mb-6 text-center text-sm">
            We sent a 6-digit code to your email. <br>Enter it below to confirm your account.
        </p>

        <form action="/verify" method="POST">
            <input type="hidden" name="email" value="<?= $_SESSION['verify_email'] ?? '' ?>">

            <div class="mb-6">
                <label for="otp_code" class="block text-gray-700 text-sm font-bold mb-2">OTP Code</label>
                <input type="text" id="otp_code" name="otp_code" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-center tracking-widest text-xl"
                    placeholder="123456" maxlength="6">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                Verify Code
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="/register" class="text-xs text-gray-500 hover:text-indigo-600">Wrong email? Register again</a>
        </div>
    </div>

</body>

</html>
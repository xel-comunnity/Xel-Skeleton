<?php
use function Xel\Devise\Service\Gemstone\csrf_token;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" href="../../public/css/output.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold mb-6 text-center text-purple-xel">Login</h1>
        <form id="login-form" class="space-y-4">
            <div>
                <label for="email" class="block mb-2 font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-purple-xel" placeholder="Enter your email">
            </div>
            <div>
                <label for="password" class="block mb-2 font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-purple-xel" placeholder="Enter your password">
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" type="checkbox" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-purple-xel">
                    </div>
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-700">Remember me</label>
                </div>
                <a href="#" class="text-sm text-purple-xel hover:underline">Forgot Password?</a>
            </div>
            <button type="submit" class="w-full bg-purple-xel text-white rounded-lg py-2 px-4 font-medium hover:bg-purple-700 transition duration-300">Login</button>
        </form>
        <div class="mt-6 text-center">
            <button id="protected-btn" class="bg-green-500 text-white rounded-lg py-2 px-4 font-medium hover:bg-green-600 transition duration-300">Get Protected Resource</button>
            <button id="csrf-token-btn" class="bg-blue-500 text-white rounded-lg py-2 px-4 font-medium hover:bg-blue-600 transition duration-300 ml-2">Get CSRF Token</button>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('login-form');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const protectedBtn = document.getElementById('protected-btn');
        const csrfTokenBtn = document.getElementById('csrf-token-btn');

        loginForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify({ email, password })
            })
            .then(response => {
                if (response.ok) {
                    // Handle successful login
                    alert('Login successful');
                } else {
                    // Handle login error
                    alert('Login failed');
                }
            })
            .catch(error => {
                alert('An error occurred:', error);
            });
        });

        protectedBtn.addEventListener('click', () => {
            fetch('/protected', { credentials: 'include' })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to fetch protected resource');
                }
            })
            .then(data => {
                alert(JSON.stringify(data)); // Display the response JSON as an alert
            })
            .catch(error => {
                console.error('An error occurred:', error);
            });
        });

        csrfTokenBtn.addEventListener('click', () => {
            const csrfTokenCookie = document.cookie
                .split('; ')
                .find(row => row.startsWith('X-CSRF-Token='))
                ?.split('=')[1];

            if (csrfTokenCookie) {
                alert(`CSRF Token from cookie: ${csrfTokenCookie}`);
            } else {
                alert('CSRF Token cookie not found');
            }
        });
    </script>
</body>
</html>
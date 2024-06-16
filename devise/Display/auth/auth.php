
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
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
        </div>
    </div>


    <script type="module">
        
        import { makeRequestWithCsrfToken, makeRequest } from '../../public/js/request.js';

        const loginForm = document.getElementById('login-form');
        const protectedBtn = document.getElementById('protected-btn');

        loginForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;  

            try {
                const response = await makeRequestWithCsrfToken('http://localhost:9501/login', {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                // ? check the promise
                if (response.ok) {
                    alert('Login successful');
                } else {
                    alert('Login failed');
                }


            } catch (error) {
                alert('An error occurred:', error);
            }
        });

        protectedBtn.addEventListener('click', async () => {
            // ? check first access token is valid?
            // ? if ok continue request , if not return error unauthorizied
            try {
                const response = await fetch('http://localhost:9501/protected', { credentials: 'include' });
                if (response.ok) {
                    const data = await response.json();
                    alert(JSON.stringify(data));
                } else {
                    throw new Error('Failed to fetch protected resource');
                }
            } catch (error) {
                console.error('An error occurred:', error);
            }
        });
    </script>
</body>
</html>

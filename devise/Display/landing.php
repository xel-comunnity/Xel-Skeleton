<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing</title>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="../../../public/css/output.css">
</head>
<body>
<!--  Header  -->
<section class="header">
<nav class="border-d-200 bg-purple-xel dark:bg-gray-800 dark:border-gray-700">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap text-orange-xel">Xel-Framework</span>
      </a>
      <button data-collapse-toggle="navbar-hamburger" type="button" class="inline-flex items-center justify-center p-2 w-10 h-10 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-hamburger" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
      </button>
      <div class="hidden w-full" id="navbar-hamburger">
        <ul class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
          <li>
            <a href="/" class="block py-2 px-3 text-white bg-blue-700 rounded dark:bg-blue-600" aria-current="page">Home</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">CRUD Example</a>
          </li>
          <li>
            <a href="/auth" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white">Gemtone Auth Sample</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Bencmark Sample</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</section>

<hr class="border-purple-xel mx-auto max-w-screen-xl border-2">

 <!--  Hero  -->
 <section class="hero py-12 md:py-20 bg-white-xel">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="order-2 md:order-1">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 text-purple-xel">Secure, Non-Blocking I/O, Coroutine with PHP</h1>
                <p class="text-lg mb-6 text-gray-600">Xel-Framework is a powerful and efficient PHP framework that leverages non-blocking I/O and coroutines for exceptional performance and scalability. Xel also provide minimal server configuration and wrap it as Gemstone packet for all i one bundle security package to mitigate XSS, CSRF, DOS, DDOS(http request flood schema), and SQL Injction</p>
                <div class="flex flex-wrap">
                    <a href="#" class="bg-orange-xel hover:bg-orange-600 text-white-xel font-semibold py-3 px-6 rounded-md mr-4 mb-4 transition duration-300">Get Started</a>
                    <a href="#" class="text-orange-xel font-semibold hover:text-orange-600 transition duration-300">Learn More</a>
                </div>
            </div>
            <div class="order-1 md:order-2 transform hover:scale-105 transition duration-300">
                <img src="https://picsum.photos/500/300" alt="Dummy Image" class="w-full h-auto rounded-lg shadow-lg" />
            </div>
        </div>
    </div>
</section>

<hr class="border-purple-xel mx-auto max-w-screen-xl border-2">

<!--  Repository  -->
<section class="repository py-12 md:py-20 bg-white-xel">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-8 text-center text-purple-xel">Features Collections</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-orange-xel p-6 rounded-lg flex flex-col items-center transition duration-300 hover:bg-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-4 text-purple-xel">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.596 0c.676.597 1.599 1.06 2.598 1.345m-2.598-1.345c.944.171 1.944.392 2.947.676.998-.275 2.002-.494 2.947-.676m-4.594 0c1.901 0 3.634.487 4.958 1.355m-4.584-2.37c.961-.525 1.985-.882 3.027-1.14m-6.048 2.51c.519.352 1.102.648 1.732.877m5.641-5.496c-.961.234-1.914.584-2.8 1.039" />
                </svg>
                <h3 class="text-lg font-bold text-white-xel mb-2">POOL DB Connection Management</h3>
                <p class="text-center text-white-xel">Efficient database connection management using a connection pool.</p>
            </div>
            <div class="bg-gray-500 p-6 rounded-lg flex flex-col items-center transition duration-300 hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-4 text-white-xel">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-bold text-white-xel mb-2">Gemstone Security Package</h3>
                <p class="text-center text-white-xel">Robust security features for authentication, authorization, and data protection.</p>
            </div>
            <div class="bg-orange-xel p-6 rounded-lg flex flex-col items-center transition duration-300 hover:bg-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-4 text-purple-xel">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                </svg>
                <h3 class="text-lg font-bold text-white-xel mb-2">Central Manager Runner (CMR)</h3>
                <p class="text-center text-white-xel">Centralized task management and execution for background jobs and processes.</p>
            </div>
            <div class="bg-gray-500 p-6 rounded-lg flex flex-col items-center transition duration-300 hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-4 text-white-xel">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                <h3 class="text-lg font-bold text-white-xel mb-2">Async Job Dispatcher</h3>
                <p class="text-center text-white-xel">Asynchronous task execution and job dispatching for improved performance.</p>
            </div>
            <div class="bg-orange-xel p-6 rounded-lg flex flex-col items-center transition duration-300 hover:bg-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-4 text-purple-xel">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                </svg>
                <h3 class="text-lg font-bold text-white-xel mb-2">Multi Mode Server</h3>
                <p class="text-center text-white-xel">Flexible server modes for different application requirements.</p>
            </div>
            <div class="bg-gray-500 p-6 rounded-lg flex flex-col items-center transition duration-300 hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-4 text-white-xel">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h3 class="text-lg font-bold text-white-xel mb-2">HTTP Request & Response Bridger</h3>
                <p class="text-center text-white-xel">Seamless integration with HTTP requests and responses.</p>
            </div>
        </div>
    </div>
</section>

<hr class="border-purple-xel mx-auto max-w-screen-xl border-2">

<!-- Community -->
<section class="community py-12 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg px-8 py-10">
            <h2 class="text-2xl md:text-3xl font-bold mb-4 text-center">Let's Contribute</h2>
            <div class="text-center mb-6">
                <h3 class="text-lg font-bold"><i class="fas fa-users"></i> Join Our Community</h3>
                <p class="text-sm text-gray-600">Become a part of our community and contribute to our projects!</p>
            </div>
            <div class="text-center">
                <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition duration-300">Join Us</a>
            </div>
        </div>
    </div>
</section>


<!-- Footer -->
<footer class="bg-purple-xel rounded-lg shadow m-4 dark:bg-gray-800">
    <div class="w-full mx-auto max-w-screen-xl p-4 md:py-8 md:flex md:items-center md:justify-between">
        <span class="text-sm text-orange-xel sm:text-center dark:text-gray-400">
            © 2024 <a href="https://flowbite.com/" class="hover:underline">Xel™</a>. All Rights Reserved.
            <br class="hidden md:block">
            Powering Modern Web Applications with Non-Blocking I/O and Coroutines.
        </span>
        <div class="flex items-center mt-3 sm:mt-0">
            
            <div class="flex">
                <a href="https://github.com/your-github" class="text-white-xel hover:text-orange-xel transition duration-300 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                </a>
                <a href="https://instagram.com/your-instagram" class="text-white-xel hover:text-orange-xel transition duration-300 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162 0 3.403 2.759 6.162 6.162 6.162 3.403 0 6.162-2.759 6.162-6.162 0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg>
                </a>
                <a href="https://youtube.com/your-youtube" class="text-white-xel hover:text-orange-xel transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>


<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
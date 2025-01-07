<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row h-screen">

        <!-- Left Side -->
        <div class="relative flex-1 flex items-center justify-center bg-cover bg-center"
            style="background-image: url('{{ asset('img/mmi/sheiva.png') }}');">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="relative text-center text-white z-10">
                <h1 class="text-4xl font-bold">Welcome Back</h1>
                <p class="text-lg mt-2">Sign in to continue your journey</p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center justify-center flex-1 bg-white">
            <div class="max-w-md w-full p-8 bg-white shadow-lg rounded-lg">
                <h2 class="text-4xl font-bold text-gray-800 text-center mb-4">Sign In</h2>
                <p class="text-gray-600 text-center mb-8">Access your account to manage your settings.</p>
                <form action="/loginUser" method="POST">
                    @csrf
                    <!-- Email Input -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your email...">
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">Invalid email address</div>
                        @enderror
                    </div>
                    <!-- Password Input -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your password...">
                    </div>
                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition duration-300 ease-in-out">
                            Login
                        </button>
                    </div>
                    <!-- Forgot Password -->
                    <div class="mt-4 text-center">
                        <a href="#" class="text-sm text-blue-500 hover:underline">Forgot your password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

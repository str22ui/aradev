<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Aradev')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
  {{-- Header --}}
  <header class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 shadow-lg">
    <div class="container mx-auto px-4 flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <div class="bg-white text-blue-600 w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">
          A
        </div>
        <h1 class="text-2xl font-bold">Aradev</h1>
      </div>

      <div class="flex items-center space-x-4">
        {{-- User Info --}}
        <div class="hidden md:flex items-center space-x-2 bg-blue-500 bg-opacity-30 px-4 py-2 rounded-lg">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span class="font-medium">{{ Auth::user()->name ?? 'User' }}</span>
        </div>

        {{-- Logout Button --}}
        <form action="/logout" method="POST">
          @csrf
          <button type="submit" class="flex items-center space-x-2 bg-red-500 hover:bg-red-600 transition-colors duration-200 px-4 py-2 rounded-lg font-medium shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </div>
  </header>

  {{-- Content --}}
  <main class="flex-grow container mx-auto px-4 py-10">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer class="bg-gray-800 text-white text-center py-4 mt-auto">
    <p>&copy; {{ date('Y') }} Aradev. All rights reserved.</p>
  </footer>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Register</title>
</head>

<body class="bg-gray-100">
  <div class="flex flex-col md:flex-row h-screen">

    <!-- Left Side -->
    <div class="relative flex-1 flex items-center justify-center bg-cover bg-center"
      style="background-image: url('{{ asset('img/mmi/sheiva.png') }}');">
      <div class="absolute inset-0 bg-black bg-opacity-40"></div>
      <div class="relative text-center text-white z-10">
        <h1 class="text-4xl font-bold">Welcome to Aradev!</h1>
        <p class="text-lg mt-2">Register to start your journey</p>
      </div>
    </div>

    <!-- Right Side -->
    <div class="flex items-center justify-center flex-1 bg-white">
      <div class="max-w-2xl w-full p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-4">Register</h2>
        <p class="text-gray-600 text-center mb-8">Access your account to manage your settings.</p>

        <form action="{{ route('affiliate.register.post')}}" method="POST">
          @csrf

          <!-- Form dibagi jadi dua kolom -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
              <input type="text" id="name" name="name"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan nama Anda...">
            </div>

            <div>
              <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
              <input type="text" id="phone" name="phone"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan nomor telepon...">
            </div>

            <div class="md:col-span-2">
              <label for="address" class="block text-gray-700 font-medium mb-2">Alamat</label>
              <input type="text" id="address" name="address"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan alamat...">
            </div>

            <div>
              <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
              <input type="email" id="email" name="email"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan email Anda...">
            </div>


            <div>
              <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
              <input type="password" id="password" name="password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan password...">
            </div>

            <div>
              <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                placeholder="Konfirmasi password...">
            </div>

          </div>

          @if ($errors->any())
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mt-6">
            <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <div class="mt-8">
            <button type="submit"
              class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition">
              Register
            </button>
          </div>

          <div class="mt-4 text-center">
            <a href="/loginUser" class="text-sm text-blue-500 hover:underline">Sudah punya akun? Klik di sini</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

<script>
    function addPerumahan() {
        const container = document.getElementById('perumahan-container');

        // Buat elemen <select> baru
        const newSelect = document.createElement('select');
        newSelect.name = 'perumahan_id[]';
        newSelect.classList.add(
            'form-select',
            'bg-gray-50',
            'border',
            'border-gray-300',
            'text-gray-900',
            'text-sm',
            'rounded-lg',
            'focus:ring-blue-500',
            'focus:border-blue-500',
            'block',
            'w-full',
            'p-2.5',
            'mt-2'
        );

        // Tambahkan opsi dari array PHP
        const perumahanData = @json($perumahan); // Mengambil data dari server
        const defaultOption = document.createElement('option');
        defaultOption.value = 'pilih';
        defaultOption.textContent = '-- Pilih --';
        newSelect.appendChild(defaultOption);

        // Loop melalui data PHP dan tambahkan opsi ke <select>
        perumahanData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = `${item.perumahan}`;
            newSelect.appendChild(option);
        });

        // Tambahkan elemen <select> ke dalam container
        container.appendChild(newSelect);
    }
</script>
</html>

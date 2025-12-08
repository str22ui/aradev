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
            <!-- Kode Referral Sales (TAMBAHKAN INI) -->
        <div class="md:col-span-2">
        <label for="referrer_code" class="block text-gray-700 font-medium mb-2">
            🔑 Kode Referral Sales <span class="text-gray-400 text-sm">(Opsional)</span>
        </label>
        <div class="relative">
            <input type="text"
                id="referrer_code"
                name="referrer_code"
                value="{{ old('referrer_code', request('ref')) }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 uppercase"
                placeholder="Masukkan kode referral dari Sales (jika ada)"
                maxlength="10">
            <button type="button"
                    onclick="checkReferral()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 text-sm">
            Cek
            </button>
        </div>
        <div id="referral-status" class="mt-2"></div>
        <p class="text-xs text-gray-500 mt-1">
            💡 Jika Anda direferensikan oleh Sales, masukkan kode mereka
        </p>
        @error('referrer_code')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
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
<script>
  // Auto uppercase saat mengetik
  document.getElementById('referrer_code').addEventListener('input', function(e) {
    this.value = this.value.toUpperCase();
  });

  // Function untuk cek kode referral
  function checkReferral() {
    const code = document.getElementById('referrer_code').value.trim().toUpperCase();
    const statusDiv = document.getElementById('referral-status');

    if (!code) {
      statusDiv.innerHTML = '';
      return;
    }

    document.getElementById('referrer_code').value = code;

    statusDiv.innerHTML = `
      <div class="flex items-center text-blue-600 text-sm">
        <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Memeriksa kode...
      </div>
    `;

    setTimeout(() => {
      if (code.length >= 4) {
        statusDiv.innerHTML = `
          <div class="flex items-center text-green-600 text-sm bg-green-50 px-3 py-2 rounded border border-green-200">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Kode diterima! Anda akan terhubung dengan Sales setelah registrasi.
          </div>
        `;
      } else {
        statusDiv.innerHTML = `
          <div class="flex items-center text-yellow-600 text-sm bg-yellow-50 px-3 py-2 rounded border border-yellow-200">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            Kode terlalu pendek. Pastikan kode valid.
          </div>
        `;
      }
    }, 500);
  }
</script>
</body>
</html>

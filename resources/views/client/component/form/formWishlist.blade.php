<div class=" mt-2 md:mt-32 mb-10 max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Form Wishlist</h2>

    <form action="{{ route('form.wishlist') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium">Nama</label>
            <input type="text" name="nama" required class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">No HP</label>
            <input type="text" name="no_hp" required class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Domisili</label>
            <input type="text" name="domisili" class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Permintaan</label>
            <select name="permintaan" required class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300">
                <option value="Jual">Jual</option>
                <option value="Menyewakan">Menyewakan</option>
                <option value="Beli">Beli</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Jenis</label>
            <select name="jenis" required class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300">
                <option value="Rumah">Rumah</option>
                <option value="Apartment">Apartement</option>
                <option value="Tanah">Tanah</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi Property</label>
            <select name="lokasi" required class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300">
                <option value="Tangerang">Tangerang</option>
                <option value="Depok">Depok</option>
                <option value="Bogor">Bogor</option>
                <option value="Bekasi">Bekasi</option>
                <option value="Luar Jabodetabek">Luar Jabodetabek</option>

            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Spesifik Lokasi</label>
            <input type="text" name="spesifik_lokasi" required class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Harga Budget</label>
            <input type="text" name="harga_budget" required class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300" oninput="formatHarga(this)">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Keterangan</label>
            <textarea name="keterangan" required class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300"></textarea>
        </div>

        <!-- Approval Hidden (Default: Sembunyikan) -->
        <input type="hidden" name="approval" value="Sembunyikan">

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
            Kirim Wishlist
        </button>
    </form>
</div>

<script>
    function formatHarga(input) {
    // Menghapus semua karakter yang bukan angka
    let value = input.value.replace(/\D/g, '');

    // Memformat angka dengan menambahkan titik setiap 3 digit
    let formattedValue = '';
    for (let i = 0; i < value.length; i++) {
        // Tambahkan titik setiap 3 digit dari belakang
        if (i > 0 && (value.length - i) % 3 === 0) {
            formattedValue += '.';
        }
        formattedValue += value[i];
    }

    // Mengupdate nilai input
    input.value = formattedValue;
}
</script>

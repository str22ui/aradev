@extends('admin.layouts.index', ['title' => 'Tambah Data Secondary', 'page_heading' => 'Tambah Data Secondary'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeSecondary') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}
            <div class="mb-3">
                <label for="available" class="form-label">Available</label>
                <select id="available" name="available"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value ="">--- Pilih ---</option>
                    <option value="Available">Available</option>
                    <option value="Sold Out">Sold Out</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value ="">--- Pilih ---</option>
                    <option value="Dijual">Dijual</option>
                    <option value="Disewakan">Disewakan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Gambar Perumahan (.jpg, .png, .jpeg)</label>
                <input type="file" class="form-control" id="img" name="images[]" multiple>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" autofocus value="" name="judul" id="judul" placeholder="Masukkan Judul" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="lt" class="form-label">Luas Tanah</label>
                <input type="number" autofocus value="" name="lt" id="lt" placeholder="Masukkan Luas Tanah" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="lb" class="form-label">Luas Bangunan</label>
                <input type="number" autofocus value="" name="lb" id="lb" placeholder="Masukkan Luas Bangunan" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="kt" class="form-label">Kamar Tidur</label>
                <input type="number" autofocus value="" name="kt" id="kt" placeholder="Masukkan Jumlah Kamar Tidur" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="ktp" class="form-label">Kamar Tidur Pembantu</label>
                <input type="number" autofocus value="" name="ktp" id="ktp" placeholder="Masukkan Jumlah Kamar Tidur Pembantu" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="km" class="form-label">Kamar Mandi</label>
                <input type="number" autofocus value="" name="km" id="km" placeholder="Masukkan Jumlah Kamar Mandi" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="kmp" class="form-label">Kamar Mandi Pembantu</label>
                <input type="number" autofocus value="" name="kmp" id="km" placeholder="Masukkan Jumlah Mandi Pembantu" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="carport" class="form-label">Carport</label>
                <input type="number" autofocus value="" name="carport" id="carport" placeholder="Masukkan Jumlah Carport" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="garasi" class="form-label">Garasi</label>
                <input type="number" autofocus value="" name="garasi" id="garasi" placeholder="Masukkan Jumlah Garasi" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="listrik" class="form-label">Listrik</label>
                <input type="number" autofocus value="" name="listrik" id="listrik" placeholder="Masukkan Jumlah Listrik" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="air" class="form-label">Air</label>
                <input type="number" autofocus value="" name="air" id="air" placeholder="Masukkan Air" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="surat" class="form-label">Surat</label>
                <select id="surat" name="surat"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value ="">--- Pilih ---</option>
                    <option value="SHM">SHM</option>
                    <option value="HGB">HGB</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="imb" class="form-label">IMB/PBG</label>
                <select id="imb" name="imb"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value ="">--- Pilih ---</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="hidden" class="form-label">Hadap</label>
                <select id="hadap" name="hadap"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value ="">--- Pilih ---</option>
                    <option value="Timur">Timur</option>
                    <option value="Barat">Barat</option>
                    <option value="Selatan">Selatan</option>
                    <option value="Utara">Utara</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="posisi" class="form-label">Posisi</label>
                <select id="posisi" name="posisi"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value ="">--- Pilih ---</option>
                    <option value="Hook">Hook</option>
                    <option value="Badan">Badan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="furnish" class="form-label">Furnish</label>
                <select id="furnish" name="furnish"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value ="">--- Pilih ---</option>
                    <option value="Semi Furnished">Semi Furnished</option>
                    <option value="Unfurnished">Unfurnished</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga ">
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan Lokasi">
            </div>

            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kecamatan" placeholder="Masukkan Kecamatan">
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota" placeholder="Masukkan Kota">
            </div>


            <div class =" mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="ckeditor form-control" id="content" name="deskripsi"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.secondary-home') }}">Back</a>
        </form>

		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>

  </div>
</div>

</section>
<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
<script>
    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');

    name.addEventListener('change', function(){
        fetch('/admin/checkSlugName?name=' + name.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    });

    function addImageInput() {
        const container = document.getElementById('images-container');
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.accept = 'image/*';
        input.classList.add('form-control', 'mb-2');
        container.appendChild(input);
    }

</script>


@endsection




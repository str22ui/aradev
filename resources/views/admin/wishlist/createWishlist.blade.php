@extends('admin.layouts.index', ['title' => 'Tambah Data Wishlist', 'page_heading' => 'Tambah Data Wishlist'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeWishlistt') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}

            <div class="mb-3">
                <label for="approval" class="form-label">Approval</label>
                <select id="approval" name="approval"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Tampilkan">Tampilkan</option>
                    <option value="Sembunyikan">Sembunyikan</option>
                </select>
            </div>

            <div class="mb-3">
              <input type="hidden" value="0" name="views">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" autofocus value="" name="nama" id="nama" placeholder="Masukkan Nama Wishlist" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="number" name="no_hp" id="no_hp" placeholder="Masukkan Nomor Hp" class="form-control">
              </div>
              <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="domisili" class="form-label">Domisili</label>
                <input type="text" name="domisili" id="domisili" placeholder="Masukkan Domisili" class="form-control">
              </div>
            <div class="mb-3">
                <label for="permintaan" class="form-label">Permintaan</label>
                <select id="permintaan" name="permintaan"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Jual">Jual</option>
                    <option value="Menyewakan">Menyewakan</option>
                    <option value="Beli">Beli</option>
                    <option value="Sewa">Sewa</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Property</label>
                <select id="jenis" name="jenis"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Rumah">Rumah</option>
                    <option value="Tanah">Tanah</option>
                    <option value="Apartment">Apartment</option>

                </select>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi Property</label>
                <select id="lokasi" name="lokasi"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Jakarta">Jakarta</option>
                    <option value="Tangerang">Tangerang</option>
                    <option value="Depok">Depok</option>
                    <option value="Bogor">Bogor</option>
                    <option value="Bekasi">Bekasi</option>
                    <option value="Luar Jabodetabek">Luar Jabodetabek</option>

                </select>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="spesifik_lokasi" class="form-label">Spesifik Lokasi (Optional)</label>
                <input type="text" name="spesifik_lokasi" id="spesifik_lokasi" placeholder="Masukkan Spesifik Lokasi" class="form-control">
              </div>

              <div class="mb-3">
                <label for="harga_budget" class="form-label">Harga/Budget</label>
                <input type="text" name="harga_budget" id="harga_budget" placeholder="Masukkan Harga/Budget" class="form-control" oninput="formatHarga(this)">
              </div>

              <div class ="mb-3">
                <label for="keterangan" class="form-label">Detail Leterangan</label>
                    <textarea class="ckeditor form-control" id="content" name="keterangan"></textarea>
            </div>


            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Available">Available</option>
                    <option value="Closed">Closed</option>
                    <option value="Removed">Removed</option>
                    <option value="Hold">Hold</option>

                </select>
            </div>



            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.wishlist') }}">Back</a>
        </form>

		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>

  </div>
</div>

</section>


<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

@endsection




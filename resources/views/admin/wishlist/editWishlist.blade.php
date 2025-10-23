@extends('admin.layouts.index', ['title' => 'Edit Data Agent', 'page_heading' => 'Edit Data Agent'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
        <form method="post" action="{{ route('admin.updateWishlist', ['id' => $wishlist->id]) }}" enctype="multipart/form-data">
            @method('PUT')
        @csrf
            {{-- Title --}}
            <div class="mb-3">
                <label for="tipe" class="form-label">Approval</label>
                <select class="form-select" id="approval" name="approval">
                    <option value="Tampilkan"
                    {{ $wishlist->approval === 'Tampilkan' ? 'selected' : '' }}>Tampilkan</option>
                    <option value="Sembunyikan" {{ $wishlist->approval === 'Sembunyikan' ? 'selected' : '' }}>
                        Sembunyikan</option>
                    </select>
            </div>


            <div class="mb-3">
              <input type="hidden" value="0" name="views">
              <label for="nama" class="form-label">Nama </label>
              <input type="text" value="{{ $wishlist->nama }}" name="nama" id="nama" placeholder="Masukkan Nama Agent" class="form-control">

            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="no_hp" class="form-label">No Hp </label>
                <input type="text" value="{{ $wishlist->no_hp }}" name="no_hp" id="no_hp" placeholder="Masukkan Nama Agent" class="form-control">

            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="domisili" class="form-label">Domisili </label>
                <input type="text" value="{{ $wishlist->domisili }}" name="domisili" id="domisili" placeholder="Masukkan Nama Agent" class="form-control">

              </div>

            <div class="mb-3">
                <label for="Permintaan" class="form-label">Permintaan</label>
                <select class="form-select" id="permintaan" name="permintaan">
                    <option value="Jual"
                    {{ $wishlist->permintaan === 'Jual' ? 'selected' : '' }}>Jual</option>
                    <option value="Menyewakan" {{ $wishlist->permintaan === 'Menyewakan' ? 'selected' : '' }}>
                        Menyewakan</option>

                    <option value="Beli" {{ $wishlist->permintaan === 'Beli' ? 'selected' : '' }}>
                        Beli</option>

                    <option value="Sewa" {{ $wishlist->permintaan === 'Sewa' ? 'selected' : '' }}>
                        Sewa</option>
                    </select>

            </div>

            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Property</label>
                <select class="form-select" id="jenis" name="jenis">
                    <option value="Rumah"
                    {{ $wishlist->jenis === 'Rumah' ? 'selected' : '' }}>Rumah</option>
                    <option value="Tanah" {{ $wishlist->jenis === 'Tanah' ? 'selected' : '' }}>
                        Tanah</option>
                    <option value="Apartment" {{ $wishlist->jenis === 'Apartment' ? 'selected' : '' }}>
                            Apartment</option>
                    </select>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi Property</label>
                <select class="form-select" id="lokasi" name="lokasi">
                    <option value="Tangerang"
                    {{ $wishlist->lokasi === 'Tangerang' ? 'selected' : '' }}>Tangerang</option>
                    <option value="Depok" {{ $wishlist->lokasi === 'Depok' ? 'selected' : '' }}>
                        Depok</option>

                    <option value="Bogor" {{ $wishlist->lokasi === 'Bogor' ? 'selected' : '' }}>
                        Bogor</option>

                    <option value="Bekasi" {{ $wishlist->lokasi === 'Bekasi' ? 'selected' : '' }}>
                        Bekasi</option>

                    <option value="Luar Jabodetabek" {{ $wishlist->lokasi === 'Luar Jabodetabek' ? 'selected' : '' }}>
                        Luar Jabodetabek</option>
                    </select>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="spesifik_lokasi" class="form-label">Spesifik Lokasi </label>
                <input type="text" value="{{ $wishlist->spesifik_lokasi }}" name="spesifik_lokasi" id="spesifik_lokasi" placeholder="Masukkan Nama Agent" class="form-control">

              </div>

              <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="harga_budget" class="form-label">Harga/Budget </label>
                <input type="text" value="{{ $wishlist->harga_budget }}" name="harga_budget" id="harga_budget" placeholder="Masukkan Nama Agent" class="form-control" oninput="formatHarga(this)">

              </div>
            <div class ="mb-3">
                <label for="keterangan" class="form-label">Detail Keterangan</label>
                    <textarea class="ckeditor form-control" id="content" name="keterangan">{{$wishlist->keterangan}}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="Available"
                    {{ $wishlist->status === 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Closed" {{ $wishlist->status === 'Closed' ? 'selected' : '' }}>
                        Closed</option>

                    <option value="Removed" {{ $wishlist->status === 'Removed' ? 'selected' : '' }}>
                        Removed</option>
                    </select>

                    <option value="Hold" {{ $wishlist->status === 'Hold' ? 'selected' : '' }}>
                        Hold</option>
                    </select>
            </div>



            <button type="submit" class="btn btn-primary">Update</button>
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




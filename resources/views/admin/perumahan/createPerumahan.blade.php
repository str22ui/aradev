@extends('admin.layouts.index', ['title' => 'Tambah Data Primary', 'page_heading' => 'Tambah Data Primary'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storePerumahan') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Available">Available</option>
                    <option value="Sold Out">Sold Out</option>
                    <option value="Soon">Soon</option>

                </select>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Gambar Perumahan (.jpg, .png, .jpeg)</label>
                <input type="file" class="form-control" id="img" name="images[]" multiple>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="name" class="form-label">Nama Perumahan</label>
                <input type="text" autofocus value="" name="perumahan" id="perumahan" placeholder="Masukkan Nama Perumahan" class="form-control">
              </div>

            <div class="mb-3">
                <label for="video" class="form-label">Video</label>
                <input type="text" class="form-control" id="video" name="video" placeholder="Masukkan URL Video">
            </div>

            <div id="tipe-container">
                <label for="tipe" class="form-label">Tipe (LT/LB)</label>
                <input type="text" name="tipe[]" placeholder="tipe" class="form-control mb-2">
            </div>
            <button type="button" onclick="addTipe()" class="btn btn-secondary mb-3">Tambah Tipe</button>

            <div class="mb-3">
                <label for="luas" class="form-label">Luas</label>
                <input type="text" class="form-control" id="luas" name="luas">
            </div>


            <div class="mb-3">
                <label for="unit" class="form-label">Jumlah Unit</label>
                <input type="text" class="form-control" id="unit" name="unit">
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi">
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota">
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga">
            </div>

            <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <select id="satuan" name="satuan"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="Jt">Jt</option>
                    <option value="M">M</option>

                </select>
            </div>

            <div id="advantages-container">
                <label for="keunggulan" class="form-label">Keunggulan</label>
                <input type="text" name="keunggulan[]" placeholder="Keunggulan" class="form-control mb-2">
            </div>

            <button type="button" onclick="addAdvantage()" class="btn btn-secondary mb-3">Tambah Keunggulan</button>

            <div id="fasilitas-container">
                <label for="fasilitas" class="form-label">Fasilitas</label>
                <input type="text" name="fasilitas[]" placeholder="Fasilitas" class="form-control mb-2">
            </div>

            <button type="button" onclick="addFasilitas()" class="btn btn-secondary mb-3">Tambah Fasilitas</button>

            <div class  mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="ckeditor form-control" id="content" name="deskripsi"></textarea>
                </div>


            <div class="mb-3">
                <label for="maps" class="form-label">Maps</label>
                <input type="text" class="form-control" id="maps"  name="maps" placeholder="Masukkan maps. Cont: https://...">
            </div>

            <div class="mb-3">
                <label for="brosur" class="form-label">Brosur(.pdf)</label>
                <input type="file" class="form-control" id="brosur" name="brosur">
            </div>

            <div class="mb-3">
                <label for="pricelist" class="form-label">Pricelist(.pdf)</label>
                <input type="file" class="form-control" id="pricelist" name="pricelist">
            </div>

            {{-- <div id="advantages-container">
                <input type="text" name="advantages[]" placeholder="Keunggulan" class="form-control">
            </div>
            <button type="button" onclick="addAdvantage()">Tambah Keunggulan</button> --}}

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.perumahan') }}">Back</a>
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

    function previewImage(){
        const image = document.querySelector('no_kavling');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
          imgPreview.src = oFREvent.target.result;
        }
      }
     function addAdvantage() {
        const container = document.getElementById('advantages-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'keunggulan[]';
        input.placeholder = 'Keunggulan';
        input.classList.add('form-control', 'mb-2');
        container.appendChild(input);
    }

    function addTipe() {
        const container = document.getElementById('tipe-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'tipe[]';
        input.placeholder = 'tipe';
        input.classList.add('form-control', 'mb-2');
        container.appendChild(input);
    }

    function addFasilitas() {
        const container = document.getElementById('fasilitas-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'fasilitas[]';
        input.placeholder = 'fasilitas';
        input.classList.add('form-control', 'mb-2');
        container.appendChild(input);
    }
</script>


@endsection




@extends('admin.layouts.index', ['title' => 'Tambah User', 'page_heading' => 'Tambah User'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeUser') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}


            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="name" class="form-label">Nama</label>
                <input type="text" autofocus value="" name="name" id="name" placeholder="Masukkan Nama" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" placeholder="Masukkan Email" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="role" class="form-label">Role</label>
                <select id="role" name="role"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value ="">--- Pilih ---</option>
                    <option value="admin">Admin</option>
                    <option value="salesAdmin">Sales Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.user') }}">Back</a>
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




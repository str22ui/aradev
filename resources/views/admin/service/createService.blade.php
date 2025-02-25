@extends('admin.layouts.index', ['title' => 'Tambah Services', 'page_heading' => 'Tambah Services'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeService') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}

            <div class="mb-3">
                <label for="img" class="form-label">Banner Service  (.jpg, .png, .jpeg)</label>
                <input type="file" class="form-control" id="image" name="image" multiple>
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">Gambar Informasi (.jpg, .png, .jpeg)</label>
                <input type="file" class="form-control" id="img" name="images[]" multiple>
            </div>


            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" autofocus value="" name="judul" id="judul" placeholder="Masukkan Judul" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="short_desc" class="form-label">Short Description</label>
                <input type="text" autofocus value="" name="short_desc" id="short_desc" placeholder="Masukkan Judul" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="no_hp" class="form-label">No Hp</label>
                <input type="number" autofocus value="" name="no_hp" id="no_hp" placeholder="Masukkan Judul" class="form-control">
            </div>

            <div class="mb-3">
                <label for="long_desc" class="form-label">Deskripsi</label>
                    <textarea class="ckeditor form-control" id="content" name="long_desc"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.service') }}">Back</a>
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




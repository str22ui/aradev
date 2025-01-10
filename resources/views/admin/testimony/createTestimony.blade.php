@extends('admin.layouts.index', ['title' => 'Tambah Testimony', 'page_heading' => 'Tambah Testimony'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeTestimony') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}

            <div class="mb-3">
                <label for="img" class="form-label">Gambar  (.jpg, .png, .jpeg)</label>
                <input type="file" class="form-control" id="image" name="image" multiple>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="name" class="form-label">Nama</label>
                <input type="text" autofocus value="" name="name" id="name" placeholder="Masukkan Nama" class="form-control">
            </div>

            <div class="mb-3">
                <label for="testimony" class="form-label">Testimony</label>
                    <textarea class="ckeditor form-control" id="content" name="testimony"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.testimony') }}">Back</a>
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


</script>


@endsection




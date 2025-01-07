@extends('admin.layouts.index', ['title' => 'Article', 'page_heading' => 'Update Article'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        
		<!-- Table untuk memanggil data dari database -->
    @include('sweetalert::alert')
		<form class="mb-5" method="post" action="{{ route('admin.updateCategory', ['id' => $category->id]) }}"  enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{-- Title --}}
            <div class="mb-3">
              <label for="name" class="form-label">Category Name</label>
              <input type="text" autofocus value="{{ old('name', $category->name) }}" name="name" id="name" placeholder="Masukkan Kategori" class="form-control @error('name') is-invalid @enderror">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

            </div>
            {{-- Slug --}}
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="slug" placeholder="Slug akan digenerate.." value="{{ old('slug', $category->slug) }}" readonly class="form-control @error('slug') is-invalid @enderror" id="slug" required>
              @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a class="btn btn-danger" href="{{ route('admin.category') }}">Back</a>
        </form>
			
		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>
		{{-- Paginator --}}
		{{-- {{ $data->withQueryString()->links() }} --}}
  </div>
</div>

</section>

{{-- <script src="{{ asset('ckeditor/ckeditor.js') }}"></script> --}}
    <script>
      const name = document.querySelector('#name');
        const slug = document.querySelector('#slug');

        name.addEventListener('change', function(){
            fetch('/admin/checkSlugName?name=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
        });

    </script>

@endsection




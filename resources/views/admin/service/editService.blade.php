@extends('admin.layouts.index', ['title' => 'Edit Services', 'page_heading' => 'Update Services'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="POST" action="{{ route('admin.updateService', ['id' => $service->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Title --}}


            <div class="mb-3">
                <label for="img" class="form-label">Gambar info (.jpg, .png, .jpeg)</label>
                <input type="file" class="form-control" id="img" name="images[]" multiple accept="image/*">
                <button type="button" class="btn btn-info mb-3 mt-2" data-bs-toggle="modal" data-bs-target="#imageModal">
                    Lihat Gambar Lama
                </button>
            </div>
            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="name" class="form-label">Judul</label>
                <input type="text" autofocus value="{{  $service->judul }}" name="judul" id="judul" placeholder="Masukkan Judul" class="form-control @error('judul') is-invalid @enderror">
                @error('judul')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>


            <div class="mb-3">
                <label for="short_desc" class="form-label">Headline</label>
                <input type="text" autofocus value="{{  $service->short_desc }}" name="short_desc" id="short_desc" placeholder="Masukkan Judul" class="form-control @error('short_desc') is-invalid @enderror">
                @error('short_desc')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">No Hp</label>
                <input type="number" autofocus value="{{  $service->no_hp }}" name="no_hp" id="no_hp" placeholder="Masukkan Judul" class="form-control @error('no_hp') is-invalid @enderror">
                @error('no_hp')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="long_desc" class="form-label">Deskripsi</label>
                <textarea class="ckeditor form-control" id="content" name="long_desc" value="">{{ $service->long_desc }}</textarea>
            </div>


            <button type="submit" class="btn btn-primary">Update</button>

            <a class="btn btn-danger" href="{{ route('admin.service') }}">Back</a>
        </form>
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Gambar Lama</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(!empty($images) && count($images) > 0)
                            <label>Gambar Lama:</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($images as $image)
                                    <div>
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Foto Lama" style="max-width: 150px; height: auto;">
                                        <form
                                            id="delete-image-form-{{ $image->id }}"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data?')"
                                            class="d-inline"
                                            action="{{ route('admin.deleteImageService') }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm mt-1">Hapus</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Tidak ada gambar lama.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>


		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>
		{{-- Paginator --}}
		{{-- {{ $data->withQueryString()->links() }} --}}
  </div>
</div>

</section>
<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
{{-- <script src="{{ asset('ckeditor/ckeditor.js') }}"></script> --}}
    <script>
        document.querySelectorAll('.btn-delete-image').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const formId = this.dataset.formId;
                document.getElementById(formId).submit();
            });
        });

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
        const image = document.querySelector('#img');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
          imgPreview.src = oFREvent.target.result;
        }
      }



    </script>

@endsection




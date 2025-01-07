@extends('admin.layouts.index', ['title' => 'Edit Tanah', 'page_heading' => 'Update Tanah'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="POST" action="{{ route('admin.updateLand', ['id' => $land->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Title --}}


            <div class="mb-3">
                <label for="img" class="form-label">Gambar land (.jpg, .png, .jpeg)</label>
                <input type="file" class="form-control" id="img" name="images[]" multiple accept="image/*">
                <button type="button" class="btn btn-info mb-3 mt-2" data-bs-toggle="modal" data-bs-target="#imageModal">
                    Lihat Gambar Lama
                </button>
            </div>
            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="name" class="form-label">Judul</label>
                <input type="text" autofocus value="{{  $land->judul }}" name="judul" id="judul" placeholder="Masukkan Judul" class="form-control @error('perumahan') is-invalid @enderror">
                @error('judul')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="lt" class="form-label">Luas Tanah</label>
                <input type="number"  value="{{  $land->lt }}" name="lt" id="lt" placeholder="Masukkan Luas Tanah" class="form-control">
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="surat" class="form-label">Surat</label>
                <select class="form-select" id="surat" name="surat">
                    <option value="SHM" {{ $land->surat === 'SHM' ? 'selected' : '' }}>SHM</option>
                    <option value="HGB" {{ $land->surat === 'HGB' ? 'selected' : '' }}>HGB</option>
                    <option value="Lain-lain" {{ $land->surat === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="imb" class="form-label">IMB/PBG</label>
                <select class="form-select" id="imb" name="imb">
                    <option value="Ya" {{ $land->imb === 'Ya' ? 'selected' : '' }}>Ya</option>
                    <option value="Tidak" {{ $land->imb === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga"
                    value="{{ $land->harga }}">
            </div>


            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi"
                    value="{{ $land->lokasi }}">
            </div>

            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" value="{{ $land->kecamatan}}" id="kecamatan" name="kecamatan" placeholder="Masukkan Kecamatan">
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota"
                    value="{{ $land->kota }}">
            </div>




            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="ckeditor form-control" id="content" name="deskripsi" value="">{{ $land->deskripsi }}</textarea>
            </div>


            <button type="submit" class="btn btn-primary">Update</button>

            <a class="btn btn-danger" href="{{ route('admin.land') }}">Back</a>
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
                                            action="{{ route('admin.deleteImageLand') }}"
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

      function addTipe() {
        const container = document.getElementById('tipe-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'tipe[]';
        input.placeholder = 'Tipe';
        input.classList.add('form-control', 'mb-2');
        container.appendChild(input);
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

    function addFasilitas() {
        const container = document.getElementById('fasilitas-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'fasilitas[]';
        input.placeholder = 'Fasilitas';
        input.classList.add('form-control', 'mb-2');
        container.appendChild(input);
    }

    </script>

@endsection




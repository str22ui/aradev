@extends('admin.layouts.index', ['title' => 'Edit Primary', 'page_heading' => 'Update Primary '])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="POST" action="{{ route('admin.updatePerumahan', ['id' => $perumahan->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Title --}}

            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="Available"
                    {{ $perumahan->status === 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Sold" {{ $perumahan->status === 'Sold Out' ? 'selected' : '' }}>
                    Sold Out</option>
                <option value="Soon" {{ $perumahan->status === 'Soon' ? 'selected' : '' }}>
                    Soon</option>
            </select>

            <div class="mb-3">
                <label for="img" class="form-label">Gambar Perumahan (.jpg, .png, .jpeg)</label>
                <input type="file" class="form-control" id="img" name="images[]" multiple accept="image/*">
                <button type="button" class="btn btn-info mb-3 mt-2" data-bs-toggle="modal" data-bs-target="#imageModal">
                    Lihat Gambar Lama
                </button>
            </div>
            <div class="mb-3">
              <input type="hidden" value="0" name="views">
              <label for="name" class="form-label">Nama Perumahan</label>
              <input type="text" autofocus value="{{  $perumahan->perumahan }}" name="perumahan" id="perumahan" placeholder="Masukkan nama perumahan" class="form-control @error('perumahan') is-invalid @enderror">
              @error('perumahan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>


            <div class="mb-3">
                <label for="video" class="form-label">Video</label>
                <input type="text" class="form-control" id="video" name="video" placeholder="Masukkan URL Video"  value="{{ $perumahan->video }}">
            </div>

            <div id="tipe-container">
                <label for="tipe" class="form-label">Tipe (LT/LB)</label>
                @if($perumahan->tipe && count($perumahan->tipe) > 0)
                    @foreach($perumahan->tipe as $tipe)
                        <input type="text" name="tipe[]" value="{{ $tipe }}" placeholder="Tipe" class="form-control mb-2">
                    @endforeach
                @else
                    <input type="text" name="tipe[]" placeholder="Tipe" class="form-control mb-2">
                @endif
            </div>
            <button type="button" onclick="addTipe()" class="btn btn-secondary mb-3">Tambah Tipe</button>

            <div class="mb-3">
                <label for="luas" class="form-label">Luas</label>
                <input type="text" class="form-control" id="luas" name="luas"
                    value="{{ $perumahan->luas }}">
            </div>
            <div class="mb-3">
                <label for="unit" class="form-label">Jumlah Unit</label>
                <input type="text" class="form-control" id="unit" name="unit"
                    value="{{ $perumahan->unit }}">
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi"
                    value="{{ $perumahan->lokasi }}">
            </div>
            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota"
                    value="{{ $perumahan->kota }}">
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga"
                    value="{{ $perumahan->harga }}">
            </div>

            <label for="satuan" class="form-label">Satuan</label>
            <select class="form-select" id="satuan" name="satuan">
                <option value="Jt"
                    {{ $perumahan->satuan === 'Jt' ? 'selected' : '' }}>Jt</option>
                <option value="M" {{ $perumahan->satuan === 'M' ? 'selected' : '' }}>
                    M</option>
            </select>


            <div id="advantages-container">
                <label for="keunggulan" class="form-label">Keunggulan</label>
                @if($perumahan->keunggulan && count($perumahan->keunggulan) > 0)
                    @foreach($perumahan->keunggulan as $key => $advantage)
                        <div class="mb-2 d-flex align-items-center">
                            <input type="text" name="keunggulan[]" value="{{ $advantage }}" placeholder="Keunggulan" class="form-control me-2">
                            <button type="button" onclick="removeInput(this)" class="btn btn-danger btn-sm">Hapus</button>
                        </div>
                    @endforeach
                @else
                    <input type="text" name="keunggulan[]" placeholder="Keunggulan" class="form-control mb-2">
                @endif
            </div>
            <button type="button" onclick="addAdvantage()" class="btn btn-secondary mb-3">Tambah Keunggulan</button>



            <div id="fasilitas-container">
                <label for="fasilitas" class="form-label">Fasilitas</label>
                @if($perumahan->fasilitas && count($perumahan->fasilitas) > 0)
                    @foreach($perumahan->fasilitas as $key => $facility)
                        <div class="mb-2 d-flex align-items-center">
                            <input type="text" name="fasilitas[]" value="{{ $facility }}" placeholder="Fasilitas" class="form-control me-2">
                            <button type="button" onclick="removeInput(this)" class="btn btn-danger btn-sm">Hapus</button>
                        </div>
                    @endforeach
                @else
                    <input type="text" name="fasilitas[]" placeholder="Fasilitas" class="form-control mb-2">
                @endif
            </div>
            <button type="button" onclick="addFasilitas()" class="btn btn-secondary mb-3">Tambah Fasilitas</button>



            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="ckeditor form-control" id="content" name="deskripsi" value="">{{ $perumahan->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label for="maps" class="form-label">Maps</label>
                <input type="text" class="form-control" id="maps" name="maps" placeholder="Masukkan maps. Cont: https://..."   value="{{ $perumahan->maps }}">
            </div>

            <div class="mb-3">
                <label for="brosur" class="form-label">Brosur</label>
                <input type="file" class="form-control" id="brosur" name="brosur">
                @if ($perumahan->brosur)
                    <input type="hidden" name="old_brosur" value="{{ $perumahan->brosur }}">
                    <a href="{{ asset('storage/' . $perumahan->brosur) }}" target="_blank">View
                        Brosur</a>
                @endif
            </div>
            <div class="mb-3">
                <label for="pricelist" class="form-label">Pricelist</label>
                <input type="file" class="form-control" id="pricelist" name="pricelist">
                @if ($perumahan->pricelist)
                    <input type="hidden" name="old_pricelist"
                        value="{{ $perumahan->pricelist }}">
                    <a a href="{{ asset('storage/' . $perumahan->pricelist) }}"
                        target="_blank">View
                        Pricelist</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>

            <a class="btn btn-danger" href="{{ route('admin.perumahan') }}">Back</a>
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
                                            action="{{ route('admin.deleteImage') }}"
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




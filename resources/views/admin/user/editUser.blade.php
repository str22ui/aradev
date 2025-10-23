@extends('admin.layouts.index', ['title' => 'Edit User', 'page_heading' => 'Update User'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="POST" action="{{ route('admin.updateUser', ['id' => $user->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Title --}}


            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="name" class="form-label">Nama</label>
                <input type="text" autofocus value="{{  $user->name }}" name="name" id="name" placeholder="Masukkan Judul" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="email" class="form-label">Email</label>
                <input type="text" autofocus value="{{  $user->email }}" name="email" id="email" placeholder="Masukkan Email" class="form-control @error('email') is-invalid @enderror">
                @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="salesAdmin" {{ $user->role === 'salesAdmin' ? 'selected' : '' }}>Sales Admin</option>
                    <option value="agent" {{ $user->role === 'agent' ? 'selected' : '' }}>Agent</option>
                    <option value="reseller" {{ $user->role === 'reseller' ? 'selected' : '' }}>Reseller</option>
                    <option value="affiliate" {{ $user->role === 'affiliate' ? 'selected' : '' }}>Affiliate</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password Baru" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>

            <a class="btn btn-danger" href="{{ route('admin.user') }}">Back</a>
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




@extends('admin.layouts.index', ['title' => 'Edit Sales', 'page_heading' => 'Update Sales'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="POST" action="{{ route('admin.updateSales', ['id' => $sales->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Title --}}


            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="name" class="form-label">Nama</label>
                <input type="text" autofocus value="{{  $sales->name }}" name="name" id="name" placeholder="Masukkan Judul" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="email" class="form-label">Email</label>
                <input type="text" autofocus value="{{  $sales->email }}" name="email" id="email" placeholder="Masukkan Email" class="form-control @error('email') is-invalid @enderror">
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
                    <option value="admin" {{ $sales->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="salesAdmin" {{ $sales->role === 'salesAdmin' ? 'selected' : '' }}>Sales Admin</option>
                    <option value="sales" {{ $sales->role === 'sales' ? 'selected' : '' }}>Sales </option>
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

             <div id="perumahan-container">
                <label for="perumahan_id" class="form-label block mb-2 text-sm font-medium">Perumahan yang Dipilih</label>
                @foreach ($sales->perumahan_id as $index => $selectedId)
                    <div class="flex items-center space-x-2">
                        <select name="perumahan_id[]"
                            class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mt-2">
                            <option value="pilih">-- Pilih --</option>
                            @foreach ($perumahan as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $selectedId ? 'selected' : '' }}>
                                    {{ $item->perumahan }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn-delete btn-danger text-white text-sm px-3 py-1 mt-1 rounded"
                            onclick="removePerumahan(this, {{ $index }})">Hapus</button>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addPerumahan()" class="btn btn-secondary my-3">Tambah Perumahan</button>

            <br>
            <button type="submit" class="btn btn-primary">Update</button>

            <a class="btn btn-danger" href="{{ route('admin.sales') }}">Back</a>
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
      function addPerumahan() {
        const container = document.getElementById('perumahan-container');

        // Buat elemen <select> baru
        const newSelect = document.createElement('select');
        newSelect.name = 'perumahan_id[]';
        newSelect.classList.add(
            'form-select',
            'bg-gray-50',
            'border',
            'border-gray-300',
            'text-gray-900',
            'text-sm',
            'rounded-lg',
            'focus:ring-blue-500',
            'focus:border-blue-500',
            'block',
            'w-full',
            'p-2.5',
            'mt-2'
        );

        // Tambahkan opsi dari array PHP
        const perumahanData = @json($perumahan); // Mengambil data dari server
        const defaultOption = document.createElement('option');
        defaultOption.value = 'pilih';
        defaultOption.textContent = '-- Pilih --';
        newSelect.appendChild(defaultOption);

        // Loop melalui data PHP dan tambahkan opsi ke <select>
        perumahanData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = `${item.perumahan}`;
            newSelect.appendChild(option);
        });

        // Tambahkan elemen <select> ke dalam container
        container.appendChild(newSelect);
    }

    function removePerumahan(button, index) {
    const container = document.getElementById('perumahan-container');
    const parentDiv = button.parentElement;
    container.removeChild(parentDiv);

    // Tandai data untuk dihapus di server (opsional, tergantung implementasi backend)
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'delete_perumahan[]';
    hiddenInput.value = index;
    container.appendChild(hiddenInput);
}



    </script>

@endsection




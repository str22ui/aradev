@extends('admin.layouts.index', ['title' => 'Tambah Sales', 'page_heading' => 'Tambah Sales'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeSales') }}" enctype="multipart/form-data">
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
                    <option value="sales">Sales</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password" class="form-control">
            </div>

            <div id="perumahan-container">
                <label for="perumahan_id" class="form-label block mb-2 text-sm font-medium">Perumahan</label>
                <select id="perumahan_id" name="perumahan_id[]"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="pilih">-- Pilih --</option>
                    @foreach ($perumahan as $item)
                        <option value="{{ $item->id }}">{{ $item->perumahan }}</option>
                    @endforeach
                </select>
            </div>
               <button type="button" onclick="addPerumahan()" class="btn btn-secondary my-3">Tambah Perumahan</button><br>

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.sales') }}">Back</a>
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

</script>


@endsection




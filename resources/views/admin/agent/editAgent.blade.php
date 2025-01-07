@extends('admin.layouts.index', ['title' => 'Edit Data Agent', 'page_heading' => 'Edit Data Agent'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
        <form method="post" action="{{ route('admin.updateAgent', ['id' => $agent->id]) }}" enctype="multipart/form-data">
            @method('PUT')
        @csrf
            {{-- Title --}}


            <div class="mb-3">
              <input type="hidden" value="0" name="views">
              <label for="nama" class="form-label">Nama Agent</label>
              <input type="text" value="{{ $agent->nama }}" name="nama" id="nama" placeholder="Masukkan Nama Agent" class="form-control">

            </div>

            <div class="mb-3">

                <label for="tipe" class="form-label">Tipe Agent</label>
                <select class="form-select" id="tipe" name="tipe">

                    <option value="Korporat"
                    {{ $agent->tipe === 'Korporat' ? 'selected' : '' }}>Korporat</option>
                    <option value="Perorangan" {{ $agent->tipe === 'Perorangan' ? 'selected' : '' }}>
                        Perorangan</option>
                    </select>
            </div>



            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="kantor" class="form-label">Kantor Agent</label>
                <input type="text" value="{{ $agent->kantor }}" name="kantor" id="kantor" placeholder="Masukkan Nama Kantor" class="form-control">
              </div>

              <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="no_hp" class="form-label">No Telepon</label>
                <input type="text" value="{{ $agent->no_hp }}" name="no_hp" id="no_hp" placeholder="Masukkan Nomor Telepon" class="form-control">
              </div>

              <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" value="{{ $agent->alamat }}" name="alamat" id="alamat" placeholder="Masukkan Alamat" class="form-control">
              </div>
              <div id="perumahan-container">
                <label for="perumahan_id" class="form-label block mb-2 text-sm font-medium">Perumahan yang Dipilih</label>
                @foreach ($agent->perumahan_id as $index => $selectedId)
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
            <a class="btn btn-danger" href="{{ route('admin.agent') }}">Back</a>
        </form>

		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>

  </div>
</div>

</section>

<script>
document.getElementById('tipe').addEventListener('change', function() {
            var kantorInput = document.getElementById('kantor');
            if (this.value === 'Perorangan') {
                kantorInput.value = 'N/A';
                kantorInput.readOnly = true;
            } else {
                kantorInput.value = '';
                kantorInput.readOnly = false;
            }
        });


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




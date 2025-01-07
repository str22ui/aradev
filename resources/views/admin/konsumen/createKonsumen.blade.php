@extends('admin.layouts.index', ['title' => 'Tambah Data Konsumen', 'page_heading' => 'Tambah Data Konsumen'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeKonsumen') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}

            <div class="mb-3">
                <label for="nama_konsumen" class="form-label">Nama Konsumen</label>
                <input type="text" class="form-control" id="nama_konsumen" name="nama_konsumen">
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">Nomor Handphone (Cont : 0812xxxxx)</label>
                <input type="number" class="form-control" id="no_hp" name="no_hp"
                       pattern="08[0-9]{8,}"
                       title="Nomor harus diawali dengan 08 dan hanya terdiri dari angka"
                       oninput="validatePhoneNumber()">
                <small id="phoneHelp" class="form-text text-danger" style="display: none;">Nomor telepon harus diawali dengan 08 dan hanya terdiri dari angka.</small>
            </div>
            <div class="mb-3">
                <label for="domisili" class="form-label">domisili</label>
                <input type="text" class="form-control" id="domisili" name="domisili">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal">
            </div>

            <div class="mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
            </div>
            <div class="mb-3">
                <label for="nama_kantor" class="form-label">Nama Kantor</label>
                <input type="text" class="form-control" id="nama_kantor" name="nama_kantor">
            </div>

            <div class="mb-3">
                <label for="perumahan" class="form-label block mb-2 text-sm font-medium ">Perumahan</label>
                <select id="perumahan" name="perumahan"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    <option value="pilih">-- Pilih --</option>
                    @foreach ($perumahan as $item)
                        {{-- <option value="{{ $item->id }}">{{ $item->nama_perumahan }}</option> --}}
                        <option value="{{ $item->perumahan }}">{{ $item->perumahan }}</option>
                    @endforeach
                </select>

            </div>

            <div class="mb-3">
                <label for="sumber_informasi" class="form-label">Sumber Informasi</label><br>
                <select class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    id="sumber_informasi" name="sumber_informasi">
                    <option selected disabled>-- Pilih --</option>

                    <option name="sumber_informasi" value="Instagram Linear">Instagram Aradev</option>
                    <option name="sumber_informasi" value="Tiktok">Tiktok</option>
                    <option name="sumber_informasi" value="Brosur">Brosur</option>
                    <option name="sumber_informasi" value="Spanduk">Spanduk</option>
                    <option name="sumber_informasi" value="Youtube Linear">Youtube Linear</option>
                    <option name="sumber_informasi" value="Instagram Perumahan">Instagram Perumahan</option>
                    <option name="sumber_informasi" value="Walk In">Walk In Customer</option>
                    <option name="sumber_informasi" value="agent">Agent</option>
                    <option name="sumber_informasi" value="Dll">Dll</option>
                    </optgroup>
                </select>

            </div>
            <div class="agent flex w-full gap-4">
                <div class="w-full">
                    <label for="agent_id" class="form-label block mb-2 text-sm font-medium">Nama Agent</label>
                    <select id="agent_id" name="agent_id"
                        class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"">
                        <option value="pilih">-- Pilih --</option>
                        @foreach ($agent as $item) <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->kantor }}</option> @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.konsumen') }}">Back</a>
        </form>

		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>

  </div>
</div>

</section>

<script>
    var selectInput2 = document.getElementById('sumber_informasi');
    var agentDiv2 = document.querySelector('.agent');
    agentDiv2.style.display = 'none'; // Default tidak ditampilkan

    selectInput2.addEventListener('change', function() {
        if (this.value === 'agent') {
            agentDiv2.style.display = 'block';
        } else {
            agentDiv2.style.display = 'none';
        }
    });



    document.getElementById('sumber_informasi').addEventListener('change', function() {
        var kantorInput = document.getElementById('kantor');
        if (this.value === 'perorangan') {
            kantorInput.value = 'N/A';
            kantorInput.disabled = true;
        } else {
            kantorInput.value = '';
            kantorInput.disabled = false;
            f
        }
    });
    function validatePhoneNumber() {
        var phoneInput = document.getElementById('no_hp');
        var phoneHelp = document.getElementById('phoneHelp');
        var phonePattern = /^08\d+$/;

        if (!phonePattern.test(phoneInput.value)) {
            phoneHelp.style.display = 'block';
        } else {
            phoneHelp.style.display = 'none';
        }
    }

</script>


@endsection




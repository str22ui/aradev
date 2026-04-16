@extends('admin.layouts.index', ['title' => 'Edit Data Penawaran', 'page_heading' => 'Edit Data Penawaran'])

@section('content')
    <section class="row">
        <div class="col card px-3 py-3">

            <div class="my-3 p-3 rounded">

                <!-- Table untuk memanggil data dari database -->
                @include('sweetalert::alert')
                {{-- <form method="post" action="" enctype="multipart/form-data"> --}}
                <form method="POST" action="{{ route('admin.updatePenawaran', ['id' => $penawaran->id]) }}"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')
                    {{-- Title --}}
                    <div class="mb-3" hidden>
                        <input type="hidden" value="0" name="views">
                        <label for="user_id" class="form-label">User</label>
                        <input type="text" value="{{ $penawaran->user_id }}" name="user_id" id="user_id"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="no_kavling" class="form-label">No Kavling</label>
                        <input type="text" class="form-control" id="no_kavling" name="no_kavling"
                            value="{{ $penawaran->rumah->no_kavling }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="perumahan_id" class="form-label">Nama Perumahan</label>
                        <input type="text" class="form-control" id="perumahan_id" name="perumahan_id"
                            value="{{ $penawaran->perumahan->perumahan }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="rumah_id" class="form-label">No Kavling</label>
                        <select name="rumah_id" id="rumah_id" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach ($rumah as $r)
                                <option value="{{ $r->id }}" {{ $penawaran->rumah_id == $r->id ? 'selected' : '' }}>
                                    {{ $r->no_kavling }} - {{ $r->posisi }} ({{ $r->status }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Konsumen</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ $penawaran->nama }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ $penawaran->email }}">
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor Handphone (Cont : 0812xxxxx)</label>
                        <input type="number" class="form-control" id="no_hp" name="no_hp" pattern="08[0-9]{8,}"
                            title="Nomor harus diawali dengan 08 dan hanya terdiri dari angka"
                            oninput="validatePhoneNumber()" value="{{ $penawaran->no_hp }}">
                        <small id="phoneHelp" class="form-text text-danger" style="display: none;">Nomor telepon harus
                            diawali dengan 08 dan hanya terdiri dari angka.</small>
                    </div>

                    <div class="mb-3">
                        <label for="domisili" class="form-label">Domisili</label>
                        <input type="text" class="form-control" id="domisili" name="domisili"
                            value="{{ $penawaran->domisili }}">
                    </div>

                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label><br>
                        <select
                            class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="pekerjaan" name="pekerjaan" value="{{ $penawaran->pekerjaan }}">
                            <option selected value="{{ $penawaran->pekerjaan }}">
                                {{ $penawaran->pekerjaan }}</option>
                            <option value="ASN">ASN</option>
                            <option value="BUMN">BUMN</option>
                            <option value="Pegawai Swasta">Pegawai Swasta</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                            <option value="Dll">Dll</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kantor" class="form-label">Nama Kantor</label>
                        <input type="text" class="form-control" id="nama_kantor" name="nama_kantor"
                            value="{{ $penawaran->nama_kantor }}">
                    </div>

                    <div class="mb-3">
                        <label for="payment" class="form-label">Payment</label><br>
                        <select
                            class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="payment" name="payment" value="{{ $penawaran->payment }}">
                            <option selected value="{{ $penawaran->payment }}">
                                {{ $penawaran->payment }}</option>
                            <option value="Cash Keras">Cash Keras</option>
                            <option value="KPR">KPR</option>
                            <option value="Cash Bertahap">Cash Bertahap</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="income" class="form-label">Income</label><br>
                        <select
                            class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="income" name="income" value="{{ $penawaran->income }}">
                            <option selected value="{{ $penawaran->income }}">
                                {{ $penawaran->income }}</option>
                            <option value="Single">Single</option>
                            <option value="Join">Join</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dp" class="form-label">DP</label><br>
                        <select
                            class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="dp" name="dp" value="{{ $penawaran->dp }}">
                            <option selected value="{{ $penawaran->dp }}">
                                {{ $penawaran->dp }}</option>
                            <option value="0%">0%</option>
                            <option value="10%-30%">10% sd 30%</option>
                            <option value=">30%">>30%</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga_pengajuan" class="form-label">Harga Penawaran</label>
                        <input type="text" class="form-control" id="harga_pengajuan" name="harga_pengajuan"
                            value="{{ $penawaran->harga_pengajuan }}" oninput="formatHarga(this)">
                    </div>

                    <div class="mb-3">
                        <label for="sumber_informasi" class="form-label">Sumber Informasi</label><br>
                        <select
                            class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="sumber_informasi" name="sumber_informasi" value="{{ $penawaran->sumber_informasi }}">
                            <option selected value="{{ $penawaran->sumber_informasi }}">
                                {{ $penawaran->sumber_informasi }}</option>
                            <option name="sumber_informasi" value="Instagram Aradev">Instagram Aradev</option>
                            <option name="sumber_informasi" value="Instagram Perumahan">Instagram Perumahan</option>
                            <option name="sumber_informasi" value="Youtube">Youtube</option>
                            <option name="sumber_informasi" value="Tiktok">Tiktok</option>
                            <option name="sumber_informasi" value="Brosur">Brosur</option>
                            <option name="sumber_informasi" value="Spanduk">Spanduk</option>
                            <option name="sumber_informasi" value="Walk In Customer">Walk In Customer</option>
                            <option name="sumber_informasi" value="Agent">Agent</option>
                            <option name="sumber_informasi" value="Affiliate">Affiliate</option>
                            <option name="sumber_informasi" value="Dll">Dll</option>
                        </select>
                    </div>

                    <div class="agent flex w-full gap-4 mb-4"
                        style="display: {{ $penawaran->sumber_informasi == 'agent' ? 'block' : 'none' }};">
                        <div class="w-full">
                            <label for="agent_id" class="form-label block mb-2 text-sm font-medium">Nama Agent</label>
                            <select id="agent_id" name="agent_id"
                                class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">-- Pilih --</option>
                                @foreach ($agent as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $penawaran->agent_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }} - {{ $item->kantor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="affiliate flex w-full gap-4 mb-4"
                        style="display: {{ $penawaran->sumber_informasi == 'Affiliate' ? 'block' : 'none' }};">
                        <div class="w-full">
                            <label for="affiliate_id" class="form-label block mb-2 text-sm font-medium">Nama
                                Affiliate</label>
                            <select id="affiliate_id" name="affiliate_id"
                                class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"">
                                <option value="">-- Pilih --</option>
                                @foreach ($affiliate as $a)
                                    <option value="{{ $a->id }}"
                                        {{ isset($penawaran->affiliate_id) && $a->id == $penawaran->affiliate_id ? 'selected' : '' }}>
                                        {{ $a->name }} ({{ $a->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a class="btn btn-danger" href="{{ route('admin.penawaran') }}">Back</a>
                </form>

                {{-- Menampilkan total pemasukan --}}
                <div class="d-flex align-items-end flex-column p-2 mb-2">
                    {{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
                </div>

            </div>
        </div>

    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var selectInput = document.getElementById('sumber_informasi');
            var agentDiv = document.querySelector('.agent');
            var affiliateDiv = document.querySelector('.affiliate');

            function toggleFields() {
                var selectedValue = selectInput.value;

                if (selectedValue === 'agent') {
                    agentDiv.style.display = 'block';
                    affiliateDiv.style.display = 'none';
                } else if (selectedValue === 'Affiliate') {
                    agentDiv.style.display = 'none';
                    affiliateDiv.style.display = 'block';
                } else {
                    agentDiv.style.display = 'none';
                    affiliateDiv.style.display = 'none';
                }
            }

            // Set kondisi awal berdasarkan nilai yang sudah tersimpan di database
            toggleFields();

            // Tambahkan event listener untuk memantau perubahan pada select
            selectInput.addEventListener('change', toggleFields);
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

        function formatHarga(input) {
            // Menghapus semua karakter yang bukan angka
            let value = input.value.replace(/\D/g, '');

            // Memformat angka dengan menambahkan titik setiap 3 digit
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                // Tambahkan titik setiap 3 digit dari belakang
                if (i > 0 && (value.length - i) % 3 === 0) {
                    formattedValue += '.';
                }
                formattedValue += value[i];
            }

            // Mengupdate nilai input
            input.value = formattedValue;
        }
    </script>
@endsection

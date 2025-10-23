@extends('admin.layouts.index', ['title' => 'Tambah Data Penawaran', 'page_heading' => 'Tambah Data Penawaran'])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            @include('sweetalert::alert')
            <form method="post" action="{{ route('admin.storePenawaran') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3" hidden>
                    <input type="hidden" value="0" name="views">
                    <label for="user_id" class="form-label">User</label>
                    <input type="text" value="{{ Auth::check() ? Auth::user()->id : '' }}" name="user_id" id="user_id" class="form-control">
                </div>

                {{-- Data Lengkap dari Form Frontend --}}

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" value="{{ old('nama') }}" name="nama" id="nama" placeholder="Masukkan Nama" class="form-control">
                    @error('nama')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" value="{{ old('email') }}" name="email" id="email" placeholder="Masukkan Email" class="form-control">
                    @error('email')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" value="{{ old('no_hp') }}" name="no_hp" id="no_hp" placeholder="Masukkan Nomor HP" class="form-control">
                    @error('no_hp')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="domisili" class="form-label">Domisili</label>
                    <input type="text" value="{{ old('domisili') }}" name="domisili" id="domisili" placeholder="Masukkan Kota Domisili" class="form-control">
                    @error('domisili')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <select name="pekerjaan" id="pekerjaan" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="ASN">ASN</option>
                        <option value="BUMN">BUMN</option>
                        <option value="Pegawai Swasta">Pegawai Swasta</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Dll">Dll</option>
                    </select>
                    @error('pekerjaan')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_kantor" class="form-label">Nama Kantor</label>
                    <input type="text" name="nama_kantor" id="nama_kantor" placeholder="Masukkan Nama Kantor" value="{{ old('nama_kantor') }}" class="form-control">
                    @error('nama_kantor')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Data Lama + Properti --}}
                 <div class="flex w-full gap-4 mb-5">
                {{-- <div class="w-full">
                    <label for="rumah_id" class="form-label block mb-2 text-sm font-medium"><i class="fas fa-home text-gray-400 mr-2"></i>No Kavling</label>
                    <select id="rumah_id" name="rumah_id"
                        class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- Pilih --</option>
                        @foreach ($rumah as $r)
                            <option value="{{ $r->id }}"
                                data-lt="{{ $r->luas_tanah }}"
                                data-lb="{{ $r->luas_bangunan }}"
                                data-posisi="{{ $r->posisi }}"
                                data-harga="Rp {{ $r->harga }}
                                {{ $r->status !== 'Available' ? 'disabled' : '' }}>
                                {{ $r->no_kavling }}
                                {{ $r->status !== 'Available' ? '(' . $r->status . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('rumah_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div> --}}
            </div>

                <div class="mb-3">
                    <label for="luas_tanah" class="form-label">Luas Tanah</label>
                    <input type="text" name="luas_tanah" id="luas_tanah" placeholder="Masukkan Luas Tanah" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="luas_bangunan" class="form-label">Luas Bangunan</label>
                    <input type="text" name="luas_bangunan" id="luas_bangunan" placeholder="Masukkan Luas Bangunan" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="posisi" class="form-label">Posisi</label>
                    <select name="posisi" id="posisi" class="form-select">
                        <option value="Badan">Badan</option>
                        <option value="Hoek">Hoek</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" name="harga" id="harga" placeholder="Masukkan Harga" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="perumahan_id" class="form-label">Perumahan</label>
                    <select name="perumahan_id" id="perumahan_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach ($perumahan as $item)
                            <option value="{{ $item->id }}">{{ $item->perumahan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Available">Available</option>
                        <option value="DP">DP</option>
                        <option value="Sold">Sold</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin.penawaran') }}" class="btn btn-danger">Back</a>
            </form>
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
</script>


@endsection




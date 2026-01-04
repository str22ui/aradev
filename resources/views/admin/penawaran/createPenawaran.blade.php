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
                        <input type="text" value="{{ Auth::check() ? Auth::user()->id : '' }}" name="user_id"
                            id="user_id" class="form-control">
                    </div>

                    {{-- Data Lengkap dari Form Frontend --}}

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" value="{{ old('nama') }}" name="nama" id="nama"
                            placeholder="Masukkan Nama" class="form-control" required>
                        @error('nama')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" value="{{ old('email') }}" name="email" id="email"
                            placeholder="Masukkan Email" class="form-control">
                        @error('email')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" value="{{ old('no_hp') }}" name="no_hp" id="no_hp"
                            placeholder="Masukkan Nomor HP" class="form-control">
                        @error('no_hp')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="domisili" class="form-label">Domisili</label>
                        <input type="text" value="{{ old('domisili') }}" name="domisili" id="domisili"
                            placeholder="Masukkan Kota Domisili" class="form-control">
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
                        <input type="text" name="nama_kantor" id="nama_kantor" placeholder="Masukkan Nama Kantor"
                            value="{{ old('nama_kantor') }}" class="form-control">
                        @error('nama_kantor')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="perumahan_id" class="form-label">Perumahan</label>
                        <select name="perumahan_id" id="perumahan_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($perumahan as $item)
                                <option value="{{ $item->id }}">{{ $item->perumahan }}</option>
                            @endforeach
                        </select>
                        @error('perumahan_id')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="rumah_id" class="form-label">No Kavling</label>
                        <select name="rumah_id" id="rumah_id" class="form-select" required>
                            <option value="">-- Pilih Perumahan Dulu --</option>
                        </select>
                        <small class="text-muted">Pilih perumahan terlebih dahulu untuk melihat kavling yang
                            tersedia</small>
                        @error('rumah_id')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment" class="form-label">Payment</label>
                        <select name="payment" id="payment" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Cash Keras">Cash Keras</option>
                            <option value="KPR">KPR</option>
                            <option value="Cash Bertahap">Cash Bertahap</option>
                        </select>
                        @error('payment')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="income" class="form-label">Income</label>
                        <select name="income" id="income" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Single">Single</option>
                            <option value="Join">Join</option>
                        </select>
                        @error('income')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dp" class="form-label">DP</label>
                        <select name="dp" id="dp" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="0%">0%</option>
                            <option value="10%-30%">10% sd 30%</option>
                            <option value=">30%">>30%</option>
                        </select>
                        @error('dp')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga_pengajuan" class="form-label">Harga Penawaran</label>
                        <input type="text" name="harga_pengajuan" id="harga_pengajuan"
                            placeholder="Masukkan Harga Penawaran" class="form-control" oninput="formatHarga(this)"
                            required>
                        @error('harga_pengajuan')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sumber_informasi" class="form-label">Sumber Informasi</label>
                        <select name="sumber_informasi" id="sumber_informasi" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Instagram Aradev">Instagram Aradev</option>
                            <option value="Instagram Perumahan">Instagram Perumahan</option>
                            <option value="Youtube">Youtube</option>
                            <option value="Tiktok">Tiktok</option>
                            <option value="Brosur">Brosur</option>
                            <option value="Spanduk">Spanduk</option>
                            <option value="Walk in">Walk in Customer</option>
                            <option value="Agent">Agent</option>
                            <option value="Affiliate">Affiliate</option>
                            <option value="Dll">Dll</option>
                        </select>
                        @error('sumber_informasi')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="agent flex w-full gap-4 mb-4" style="display: none;">
                        <div class="w-full">
                            <label for="agent_id" class="form-label">Nama Agent</label>
                            <select name="agent_id" id="agent_id" class="form-select">
                                <option value="">-- Pilih --</option>
                                @foreach ($agent as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }} - {{ $a->kantor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="affiliate flex w-full gap-4 mb-4" style="display: none;">
                        <div class="w-full">
                            <label for="affiliate_id" class="form-label">Nama Affiliate</label>
                            <select name="affiliate_id" id="affiliate_id" class="form-select">
                                <option value="">-- Pilih --</option>
                                @foreach ($affiliate as $af)
                                    <option value="{{ $af->id }}">{{ $af->name }} ({{ $af->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('admin.penawaran') }}" class="btn btn-danger">Back</a>
                </form>
            </div>
        </div>
    </section>
    <script>
        function formatHarga(input) {
            let value = input.value.replace(/\D/g, '');
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && (value.length - i) % 3 === 0) {
                    formattedValue += '.';
                }
                formattedValue += value[i];
            }
            input.value = formattedValue;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sumberInfo = document.getElementById('sumber_informasi');
            const agentDiv = document.querySelector('.agent');
            const affiliateDiv = document.querySelector('.affiliate');
            const perumahanSelect = document.getElementById('perumahan_id');
            const rumahSelect = document.getElementById('rumah_id');

            // Show/Hide Agent & Affiliate
            sumberInfo.addEventListener('change', function() {
                agentDiv.style.display = 'none';
                affiliateDiv.style.display = 'none';

                if (this.value === 'Agent') {
                    agentDiv.style.display = 'block';
                } else if (this.value === 'Affiliate') {
                    affiliateDiv.style.display = 'block';
                }
            });

            // Load rumah berdasarkan perumahan
            perumahanSelect.addEventListener('change', function() {
                const perumahanId = this.value;
                rumahSelect.innerHTML = '<option value="">-- Loading... --</option>';

                if (perumahanId) {
                    fetch(`/api/rumah/perumahan/${perumahanId}`)
                        .then(response => response.json())
                        .then(data => {
                            rumahSelect.innerHTML = '<option value="">-- Pilih No Kavling --</option>';
                            data.forEach(rumah => {
                                const option = document.createElement('option');
                                option.value = rumah.id;
                                option.textContent =
                                    `${rumah.no_kavling} - ${rumah.posisi} (${rumah.status})`;
                                if (rumah.status !== 'Available') {
                                    option.disabled = true;
                                }
                                rumahSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            rumahSelect.innerHTML =
                            '<option value="">-- Error loading data --</option>';
                        });
                } else {
                    rumahSelect.innerHTML = '<option value="">-- Pilih Perumahan Dulu --</option>';
                }
            });
        });
    </script>
@endsection

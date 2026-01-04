<!-- Debug Error -->
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mx-5" role="alert">
        <strong class="font-bold">Terjadi kesalahan!</strong>
        <ul class="mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mx-5 mt-2 md:mt-24 mb-10">
    <div class="md:mb-10 text-center pt-18">
        <img class="w-3/4 mx-auto md:w-1/4" src="{{ asset('images/logo.png') }}" alt="">
        <h2 class="text-xl font-bold mt-6 text-blue-700">
            <label for="" class="text-blue-900 uppercase">[{{ $selectedPerumahan->perumahan }}]</label>
            Penawaran Konsumen
        </h2>
    </div>

    <form method="post" action="{{ route('form.penawaran') }}"
        class="px-5 py-5 grid grid-cols-1 md:grid-cols-2 gap-4 text-col rounded-md">
        @csrf

        <!-- Bagian kiri form -->
        <div class="text-blue-700 mx-5">
            <div class="mb-5 relative">
                <label for="nama" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-user text-gray-400 mr-2"></i>Nama
                </label>
                <input type="text" id="nama" name="nama"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5 relative">
                <label for="no_hp" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-phone text-gray-400 mr-2"></i>Nomor Telepon
                </label>
                <input type="tel" id="no_hp" name="no_hp"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan no hp" value="{{ old('no_hp') }}" required>
                @error('no_hp')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5 relative">
                <label for="domisili" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-city text-gray-400 mr-2"></i>Domisili
                </label>
                <input type="text" id="domisili" name="domisili"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan Kota" value="{{ old('domisili') }}" required>
                @error('domisili')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="pekerjaan" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-briefcase text-gray-400 mr-2"></i>Pekerjaan
                </label>
                <select id="pekerjaan" name="pekerjaan"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="ASN" {{ old('pekerjaan') == 'ASN' ? 'selected' : '' }}>ASN</option>
                    <option value="BUMN" {{ old('pekerjaan') == 'BUMN' ? 'selected' : '' }}>BUMN</option>
                    <option value="Pegawai Swasta" {{ old('pekerjaan') == 'Pegawai Swasta' ? 'selected' : '' }}>Pegawai
                        Swasta</option>
                    <option value="Wiraswasta" {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta
                    </option>
                    <option value="Dll" {{ old('pekerjaan') == 'Dll' ? 'selected' : '' }}>Dll</option>
                </select>
                @error('pekerjaan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <input type="hidden" name="perumahan_id" value="{{ $selectedPerumahan->id }}">

            <div class="mb-5">
                <label for="sumber_informasi" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-users text-gray-400 mr-2"></i>Dapat Informasi Dari
                </label>
                <select id="sumber_informasi" name="sumber_informasi"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="">-- Pilih Sumber Informasi --</option>
                    <option value="Instagram Aradev">Instagram Aradev</option>
                    <option value="Instagram Perumahan">Instagram Perumahan</option>
                    <option value="Youtube">Youtube</option>
                    <option value="Tiktok">Tiktok</option>
                    <option value="Brosur">Brosur</option>
                    <option value="Spanduk">Spanduk</option>
                    <option value="Walk in">Walk in Customer</option>
                    <option value="Agent">Agent</option>
                    <option value="Affiliate">Affiliate</option>
                    <option value="Sales">Sales</option>
                    <option value="Dll">Dll</option>
                </select>
                @error('sumber_informasi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Div untuk Agent -->
            <div class="agent flex w-full gap-4 mb-5" style="display: none;">
                <div class="w-full">
                    <label for="agent_id" class="form-label block mb-2 text-sm font-medium">Nama Agent</label>
                    <select id="agent_id" name="agent_id"
                        class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- Pilih --</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }} - {{ $agent->kantor }}</option>
                        @endforeach
                    </select>
                    @error('agent_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Div untuk Affiliate -->
            <div class="affiliate flex w-full gap-4 mb-5" style="display: none;">
                <div class="w-full">
                    <label for="affiliate_id" class="form-label block mb-2 text-sm font-medium">Nama Affiliate</label>
                    <select id="affiliate_id" name="affiliate_id"
                        class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- Pilih --</option>
                        @foreach ($affiliate as $a)
                            <option value="{{ $a->id }}">{{ $a->name }} ({{ $a->code }})</option>
                        @endforeach
                    </select>
                    @error('affiliate_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Div untuk Sales -->
            <div class="sales flex w-full gap-4 mb-5" style="display: none;">
                <div class="w-full">
                    <label for="user_id" class="form-label block mb-2 text-sm font-medium">Nama Sales</label>
                    <select id="user_id" name="user_id"
                        class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- Pilih --</option>
                        @foreach ($sales as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-5">
                <label for="rumah_id" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-home text-gray-400 mr-2"></i>No Kavling
                </label>
                <select id="rumah_id" name="rumah_id"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="">-- Pilih --</option>
                    @foreach ($rumah as $r)
                        <option value="{{ $r->id }}" data-lt="{{ $r->luas_tanah }}"
                            data-lb="{{ $r->luas_bangunan }}" data-posisi="{{ $r->posisi }}"
                            data-harga="Rp {{ $r->harga ? number_format((float) $r->harga, 0, ',', '.') : '0' }}"
                            {{ $r->status !== 'Available' ? 'disabled' : '' }}>
                            {{ $r->no_kavling }} {{ $r->status !== 'Available' ? '(' . $r->status . ')' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('rumah_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Bagian kanan form -->
        <div class="text-blue-700 mx-5">
            <div class="mb-5 relative">
                <label for="luas_tanah" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-map-pin text-gray-400 mr-2"></i>Luas Tanah
                </label>
                <input type="text" id="luas_tanah" name="luas_tanah"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    readonly>
            </div>

            <div class="mb-5 relative">
                <label for="luas_bangunan" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-map-marker text-gray-400 mr-2"></i>Luas Bangunan
                </label>
                <input type="text" id="luas_bangunan" name="luas_bangunan"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    readonly>
            </div>

            <div class="mb-5 relative">
                <label for="posisi" class="form-label block mb-2 text-sm font-medium">
                    <i class="fas fa-map text-gray-400 mr-2"></i>Posisi
                </label>
                <input type="text" id="posisi" name="posisi"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    readonly>
            </div>

            <div class="mb-5 relative">
                <label for="harga" class="form-label block mb-2 text-sm font-medium">
                    <i class="fa-solid fa-money-bill text-gray-400 mr-2"></i>Harga
                </label>
                <input type="text" id="harga" name="harga"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    readonly>
            </div>

            <div class="mb-5">
                <label for="payment" class="form-label block mb-2 text-sm font-medium">
                    <i class="fa fa-credit-card text-gray-400 mr-2"></i>Payment
                </label>
                <select id="payment" name="payment"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="Cash Keras">Cash Keras</option>
                    <option value="KPR">KPR</option>
                    <option value="Cash Bertahap">Cash Bertahap</option>
                </select>
                @error('payment')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="dp" class="form-label block mb-2 text-sm font-medium">
                    <i class="fa fa-percent text-gray-400 mr-2"></i>DP
                </label>
                <select id="dp" name="dp"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="0%">0%</option>
                    <option value="10%-30%">10% sd 30%</option>
                    <option value=">30%">>30%</option>
                </select>
                @error('dp')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="income" class="form-label block mb-2 text-sm font-medium">
                    <i class="fa fa-arrow-down text-gray-400 mr-2"></i>Income
                </label>
                <select id="income" name="income"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="Single">Single</option>
                    <option value="Join">Join</option>
                </select>
                @error('income')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5 relative">
                <label for="harga_pengajuan" class="form-label block mb-2 text-sm font-medium">
                    <i class="fa-solid fa-money-bill text-gray-400 mr-2"></i>Harga Penawaran
                </label>
                <input type="text" id="harga_pengajuan" name="harga_pengajuan"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan harga penawaran" oninput="formatHarga(this)" required>
                @error('harga_pengajuan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="w-full flex justify-center md:justify-start md:ml-5 md:col-span-2">
            <button type="submit" id="submitBtn"
                class="text-white w-3/4 md:w-1/3 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Submit Penawaran
            </button>
        </div>
    </form>
</div>
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#1d4ed8',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
@endif

<script>
    // Format harga - function global
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

    // Main script
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Script loaded successfully');

        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');

        if (!form) {
            console.error('Form tidak ditemukan!');
            return;
        }

        if (!submitBtn) {
            console.error('Submit button tidak ditemukan!');
            return;
        }

        console.log('Form dan Submit button ditemukan');

        // Show/Hide dropdown berdasarkan sumber informasi
        const sumberInfo = document.getElementById('sumber_informasi');
        if (sumberInfo) {
            sumberInfo.addEventListener('change', function() {
                const value = this.value;
                console.log('Sumber informasi dipilih:', value);

                const agentDiv = document.querySelector('.agent');
                const affiliateDiv = document.querySelector('.affiliate');
                const salesDiv = document.querySelector('.sales');

                // Hide & reset semua
                if (agentDiv) agentDiv.style.display = 'none';
                if (affiliateDiv) affiliateDiv.style.display = 'none';
                if (salesDiv) salesDiv.style.display = 'none';

                const agentSelect = document.getElementById('agent_id');
                const affiliateSelect = document.getElementById('affiliate_id');
                const salesSelect = document.getElementById('user_id');

                if (agentSelect) agentSelect.value = '';
                if (affiliateSelect) affiliateSelect.value = '';
                if (salesSelect) salesSelect.value = '';

                // Show sesuai pilihan
                if (value === 'Agent' && agentDiv) {
                    agentDiv.style.display = 'block';
                } else if (value === 'Affiliate' && affiliateDiv) {
                    affiliateDiv.style.display = 'block';
                } else if (value === 'Sales' && salesDiv) {
                    salesDiv.style.display = 'block';
                }
            });
        }

        // Auto-fill data rumah
        const rumahSelect = document.getElementById('rumah_id');
        if (rumahSelect) {
            rumahSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                console.log('Rumah dipilih:', selectedOption.value);

                const luasTanahInput = document.getElementById('luas_tanah');
                const luasBangunanInput = document.getElementById('luas_bangunan');
                const posisiInput = document.getElementById('posisi');
                const hargaInput = document.getElementById('harga');

                if (luasTanahInput) luasTanahInput.value = selectedOption.dataset.lt || '';
                if (luasBangunanInput) luasBangunanInput.value = selectedOption.dataset.lb || '';
                if (posisiInput) posisiInput.value = selectedOption.dataset.posisi || '';
                if (hargaInput) hargaInput.value = selectedOption.dataset.harga || '';
            });
        }

        // Validasi form sebelum submit
        form.addEventListener('submit', function(e) {
            console.log('Form sedang disubmit...');

            const requiredFields = [{
                    name: 'nama',
                    label: 'Nama'
                },
                {
                    name: 'no_hp',
                    label: 'Nomor Telepon'
                },
                {
                    name: 'domisili',
                    label: 'Domisili'
                },
                {
                    name: 'pekerjaan',
                    label: 'Pekerjaan'
                },
                {
                    name: 'sumber_informasi',
                    label: 'Sumber Informasi'
                },
                {
                    name: 'rumah_id',
                    label: 'No Kavling'
                },
                {
                    name: 'payment',
                    label: 'Payment'
                },
                {
                    name: 'dp',
                    label: 'DP'
                },
                {
                    name: 'income',
                    label: 'Income'
                },
                {
                    name: 'harga_pengajuan',
                    label: 'Harga Penawaran'
                }
            ];

            let emptyFields = [];
            requiredFields.forEach(field => {
                const input = document.querySelector(`[name="${field.name}"]`);
                if (!input || !input.value) {
                    emptyFields.push(field.label);
                }
            });

            if (emptyFields.length > 0) {
                e.preventDefault();
                console.log('Field yang kosong:', emptyFields);

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        html: 'Harap lengkapi field berikut:<br><ul style="text-align:left; margin: 10px 0; padding-left: 20px;">' +
                            emptyFields.map(f => '<li>' + f + '</li>').join('') + '</ul>',
                        confirmButtonColor: '#f59e0b',
                    });
                } else {
                    alert('Harap lengkapi field: ' + emptyFields.join(', '));
                }
                return false;
            }

            // Show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            console.log('Form valid, mengirim data...');

            // Form akan otomatis submit setelah ini
        });
    });
</script>

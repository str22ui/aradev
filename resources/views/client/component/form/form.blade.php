<div class="mx-5 mt-2 md:mt-24 mb-10  ">

    <div class="md:mb-10 text-center pt-18">
        <img class="w-3/4 mx-auto md:w-1/4" src="{{ asset('images/logo.png') }}" alt="">
        {{-- <h2 class="text-2xl text-center font-bold mb-6">Please Fill This Form Below </h2> --}}
        <h2 class="text-xl font-bold mt-6 text-blue-700 "><label for="" class="text-blue-900 uppercase">[
                {{ $selectedPerumahan->perumahan }}]</label> E-Booklet & Pricelist Request</h2>

    </div>
    <form method="POST" action="/form-create/{{ $selectedPerumahan->id }}"
        class="px-5 py-5 grid grid-cols-1 md:grid-cols-2 gap-4 text-col rounded-md">
        @csrf
        <!-- Bagian kiri form -->
        <div class="text-blue-700 mx-5  ">
            {{-- <button type="button" name="button"
                class="text-blue-500 w-full md:w-1/4 bg-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">{{ $units->nama_perumahan }}</button> --}}
            <div class="mb-5 relative">
                <label for="nama_konsumen" class="form-label block mb-2 text-sm font-medium"> <i class="fas fa-user text-gray-400 mr-2"></i>Nama</label>
                <div class="input-with-icon">
                    <input type="text" id="name_konsumen" name="nama_konsumen"
                        class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="Masukkan nama"  value="{{ old('nama_konsumen') }}" required>
                     @error('nama_konsumen')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-5 relative">
                <label for="email" class="form-label block mb-2 text-sm font-medium "> <i class="fas fa-envelope text-gray-400 mr-2"></i>Email</label>
                <div class="input-with-icon">
                    <input type="email" id="email-input" name="email"
                        class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "
                        placeholder="Masukkan email" value="{{ old('email') }}">
                     @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    </div>
            </div>
            <div class="mb-5 relative">
                <label for="no_hp" class="form-label block mb-2 text-sm font-medium"><i class="fas fa-phone text-gray-400 mr-2"></i>Nomor
                    Telepon</label>
                <div class="input-with-icon">
                    <input type="number" id="phone-input" name="no_hp"
                        class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="Masukkan no hp"  value="{{ old('no_hp') }}" required>
                        @error('no_hp')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="mb-5 relative">
                <label for="domisili" class="form-label block mb-2 text-sm font-medium ">
                        <i class="fas fa-city text-gray-400 mr-2"></i>Domisili</label>
                <div class="input-with-icon">
                    <input type="text" id="city-input" name="domisili"
                        class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="Masukkan Kota" value="{{ old('domisili') }}"required>
                        @error('domisili')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    </div>
            </div>
        </div>

        <!-- Bagian kanan form -->
        <div class="text-blue-700 mx-5  ">

            <div class="mb-5">
                <label for="pekerjaan" class="form-label block mb-2 text-sm font-medium"><i class="fas fa-user text-gray-400 mr-2"></i>Pekerjaan</label>
                <select id="pekerjaaan" name="pekerjaan"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  ">
                    <option value="">-- Pilih --</option>
                    <option value="ASN">ASN</option>
                    <option value="BUMN">BUMN</option>
                    <option value="Pegawai Swasta">Pegawai Swasta</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Dll">Dll</option>
                </select>
                @error('pekerjaan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            {{-- ===== Perlu Ditambah ====== --}}
            <div class="mb-5 relative">
                <label for="nama_kantor" class="form-label block mb-2 text-sm font-medium"><i class="fas fa-briefcase text-gray-400 mr-2"></i>Nama Kantor
                </label>
                <div class="input-with-icon">

                    <input type="text" id="city-input" name="nama_kantor"
                        class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "
                        placeholder="Masukkan nama kantor" value="{{ old('nama_kantor') }}" required>
                        @error('nama_kantor')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-5" hidden>

                <input type="text" id="city-input" name="perumahan" value=" {{ $selectedPerumahan->perumahan }}"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            </div>
            {{-- ===== Perlu Ditambah === --}}
            <div id="dropdown-section" class="mb-5">
                <label for="sumber_informasi" class="form-label block mb-2 text-sm font-medium">Dapat Informasi Dari (Dropdown)</label>
                <select id="sumber_informasi" name="sumber_informasi"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Pilih Sumber Informasi --</option>
                    <option name="sumber_informasi" value="Instagram Aradev">Instagram Aradev</option>
                    <option name="sumber_informasi" value="Instagram Perumahan">Instagram Perumahan</option>
                    <option name="sumber_informasi" value="Youtube">Youtube</option>
                    <option name="sumber_informasi" value="Tiktok">Tiktok</option>
                    <option name="sumber_informasi" value="Brosur">Brosur</option>
                    <option name="sumber_informasi" value="Spanduk">Spanduk</option>
                    <option name="sumber_informasi" value="Walk in">Walk in Customer</option>
                    <option name="sumber_informasi" value="Agent">Agent</option>
                    <option name="sumber_informasi" value="Dll">Dll</option>
                </select>
                @error('sumber_informasi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>
                <div class="agent flex w-full gap-4">
                    <div class="w-full">
                        <label for="agent_id" class="form-label block mb-2 text-sm font-medium ">Nama Agent</label>
                        <select id="agent_id" name="agent_id"
                            class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">-- Pilih --</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" data-kantor="{{ $agent->kantor }}">{{ $agent->nama }} - {{ $agent->kantor }}</option>
                            @endforeach
                        </select>
                        @error('agent_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    </div>
                </div>
            </div>


        </div>

        <div class="w-full flex justify-center md:justify-start md:ml-5  ">
            <button type="submit" name="submit"
                class="text-white w-3/4 bg-blue-700 hover:bg-blue-800 hover:text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Submit</button>
        </div>

    </form>
</div>
<script>

</script>

@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}
<div class="mx-auto bg-gray-100  px-4 mt-24 pt-12">
    <div class="container mx-auto py-12 px-6">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Detail Properti</h1>

        <!-- Konten Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Gambar Properti -->
            <div class="relative">
                <!-- Tombol Navigasi Kiri -->
                <button id="befBtn" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Container Slider -->
                <div id="slider" class="overflow-hidden w-full max-w-4xl mx-auto">
                    <div id="sliderContent" class="flex transition-transform duration-500">
                        @foreach ($secondary->imagesSecondary as $image)
                        @section('gambar', asset('storage/' . $image->image_path))
                            <div class="min-w-full">
                                <div class="aspect-w-4 aspect-h-3">
                                    <img class="w-full h-full object-cover rounded-lg shadow-lg" src="{{ asset('storage/' . $image->image_path) }}" alt="Image">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Navigasi Kanan -->
                <button id="aftBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Informasi Properti -->
            <div>
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ $secondary->judul }}</h2>


                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <table class="table-auto w-full text-sm">
                        <tbody class="divide-y divide-gray-300">
                            <tr>
                                <td class="font-semibold text-gray-700">Kode Listing</td>
                                <td class="text-gray-600">{{ $secondary->kode_listing }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Status</td>
                                <td class="text-gray-600">{{ $secondary->status }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Kondisi</td>
                                <td class="text-gray-600">{{ $secondary->kondisi }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Luas Tanah</td>
                                <td class="text-gray-600">{{ $secondary->lt }} m²</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Luas Bangunan</td>
                                <td class="text-gray-600">{{ $secondary->lb }} m²</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Kamar Tidur</td>
                                <td class="text-gray-600">{{ $secondary->kt }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Kamar Tidur Pembantu</td>
                                <td class="text-gray-600">{{ $secondary->ktp }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Kamar Mandi</td>
                                <td class="text-gray-600">{{ $secondary->km }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Kamar Mandi Pembantu</td>
                                <td class="text-gray-600">{{ $secondary->kmp }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Carport</td>
                                <td class="text-gray-600">{{ $secondary->carport}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Garasi</td>
                                <td class="text-gray-600">{{ $secondary->garasi}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Listrik</td>
                                <td class="text-gray-600">{{ $secondary->listrik}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Air</td>
                                <td class="text-gray-600">{{ $secondary->air}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Hadap</td>
                                <td class="text-gray-600">{{ $secondary->hadap}}</td>
                            </tr>
                             <tr>
                                <td class="font-semibold text-gray-700">Posisi</td>
                                <td class="text-gray-600">{{ $secondary->posisi}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Furnish</td>
                                <td class="text-gray-600">{{ $secondary->furnish}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Lantai</td>
                                <td class="text-gray-600">{{ $secondary->lantai}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Harga</td>
                                <td class="text-gray-600">Rp {{ number_format($secondary->harga, 0, ',', '.') }}
                                    @if($secondary->status !== 'Dijual')/ tahun
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Lokasi</td>
                                <td class="text-gray-600">{{ $secondary->lokasi }}, {{ $secondary->kecamatan }}, {{ $secondary->kota }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Sertifikat</td>
                                <td class="text-gray-600">{{ $secondary->surat }}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold text-gray-700">IMB</td>
                                <td class="text-gray-600">{{ $secondary->imb }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="prose text-gray-600 my-4">
                    {!! $secondary->deskripsi !!}
                </div>

                @if(isset($embedUrl))
                <!-- Video -->
                <h2 class="text-lg font-semibold text-gray-800 mt-6">Ingin tahu lebih lengkap? Yuk, tonton video YouTube kami!</h2>
                <div class="mt-4">
                    <iframe
                        src="{{ $embedUrl }}"
                        frameborder="0"
                        allowfullscreen
                        class="rounded-lg shadow-lg w-full h-64 lg:h-80">
                    </iframe>
                </div>
            @endif
            </div>
        </div>


        <!-- Tombol -->
        <div class="text-center mt-8">
            <a href="https://wa.me/6287854454888"
               class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                <i class="fab fa-whatsapp"></i> Hubungi WA
            </a>
        </div>
    </div>


</div>

@if ($secondary->available !== 'Sold Out')
<div class="bg-white rounded-xl p-6 shadow-lg mt-10 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Simulasi Cicilan KPR</h2>
    <p class="text-sm text-gray-600 mb-6">Hitung estimasi cicilan berdasarkan harga rumah yang dipilih</p>

    <form id="kprForm" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Harga Properti</label>
            <input type="text"
                value="{{ number_format($secondary->harga, 0, ',', '.') }}"
                id="hargaProperti"
                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2"
                oninput="formatHargaInput(this)" />
            <input type="hidden" id="hargaAsli" value="{{ $secondary->harga }}">

        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Down Payment (DP)</label>
                <input type="text" id="dp" placeholder="Rp"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2"
                       oninput="formatDpInput(this)" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Persen (%)</label>
                <input type="number" id="dpPersen" placeholder="%" value="15"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Jumlah Kredit</label>
            <input type="text" readonly id="jumlahKredit"
                   class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 text-gray-700" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Jangka Waktu (tahun)</label>
                <input type="number" id="jangkaWaktu" value="30"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Bunga (%)</label>
                <input type="number" id="bunga" value="5"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
        </div>

        <button type="button" onclick="hitungKPR()"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded mt-4 transition">
            Hitung Cicilan
        </button>
    </form>

    <div id="hasilKpr" class="mt-6 hidden">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Angsuran KPR per Bulan</h3>
        <ul class="space-y-2 text-sm text-gray-700" id="angsuranList"></ul>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.getElementById('sliderContent');
    const slides = slider.children;
    const totalSlides = slides.length;

    const prevBtn = document.getElementById('befBtn');
    const nextBtn = document.getElementById('aftBtn');

    // Sembunyikan tombol jika gambar <= 1
    if (totalSlides <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    }

    let currentIndex = 0;

    function updateSliderPosition() {
        const offset = -currentIndex * 100;
        slider.style.transform = `translateX(${offset}%)`;
    }

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
        updateSliderPosition();
    });

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
        updateSliderPosition();
    });
});



    const hargaProperti = {{ $secondary->harga }};

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    function formatDpInput(input) {
        let value = input.value.replace(/[^\d]/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    function parseRupiah(rp) {
        return parseInt(rp.replace(/[^\d]/g, '')) || 0;
    }

   function hitungKPR() {
    const hargaInput = parseRupiah(document.getElementById('hargaProperti').value);
    const hargaAwal = parseInt(document.getElementById('hargaAsli').value); // untuk perbandingan kalau perlu
    const dpInput = parseRupiah(document.getElementById('dp').value);
    const persenInput = parseFloat(document.getElementById('dpPersen').value) || 0;

    // Hitung DP
    const dpFromPercent = hargaInput * (persenInput / 100);
    const dpFinal = dpInput > 0 ? dpInput : dpFromPercent;

    const jumlahKredit = hargaInput - dpFinal;
    const bunga = parseFloat(document.getElementById('bunga').value) || 0;
    const jangkaWaktu = parseInt(document.getElementById('jangkaWaktu').value) || 0;

    // Update nilai hasil
    document.getElementById('dp').value = new Intl.NumberFormat('id-ID').format(dpFinal);
    document.getElementById('jumlahKredit').value = formatRupiah(jumlahKredit);

    // Hitung cicilan
    const tahunOptions = [5, 10, 15, 20, 25, 30];
    const list = document.getElementById('angsuranList');
    list.innerHTML = '';

    tahunOptions.forEach(tahun => {
        const n = tahun * 12;
        const i = bunga / 12 / 100;
        const angsuran = jumlahKredit * i / (1 - Math.pow(1 + i, -n));
        const li = document.createElement('li');
        li.innerHTML = `<span class="font-medium">${tahun} tahun:</span> <span class="text-blue-600 font-semibold">${formatRupiah(angsuran)}</span> / bulan`;
        list.appendChild(li);
    });

    document.getElementById('hasilKpr').classList.remove('hidden');
}


    function formatHargaInput(input) {
    let value = input.value.replace(/[^\d]/g, '');
    input.value = new Intl.NumberFormat('id-ID').format(value);
}

</script>


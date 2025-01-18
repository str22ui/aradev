@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}
<div class="mx-auto bg-gray-100 md:mt-32 px-4 mt-24 pt-12">
    <div class="container mx-auto py-12 px-6">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Detail Properti</h1>

        <!-- Konten Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Gambar Properti -->
            <div>
                <div class="aspect-w-16 aspect-h-9">
                    <img class="rounded-lg shadow-lg" src="{{ asset('storage/' . $secondary->imagesSecondary->first()->image_path) }}" alt="Image">

                </div>
            </div>

            <!-- Informasi Properti -->
            <div>
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ $secondary->judul }}</h2>

                <div class="prose text-gray-600 mb-4">
                    {!! $secondary->deskripsi !!}
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <table class="table-auto w-full text-sm">
                        <tbody class="divide-y divide-gray-300">
                            <tr>
                                <td class="font-semibold text-gray-700">Status</td>
                                <td class="text-gray-600">{{ $secondary->status }}</td>
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
                                <td class="font-semibold text-gray-700">Kamar Mandi</td>
                                <td class="text-gray-600">{{ $secondary->km }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-700">Harga</td>
                                <td class="text-gray-600">Rp {{ number_format($secondary->harga, 0, ',', '.') }}</td>
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
            </div>
        </div>

        <!-- Tombol -->
        <div class="text-center mt-8">
            <a href="whatsapp://send?phone=NO_HP&text=Halo,%20saya%20tertarik%20dengan%20properti%20ini"
               class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                <i class="fab fa-whatsapp"></i> Hubungi WA
            </a>
        </div>
    </div>

</div>

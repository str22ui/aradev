@extends('client.layouts.index')

@section('title', '')
<div class="mx-auto bg-gray-100 md:mt-32 px-6 mt-24 pt-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Detail Tanah</h1>

    <!-- Konten -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Gambar Properti -->
        <div>
            <div class="aspect-w-16 aspect-h-9">
                <img class="rounded-lg shadow-lg" src="{{ asset('storage/' . $land->imagesLand->first()->image_path) }}" alt="Image">

            </div>
        </div>

        <!-- Informasi Properti -->
        <div>
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ $land->judul }}</h2>
            <div class="prose text-gray-600 mb-4">
                {!! $land->deskripsi !!}
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <table class="table-auto w-full text-sm">
                    <tbody class="divide-y divide-gray-300">
                        <tr>
                            <td class="font-semibold text-gray-700">Luas Tanah</td>
                            <td class="text-gray-600">{{ $land->lt }} m²</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Surat</td>
                            <td class="text-gray-600">{{ $land->surat }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">LMB/PBG</td>
                            <td class="text-gray-600">{{ $land->lmb_pbg }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Harga</td>
                            <td class="text-gray-600">Rp {{ number_format($land->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Lokasi</td>
                            <td class="text-gray-600">{{ $land->lokasi }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Kecamatan</td>
                            <td class="text-gray-600">{{ $land->kecamatan }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Kota</td>
                            <td class="text-gray-600">{{ $land->kota }}</td>
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

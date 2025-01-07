@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}

    <div class="mx-5 mt-24 mb-10 ">
        <h2 class="text-2xl text-center font-bold mb-6">Form Perumahan {{ $perumahan->perumahan }} </h2>
        <div class="flex">
            <div class=" w-full mx-auto mt-8 text-center">
                <div>

                    <label for="">Download Brosur</label>
                </div>
                <div class="mt-5">

                    <a href="{{ url('/download-brosur/' . $perumahan->id) }}" target="_blank"
                        class="text-white mx-auto w-1/4 bg-[#3A5EAA] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">Download
                        PDF</a>
                </div>
            </div>
            <div class=" w-full mx-auto mt-8 text-center">
                <div>

                    <label for="">Download Pricelist</label>
                </div>
                <div class="mt-5">
                    <a href="{{ url('/download-pricelist/' . $perumahan->id) }}" target="_blank"
                        class="text-white mx-auto w-1/4 bg-[#3A5EAA] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">Download
                        PDF</a>
                </div>

            </div>

        </div>
    </div>
<script>
    // Mendapatkan elemen dropdown
    var infoInput = document.getElementById('info-input');

    // Mendapatkan elemen div dengan class 'agent'
    var agentDiv = document.querySelector('.agent');

    // Menyembunyikan div dengan class 'agent' secara default
    agentDiv.style.display = 'none';

    // Menambahkan event listener untuk mendeteksi perubahan pada dropdown
    infoInput.addEventListener('change', function() {
        // Jika opsi yang dipilih adalah 'Agent', maka tampilkan div dengan class 'agent', jika tidak, sembunyikan
        if (infoInput.value === 'agent') {
            agentDiv.style.display = 'flex'; // Menampilkan div dengan class 'agent'
        } else {
            agentDiv.style.display = 'none'; // Menyembunyikan div dengan class 'agent'
        }
    });
</script>

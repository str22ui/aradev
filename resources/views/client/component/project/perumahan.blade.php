{{-- <div class="max-w-6xl mx-auto p-6 bg-gray-100"> --}}
    <div class=" mx-auto bg-gray-100 md:mt-32 ">
        <!-- Carousel dan Judul -->
        <div class="text-center mb-6 md:pt-12">
            <h1 class="text-2xl font-bold md:pt-18">{{ $perumahan->perumahan }}</h1>
        </div>

        <div class="slider-container">
            <button class="arrow left-arrow" id="prevBtn"> <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg></button>
            <div class="slider" id="slider">
              @foreach ($perumahan->images as $image)
                <div class="slide">
                  <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image">
                </div>
              @endforeach
            </div>
            <button class="arrow right-arrow" id="nextBtn"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg></button>
          </div>




        <div class="bg-primary text-white md:mt-4 mx-auto px-6 py-6 md:px-24 md:py-12 rounded-lg shadow-lg mb-8 grid grid-cols-1 md:grid-cols-4 gap-y-8 md:gap-x-6">
            <!-- Kolom Kiri: Deskripsi -->
            <div class="text-left">
                <h2 class="text-xl font-bold mb-2">Alamat</h2>
                <p class="text-sm leading-relaxed">{{ $perumahan->lokasi }}, {{ $perumahan->kota }}</p>
                <p class="flex items-center gap-2 mt-4 text-sm">
                    <span><i class="fas fa-ruler-combined"></i> {{ $perumahan->luas }} m²</span>
                    <span><i class="fas fa-home"></i> {{ $perumahan->unit }} unit</span>
                </p>
            </div>

            <!-- Kolom Tengah: Tipe Unit -->
            @if ($perumahan->tipe)
                @php $tipe = json_decode($perumahan->tipe); @endphp
                @if (is_array($tipe))
                    <div class="text-center">
                        <h2 class="text-xl font-bold mb-2">Tipe Unit</h2>
                        <div class="flex flex-wrap justify-center gap-2 mt-4">
                            @foreach ($tipe as $item)
                                <span class="bg-white text-blue-600 px-3 py-1 rounded-full text-sm shadow">Tipe {{ $item }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- Kolom Kanan: Fasilitas -->
            @if ($perumahan->fasilitas)
                @php $fasilitas = json_decode($perumahan->fasilitas); @endphp
                @if (is_array($fasilitas))
                    <div class="text-left">
                        <h2 class="text-xl font-bold mb-2">Fasilitas</h2>
                        <ul class="mt-4 space-y-2">
                            @foreach ($fasilitas as $item)
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                    <span class="text-sm">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif

            <!-- Kolom Bawah: Keunggulan -->
            @if ($perumahan->keunggulan)
                @php $keunggulan = json_decode($perumahan->keunggulan); @endphp
                @if (is_array($keunggulan))
                    <div class="text-left">
                        <h2 class="text-xl font-bold mb-2">Keunggulan</h2>
                        <ul class="mt-4 space-y-2">
                            @foreach ($keunggulan as $item)
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                    <span class="text-sm">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
        </div>
    </div>







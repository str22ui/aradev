<div data-aos="fade-up" data-aos-duration="1000" class="container mx-auto px-4 py-8">
    <h2 class="text-center text-2xl font-bold mb-6">Primary</h2>
    <div class="mx-auto text-center mb-12">
        <div class="flex flex-wrap justify-center gap-4">
          <button data-status="all" class="filter-btn border-solid border-2 border-primary text-black bg-white rounded-xl px-8 py-1 hover:bg-primary hover:text-white active">All</button>
          <button data-status="Soon" class="filter-btn border-solid border-2 border-primary text-black bg-white rounded-xl px-8 py-1 hover:bg-primary hover:text-white">Soon</button>
          <button data-status="Available" class="filter-btn border-solid border-2 border-primary text-black bg-white rounded-xl px-6 py-1 hover:bg-primary hover:text-white">Available</button>
          <button data-status="Sold Out" class="filter-btn border-solid border-2 border-primary text-black bg-white rounded-xl px-8 py-1 hover:bg-primary hover:text-white">Sold</button>
        </div>
      </div>



    <div class="carousel-container">
        <button class="carousel-btn left-btn">   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg></button>
        @if ($perumahan->isEmpty())
            <p class="text-center text-gray-500">No properties available for the selected status.</p>
        @else
            <div class="carousel">
                @foreach($perumahan as $p)
                <div class="card">
                    @if ($p->images->isNotEmpty())
                        <img class="card-img" src="{{ asset('storage/' . $p->images->first()->image_path) }}" alt="" />
                    @else
                        <img class="card-img" src="https://source.unsplash.com/1417x745/?house" alt="..." />
                    @endif
                    <div class="flex justify-between mt-4">
                        <div class="card-location">
                            <h3 class="kota">{{ $p->kota }}</h3>
                            <h3 class="perumahan">{{ $p->perumahan }}</h3>
                        </div>
                        <div class="card-price">
                            <p class="start-from">Start From</p>
                            <p class="price">Rp {{$p->harga}} {{ $p->satuan }}-an</p>
                        </div>
                    </div>

                    @if($p->keunggulan)
                        @php
                            $keunggulan = json_decode($p->keunggulan)
                        @endphp
                        @if (is_array($keunggulan))
                        <ul class="keunggulan">
                            @foreach(array_slice($keunggulan, 0, 4) as $item)
                                <li><i class="fas fa-check-circle mr-2"></i>{{ $item }}</li>
                            @endforeach
                            @if (count($keunggulan) > 4)
                                <li class="text-gray-500 italic">and more...</li>
                            @endif
                        </ul>
                        @endif
                    @endif

                    <div class="card-actions">
                        @if ($p->status === 'Available')
                            <a href="/form/{{ $p->id }}" class="btn-download">
                                <i class="fas fa-file-download" style="color:blue"></i> Download Pricelist & Brosur
                            </a>
                            <a href="/formPenawaran/{{ $p->id }}" class="btn-penawaran">
                                <i class="fas fa-handshake"></i> Penawaran
                            </a>
                        @else
                            <button disabled class="btn-disabled">
                                <i class="fas fa-file-download"></i> Download Pricelist & Brosur
                            </button>
                            <button disabled class="btn-disabled">
                                <i class="fas fa-handshake"></i> Penawaran
                            </button>
                        @endif
                        <a href="/showPerumahan/{{$p->id}}" class="btn-see-more">
                            <i class="fas fa-info-circle"></i> See More
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
            <button class="carousel-btn right-btn"> <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg></button>
        </div>


    </div>

 <script>
    const filterButtons = document.querySelectorAll('.filter-btn');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const status = button.getAttribute('data-status');
            fetchPerumahanByStatus(status);
        });
    });

    function fetchPerumahanByStatus(status) {
        fetch(`/perumahan/filter?status=${status}`)
            .then(response => response.json())
            .then(data => {
                renderPerumahanCards(data.perumahan);
            })
            .catch(error => console.error('Error fetching perumahan:', error));
    }

    function renderPerumahanCards(perumahan) {
        const carousel = document.getElementById('carousel');
        carousel.innerHTML = ''; // Clear previous content

        perumahan.forEach(p => {
            const imageUrl = p.images.length > 0 ? `/storage/${p.images[0].image_path}` : 'https://source.unsplash.com/1417x745/?house';
            const card = `
                <div class="card">
                    <img class="card-img" src="${imageUrl}" alt="House image" />
                    <div class="flex justify-between mt-4">
                        <div class="card-location">
                            <h3 class="kota">${p.kota}</h3>
                            <h3 class="perumahan">${p.perumahan}</h3>
                        </div>
                        <div class="card-price">
                            <p class="start-from">Start From</p>
                            <p class="price">Rp ${p.harga} ${p.satuan}-an</p>
                        </div>
                    </div>
                    <!-- Additional content like features and actions -->
                </div>
            `;
            carousel.innerHTML += card;
        });
    }
</script>
 <!-- Cards Container -->
 {{-- <div class="swiper-container " data-aos-duration="1000">
    <div class="swiper-wrapper">
        @foreach ($perumahan as $p)
        <div class="swiper-slide" data-status="{{ $p->status }}">
            <div class="bg-white shadow-lg rounded-lg p-4 flex flex-col justify-between h-auto relative">
                @if ($p->images->isNotEmpty())
                    <img class="w-full h-64 object-cover rounded-lg" src="{{ asset('storage/' . $p->images->first()->image_path) }}" alt="" />
                @else
                    <img src="https://source.unsplash.com/1417x745/?house" class="w-full h-64 object-cover rounded-lg" alt="...">
                @endif

                <div class="flex justify-between mt-4">
                    <!-- Left side: Kota and Perumahan -->
                    <div class="flex flex-col justify-start">
                        <h3 class="text-md font-medium">{{ $p->kota }}</h3>
                        <h3 class="text-lg font-semibold">{{ $p->perumahan }}</h3>
                    </div>

                    <!-- Right side: Start From and Harga -->
                    <div class="flex flex-col justify-start text-right">
                        <p class="text-gray-800 font-bold text-sm">Start From</p>
                        <p class="text-md font-semibold">Rp {{$p->harga}} {{ $p->satuan }}-an</p>
                    </div>
                </div>

                <div class="pl-4">
                    @if($p->keunggulan)
                        @php
                            $keunggulan = json_decode($p->keunggulan)
                        @endphp
                        @if (is_array($keunggulan))
                        <ul class="mt-2 text-gray-600 list-none">
                            @foreach(array_slice($keunggulan, 0, 4) as $item)
                                <li><i class="fas fa-check-circle mr-2"></i>{{ $item }}</li>
                            @endforeach
                            @if (count($keunggulan) > 4)
                                <li class="text-gray-500 italic">and more...</li>
                            @endif
                        </ul>
                        @endif
                    @endif


                    <div class="mt-4 flex flex-col space-y-2">
                        @if ($p->status === 'Available')
                        <!-- Button Download Pricelist -->
                            <a href="/form/{{ $p->id }}"
                            class="text-black text-center justify-center items-center py-2 px-4 rounded-lg border-2 border-blue-500 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <i class="fas fa-file-download" style="color:blue"></i> Download Pricelist
                            </a>

                            <a href="/formPenawaran/{{ $p->id }}"
                                class="text-white text-center justify-center items-center py-2 px-4 rounded-lg bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                 <i class="fas fa-handshake"></i> Penawaran
                             </a>
                        @else
                            <!-- Disabled Button -->
                            <button disabled
                            class="text-white py-2 px-4 rounded-lg bg-gray-400 cursor-not-allowed">
                                <i class="fas fa-file-download"></i> Download Pricelist
                            </button>

                            <button disabled
                            class="text-white py-2 px-4 rounded-lg bg-gray-400 cursor-not-allowed">
                                <i class="fas fa-handshake"></i>  Penawaran
                            </button>
                        @endif

                        <!-- Button Penawaran -->


                        <!-- Button See More -->
                        <a href="/showPerumahan/{{$p->id}}"
                           class="underline text-black py-1 px-4 text-center justify-center items-center hover:rounded-md hover:bg-gray-100 hover:text-black hover:border-b-2 border-blue-500">
                            <i class="fas fa-info-circle"></i> See More
                        </a>
                    </div>

                </div>
            </div>

        </div>


        @endforeach
    </div>

    <!-- Tambahkan navigasi jika diperlukan -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

    <!-- Tambahkan pagination jika diperlukan -->
    {{-- <div class="swiper-pagination"></div> --}}
{{-- </div>  --}}

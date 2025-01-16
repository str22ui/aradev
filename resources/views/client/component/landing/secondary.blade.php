<div data-aos="fade-up" data-aos-duration="1000" class="container mx-auto px-4 py-8">
    <h2 class="text-center text-2xl font-bold mb-12">
        <i class="fa fa-home" style="font-size:20px; margin-bottom:20px;" aria-hidden="true"></i>
        Properti Secondary
    </h2>

    <div class="grid lg:grid-cols-2 gap-6">
        @if ($secondary->isEmpty())
            <p class="text-center text-gray-500">No properties available for the selected status.</p>
        @else
            @foreach($secondary as $s)
            <div class="flex bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Bagian gambar -->
                <div class="relative w-1/3">
                    @if ($s->images->isNotEmpty())
                        <img class="w-full h-56 object-cover" src="{{ asset('storage/' . $s->images->first()->image_path) }}" alt="Perumahan {{ $s->secondary }}">
                    @else
                        <img class="w-full h-56 object-cover" src="https://source.unsplash.com/1417x745/?house" alt="Default Image">
                    @endif
                    <!-- Status badge -->
                    @if($s->available === 'Available')
                        <span class="absolute top-2 left-2 bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Available</span>
                    @elseif($s->available === 'Sold Out')
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Sold Out</span>

                    @endif
                </div>

                <!-- Bagian informasi properti -->
                <div class="p-4 flex flex-col justify-between w-2/3">
                    <div>
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $s->kota }}</h3>
                            <!-- Status badge yang sejajar dengan kota -->
                            @if($s->status === 'Available')
                                <span class="bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full lg:hidden">Available</span>
                            @elseif($s->status === 'Sold Out')
                                <span class="bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded-full lg:hidden">Sold Out</span>
                            @elseif($s->status === 'Soon')
                                <span class="bg-blue-500 text-white text-sm font-semibold px-3 py-1 rounded-full lg:hidden">Soon</span>
                            @endif
                        </div>
                        <p class="text-gray-600">{{ $s->secondary }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            LB: {{ $s->luas_bangunan }} | LT: {{ $s->luas_tanah }} |
                            <i class="fas fa-bed"></i> {{ $s->kamar_tidur }} |
                            <i class="fas fa-shower"></i> {{ $s->kamar_mandi }} |
                            <i class="fas fa-car"></i> {{ $s->garasi }}
                        </p>
                        <p class="text-sm text-gray-500 mt-4">Posted: {{ $s->created_at->format('d/m/y') }}</p>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-500 text-sm">Start From</p>
                        <p class="text-lg font-bold text-blue-600">Rp {{ $s->harga }}</p>
                    </div>
                    <a href="/showPerumahan/{{$s->id}}" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md text-center hover:bg-blue-600 transition">
                        <i class="fas fa-info-circle"></i> See More
                    </a>
                </div>
            </div>
            @endforeach
        @endif
    </div>

</div>
<div class="flex justify-center mt-8">
    <a href="/secondary" class="btn-see-more inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700">
        <i class="fa fa-search"></i> Tampilkan Lebih Banyak
    </a>
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

<div data-aos="fade-up" data-aos-duration="1000" class="mx-auto mt-24 py-6">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-6 flex justify-center items-center gap-2">
            <i class="fas fa-clipboard-list text-blue-500"></i> Wishlist Aradev
        </h2>

        <div class="relative w-full max-w-md mx-auto overflow-hidden">
            <div id="carousel" class="flex transition-transform duration-500 ease-in-out touch-pan-x cursor-grab">
                @foreach($wishlist as $w)
                <div class="w-full shrink-0 p-6 bg-white shadow-md rounded-lg border-l-8
                    @if($w->status == 'Available') border-green-500
                    @elseif($w->status == 'Closed') border-red-500
                    @elseif($w->status == 'Remove') border-gray-500
                    @endif">

                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">{{$w->nama}}, {{$w->domisili}}</h3>
                        <span class="px-3 py-1 text-white font-semibold text-sm rounded
                            @if($w->status == 'Available') bg-green-500
                            @elseif($w->status == 'Closed') bg-red-500
                            @elseif($w->status == 'Remove') bg-gray-500
                            @endif">
                            {{$w->status}}
                        </span>
                    </div>

                    <p class="text-gray-700 mt-2"><strong>Permintaan:</strong> {{$w->permintaan}} {{$w->jenis}}</p>
                    <p class="text-gray-600 text-sm">🏙 <strong>Lokasi:</strong> {{$w->lokasi}}</p>
                    <p class="text-green-600 font-semibold mt-2 text-lg">💰 Harga: Rp {{ ($w->harga_budget) }}</p>

                    <p class="text-gray-600 mt-4 leading-relaxed">
                        {!! Str::limit($w->keterangan, 350, '...') !!}
                    </p>
                </div>
                @endforeach
            </div>

            <!-- Indikator -->
            <div class="flex justify-center gap-2 mt-4" id="indicators">
                @foreach($wishlist as $index => $w)
                <div class="w-3 h-3 rounded-full bg-gray-300" data-index="{{ $index }}"></div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex mx-auto justify-center gap-6 mt-8">
        <div>
            <a href="/wishlist" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">
                <i class="fas fa-info-circle"></i> More Detail
            </a>
        </div>
        <div>
            <a href="/formWishlist" class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition">
                <i class="fas fa-list-alt"></i> Form Wishlist
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carousel = document.getElementById("carousel");
        const indicators = document.querySelectorAll("#indicators div");
        let index = 0;
        const totalItems = indicators.length;
        let startX = 0;
        let isDragging = false;

        function updateCarousel() {
            carousel.style.transform = `translateX(-${index * 100}%)`;
            indicators.forEach((dot, i) => {
                dot.classList.toggle("bg-blue-500", i === index);
                dot.classList.toggle("bg-gray-300", i !== index);
            });
        }

        function autoSlide() {
            index = (index + 1) % totalItems;
            updateCarousel();
        }

        let interval = setInterval(autoSlide, 3000);

        carousel.addEventListener("mousedown", (e) => {
            isDragging = true;
            startX = e.clientX;
            clearInterval(interval);
        });

        carousel.addEventListener("mousemove", (e) => {
            if (!isDragging) return;
            let moveX = e.clientX - startX;
            if (moveX > 50) {
                index = index > 0 ? index - 1 : totalItems - 1;
                isDragging = false;
            } else if (moveX < -50) {
                index = (index + 1) % totalItems;
                isDragging = false;
            }
            updateCarousel();
        });

        carousel.addEventListener("mouseup", () => {
            isDragging = false;
            interval = setInterval(autoSlide, 3000);
        });
    });
</script>

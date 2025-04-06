<div data-aos="fade-up" data-aos-duration="1000" class="mx-auto mt-24 py-6">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-6 flex justify-center items-center gap-2">
            <i class="fas fa-comment-dots text-yellow-500"></i> Testimoni Aradev
        </h2>

        <div class="relative w-full max-w-md mx-auto overflow-hidden">
            <div id="testimony-carousel" class="flex transition-transform duration-500 ease-in-out touch-pan-x cursor-grab">
                @foreach($testimony as $t)
                <div class="w-full shrink-0 p-6 bg-white shadow-md rounded-lg border border-gray-200 flex flex-col items-center">
                    <img src="{{ asset('storage/' . $t->image) }}"
                         alt="{{ $t->name }}"
                         class="w-12 h-12 rounded-full border-2 border-blue-500 object-cover aspect-square">

                    <div class="text-center mt-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $t->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $t->pekerjaan }}, {{ $t->kota }}</p>
                    </div>

                    <p class="text-gray-700 mt-4 italic text-center">
                        {!! Str::limit($t->testimony, 300, '...') !!}
                    </p>
                </div>
                @endforeach
            </div>

            <div class="flex justify-center gap-2 mt-4" id="testimony-indicators">
                @foreach($testimony as $index => $t)
                <div class="w-3 h-3 rounded-full bg-gray-300" data-index="{{ $index }}"></div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex mx-auto justify-center gap-6 mt-8">
        <a href="/testimony"
           class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">
            <i class="fas fa-info-circle"></i> More Detail
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carousel = document.getElementById("testimony-carousel");
        const indicators = document.querySelectorAll("#testimony-indicators div");
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

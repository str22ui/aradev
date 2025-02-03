
@if(isset($kotaLand) && $kotaLand->isNotEmpty())
<div class="block relative nav-dropdown">
    <button id="landToggle" class="flex gap-1 items-center font-bold text-base nav-dropdown-btn-sm lg:nav-dropdown-btn">
      <a href="/land"> <p class="font-bold text-gray-700 text-base hover:text-blue-500 transition-colors duration-200">Land</p></a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 lg:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div id="dropdownLand" class="bg-white text-[#898989] text-sm flex-col w-full lg:w-40 gap-2 relative lg:absolute hidden nav-dropdown-content">
        <a class="hover:bg-primary hover:text-white px-2 py-1" href="/land">
        All Location
        </a>
        @if(isset($kotaLand) && $kotaLand->isNotEmpty())
            @foreach ($kotaLand as $lokasi)
                <a class="hover:bg-primary hover:text-white px-2 py-1" href="{{ url('/kotaLand/' . $lokasi->lokasi) }}">
                    {{ $lokasi->lokasi }}
                </a>
            @endforeach
        @else
            <p class="px-2 py-1 text-gray-500">No projects available</p>
        @endif
    </div>
</div>

@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const dropdownToggle = document.getElementById('landToggle');
    const dropdownLand = document.getElementById('dropdownLand');

    // Toggle dropdown visibility on button click
    dropdownToggle.addEventListener('click', () => {
        dropdownLand.classList.toggle('hidden');
        dropdownLand.classList.toggle('flex');
        dropdownLand.classList.toggle('bg-white');
        dropdownLand.classList.toggle('shadow-lg');
    });
});

</script>

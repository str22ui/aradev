
@if(isset($kotas) && $kotas->isNotEmpty())
<div class="block relative nav-dropdown">
    <button id="dropdownToggle" class="flex gap-1 items-center font-bold text-base nav-dropdown-btn-sm lg:nav-dropdown-btn">
        <p>Primary</p>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 lg:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div id="dropdownContent" class="bg-white text-[#898989] text-sm flex-col w-full lg:w-40 gap-2 relative lg:absolute hidden nav-dropdown-content">
        @if(isset($kotas) && $kotas->isNotEmpty())
            @foreach ($kotas as $kota)
                <a class="hover:bg-primary hover:text-white px-2 py-1" href="{{ url('/showProject/' . $kota->kota) }}">
                    {{ $kota->kota }}
                </a>
            @endforeach
        @else
            <p class="px-2 py-1 text-gray-500">No projects available</p>
        @endif
    </div>
</div>

@endif

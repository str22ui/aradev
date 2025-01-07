<nav id="a" class="fixed z-50  ease-linear duration-100 translate-x-0  w-screen top-0 font-[Poppins]">
    <div class="flex justify-between items-center px-5 lg:px-12 xl:px-20">
        <!-- Logo (Selalu Tampil di HP) -->
        <a href="/" class="lg:hidden">
            <img id="mobileLogo" class="w-36" src="{{ asset('img/logo.png') }}" alt="logo">
        </a>

        <!-- Hamburger Menu -->
        <button id="btnNav" type="button" class="lg:hidden ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
        </button>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="nav" class="hidden flex-col lg:block border-b-indigo-500 text-[3E3C3C] ">
        <section id="navMenu" class="flex flex-col lg:flex-row lg:mt-0 py-5 px-5 lg:px-12 xl:px-20 justify-evenly">
            <!-- Logo untuk Mode Desktop -->
            <a href="/" class="hidden lg:block">
                <img id="desktopLogo" class="w-52 lg:w-64 xl:w-48" src="{{ asset('img/logo.png') }}" alt="logo">
            </a>
            <div class="flex flex-col lg:flex-row gap-5 mt-10 lg:mt-0 lg:items-center ">
                @include('client.component.NavigationComponent.Menu')
            </div>
        </section>
    </div>
</nav>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnNav = document.getElementById('btnNav');
    const nav = document.getElementById('nav');

    // Handle toggle for the mobile menu
    btnNav.addEventListener('click', () => {
        nav.classList.toggle('hidden');
    });
});



</script>


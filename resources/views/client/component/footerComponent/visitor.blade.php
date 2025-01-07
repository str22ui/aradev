<div class="text-white lg:justify-self-center">
    <h1 class="text-lg border-b-4 border-white font-bold w-fit">KUNJUNGAN</h1>
    <div class="flex items-center gap-2 mt-5">
        <x-fas-user-tie class="h-5" />
        <p class="text-xs">Hari ini : </p>
        <p class="text-xs">{{ $todayVisits }}</p>
    </div>
    <div class="flex items-center gap-2 mt-5">
        <x-far-calendar-alt class="h-5" />
        <p class="text-xs">Bulan ini : </p>
        <p class="text-xs">{{ $monthVisits }}</p>
    </div>
    <div class="flex items-center gap-2 mt-5">
        <x-bi-stopwatch-fill class="h-5" />
        <p class="text-xs">Total Kunjungan : </p>
        <p class="text-xs">{{ $totalVisits }}</p>
    </div>
</div>

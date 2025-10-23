@extends('client.component.DataView.layouts.main')

@section('title', 'Dashboard Affiliate')

@section('content')
<div class="max-w-6xl mx-auto">
  <!-- Welcome Header -->
  <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8 rounded-lg shadow-lg mb-6">
    <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ $user->name ?? 'Affiliate' }}!</h2>
    <p class="text-blue-100">Dashboard Affiliate - Lihat performa dan komisi Anda</p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Profile Card -->
    <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6">
      <div class="flex items-center justify-center mb-4">
        <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center">
          <span class="text-4xl font-bold text-blue-600">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
        </div>
      </div>

      <h3 class="text-xl font-bold text-center text-gray-800 mb-4">{{ $user->name ?? 'N/A' }}</h3>

      <div class="space-y-3">
        <div class="border-b pb-2">
          <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
          <p class="text-gray-800">{{ $user->email ?? 'N/A' }}</p>
        </div>

        <div class="border-b pb-2">
          <label class="text-xs font-semibold text-gray-500 uppercase">No. Telepon</label>
          <p class="text-gray-800">{{ $affiliate->phone ?? '-' }}</p>
        </div>

        <div class="border-b pb-2">
          <label class="text-xs font-semibold text-gray-500 uppercase">Bergabung Sejak</label>
          <p class="text-gray-800">{{ $affiliate->joined_at ? \Carbon\Carbon::parse($user->joined_at)->format('d M Y') : '-' }}</p>
        </div>
      </div>
    </div>

    <!-- Statistics Cards -->
    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Commission Rate -->
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-semibold text-gray-500 uppercase">Commission Rate</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $affiliate->commission_rate ?? '0' }}%</p>
          </div>
          <div class="bg-purple-100 p-4 rounded-full">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
          </div>
        </div>
      </div>

      <!-- Total Sales -->
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-semibold text-gray-500 uppercase">Total Penjualan</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">Rp {{ number_format($affiliate->total_sales ?? 0, 0, ',', '.') }}</p>
          </div>
          <div class="bg-green-100 p-4 rounded-full">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <!-- Total Commission -->
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500 md:col-span-2">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-semibold text-gray-500 uppercase">Total Komisi</p>
            <p class="text-4xl font-bold text-gray-800 mt-2">Rp {{ number_format($affiliate->total_commission ?? 0, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mt-1">Komisi yang telah Anda peroleh</p>
          </div>
          <div class="bg-yellow-100 p-4 rounded-full">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Address and Housing Information -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Address Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
      <div class="flex items-center mb-4">
        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-800">Alamat</h3>
      </div>
      <div class="bg-gray-50 p-4 rounded-lg">
        <p class="text-gray-700 leading-relaxed">{{ $affiliate->address ?? 'Alamat belum diisi' }}</p>
      </div>
    </div>

    <!-- Housing Information Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
      <div class="flex items-center mb-4">
        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-800">Informasi Perumahan</h3>
      </div>

     <div class="space-y-3">
        @forelse($affiliate->perumahans() as $perumahan)
        <div class="flex justify-between items-center py-2 border-b">
            <span class="text-gray-600 font-medium">Nama Perumahan:</span>
            <span class="text-gray-800 font-semibold">{{ $perumahan->perumahan }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b">
            <span class="text-gray-600 font-medium">Lokasi:</span>
            <span class="text-gray-800 font-semibold">{{ $perumahan->lokasi }}</span>
        </div>
        @empty
        <p class="text-gray-500">Affiliate ini belum terdaftar pada perumahan mana pun.</p>
    @endforelse
    </div>

    </div>
  </div>

  <!-- Info Note -->
  <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
    <div class="flex">
      <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <div>
        <h4 class="text-blue-800 font-semibold">Informasi</h4>
        <p class="text-blue-700 text-sm mt-1">Halaman ini hanya untuk melihat data. Untuk update informasi, silakan hubungi administrator.</p>
      </div>
    </div>
  </div>
</div>
@endsection

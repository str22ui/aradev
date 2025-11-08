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
          <p class="text-gray-800">{{ $affiliate->joined_at ? \Carbon\Carbon::parse($affiliate->joined_at)->format('d M Y') : '-' }}</p>
        </div>
      </div>
    </div>

    <!-- Address and Housing Information -->
    <div class="lg:col-span-2 grid grid-cols-1 gap-6">
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
          {{-- @forelse($affiliate->perumahans ?? [] as $perumahan)
          <div class="bg-gray-50 p-3 rounded-lg">
            <div class="flex justify-between items-center py-2">
              <span class="text-gray-600 font-medium">Nama Perumahan:</span>
              <span class="text-gray-800 font-semibold">{{ $perumahan->perumahan ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2">
              <span class="text-gray-600 font-medium">Lokasi:</span>
              <span class="text-gray-800 font-semibold">{{ $perumahan->lokasi ?? '-' }}</span>
            </div>
          </div>
          @empty
          <p class="text-gray-500 text-center py-4">Affiliate ini belum terdaftar pada perumahan mana pun.</p>
          @endforelse --}}
        </div>
      </div>
    </div>
  </div>

  <!-- Monthly Period Financial Details -->
  <div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center mb-6">
      <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
      </svg>
      <h3 class="text-xl font-bold text-gray-800">Rincian Keuangan Periode Bulanan</h3>
    </div>

    @forelse($monthlyPeriods ?? [] as $period)
    <div class="mb-6 border border-gray-200 rounded-lg p-6 bg-gray-50">
      <div class="flex items-center justify-between mb-4">
        <h4 class="text-lg font-bold text-gray-800">
          Periode: {{ $period->month ?? '-' }} {{ $period->year ?? '-' }}
        </h4>
        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
          {{ $period->status ?? 'Active' }}
        </span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Harga Pricelist -->
        <div class="bg-white p-4 rounded-lg border-l-4 border-blue-500">
          <label class="text-xs font-semibold text-gray-500 uppercase">Harga Pricelist</label>
          <p class="text-2xl font-bold text-gray-800 mt-1">
            Rp {{ number_format($period->pricelist ?? 0, 0, ',', '.') }}
          </p>
        </div>

        <!-- Biaya Legalitas -->
        <div class="bg-white p-4 rounded-lg border-l-4 border-purple-500">
          <label class="text-xs font-semibold text-gray-500 uppercase">Biaya Legalitas</label>
          <p class="text-2xl font-bold text-gray-800 mt-1">
            Rp {{ number_format($period->legal_fee ?? 0, 0, ',', '.') }}
          </p>
        </div>

        <!-- Net Price -->
        <div class="bg-white p-4 rounded-lg border-l-4 border-green-500">
          <label class="text-xs font-semibold text-gray-500 uppercase">Net Price</label>
          <p class="text-2xl font-bold text-gray-800 mt-1">
            Rp {{ number_format($period->net_price ?? 0, 0, ',', '.') }}
          </p>
        </div>

        <!-- Fee 2.5% -->
        <div class="bg-white p-4 rounded-lg border-l-4 border-yellow-500">
          <label class="text-xs font-semibold text-gray-500 uppercase">Fee 2.5%</label>
          <p class="text-2xl font-bold text-gray-800 mt-1">
            Rp {{ number_format($period->fee_2_5 ?? 0, 0, ',', '.') }}
          </p>
        </div>

        <!-- Fee Affiliate 30% -->
        <div class="bg-white p-4 rounded-lg border-l-4 border-orange-500">
          <label class="text-xs font-semibold text-gray-500 uppercase">Fee Affiliate 30%</label>
          <p class="text-2xl font-bold text-gray-800 mt-1">
            Rp {{ number_format($period->fee_affiliate_30 ?? 0, 0, ',', '.') }}
          </p>
        </div>

        <!-- Sub Total Bulanan -->
        <div class="bg-white p-4 rounded-lg border-l-4 border-red-500">
          <label class="text-xs font-semibold text-gray-500 uppercase">Sub Total Bulanan</label>
          <p class="text-2xl font-bold text-gray-800 mt-1">
            Rp {{ number_format($period->sub_total ?? 0, 0, ',', '.') }}
          </p>
        </div>
      </div>
    </div>
    @empty
    <div class="text-center py-8">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
      </svg>
      <p class="text-gray-500 text-lg">Belum ada data periode bulanan</p>
    </div>
    @endforelse
  </div>

  <!-- Info Note -->
  <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
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

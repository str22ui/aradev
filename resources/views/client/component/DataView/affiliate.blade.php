@extends('client.component.DataView.layouts.main')

@section('title', 'Dashboard Affiliate')

@section('content')
<div class="max-w-6xl mx-auto">
  <!-- Welcome Header -->
  <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8 rounded-lg shadow-lg mb-6">
    <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ $affiliate->name ?? 'Affiliate' }}!</h2>
    <p class="text-blue-100">Dashboard Affiliate - Lihat performa dan komisi Anda</p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Profile Card -->
    <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6">
      <div class="flex items-center justify-center mb-4">
        <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center">
          <span class="text-4xl font-bold text-blue-600">{{ strtoupper(substr($affiliate->name ?? 'A', 0, 1)) }}</span>
        </div>
      </div>

      <h3 class="text-xl font-bold text-center text-gray-800 mb-4">{{ $affiliate->name ?? 'N/A' }}</h3>

      <div class="space-y-3">
        <div class="border-b pb-2">
          <label class="text-xs font-semibold text-gray-500 uppercase">Kode Affiliate</label>
          <p class="text-gray-800 font-mono">{{ $affiliate->code ?? 'N/A' }}</p>
        </div>

        <div class="border-b pb-2">
          <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
          <p class="text-gray-800">{{ $affiliate->user->email ?? 'N/A' }}</p>
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
          @if($affiliate->perumahan)
          <div class="bg-gray-50 p-3 rounded-lg">
            <div class="flex justify-between items-center py-2">
              <span class="text-gray-600 font-medium">Nama Perumahan:</span>
              <span class="text-gray-800 font-semibold">Perumahan</span>
            </div>
            <div class="flex justify-between items-center py-2">
              <span class="text-gray-600 font-medium">Lokasi:</span>
              <span class="text-gray-800 font-semibold">Lokasi</span>
            </div>
          </div>
          @else
          <p class="text-gray-500 text-center py-4">Affiliate ini belum terdaftar pada perumahan mana pun.</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Commission Summary Stats -->
  @if($commissions->isNotEmpty())
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-green-100 text-sm font-semibold uppercase">Total Komisi</p>
          <p class="text-3xl font-bold mt-2">Rp {{ number_format($commissions->sum('total') ?? 0, 0, ',', '.') }}</p>
        </div>
        <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
    </div>

    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-blue-100 text-sm font-semibold uppercase">Total Fee Affiliate</p>
          <p class="text-3xl font-bold mt-2">Rp {{ number_format($commissions->sum('fee_affiliate_30') ?? 0, 0, ',', '.') }}</p>
        </div>
        <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-purple-100 text-sm font-semibold uppercase">Jumlah Periode</p>
          <p class="text-3xl font-bold mt-2">{{ $commissions->count() }}</p>
        </div>
        <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
      </div>
    </div>
  </div>
  @endif

  <!-- Monthly Commission Details -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-800">Rincian Komisi Bulanan</h3>
        </div>
        @if($affiliate->perumahan)
        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-sm font-semibold">
        {{ $affiliate->perumahan->name ?? '-' }}
        </span>
        @endif
    </div>

    @forelse($commissions ?? [] as $commission)
    <div class="mb-4 border border-gray-200 rounded-lg overflow-hidden">
        <!-- Header Periode -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 flex items-center justify-between">
        <h4 class="text-lg font-bold">
            {{ \Carbon\Carbon::parse($commission->bulan)->format('F Y') }}
        </h4>
        <div class="text-right">
            <p class="text-xs text-blue-100">Total Komisi</p>
            <p class="text-xl font-bold">Rp {{ number_format($commission->total ?? 0, 0, ',', '.') }}</p>
        </div>
        </div>

        <!-- Detail Komisi dalam bentuk Table -->
        <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Komponen</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Nilai</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-700">Harga Pricelist</td>
                <td class="px-4 py-3 text-sm text-gray-900 text-right font-semibold">
                Rp {{ number_format($commission->harga_pricelist ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-700">Biaya Legalitas</td>
                <td class="px-4 py-3 text-sm text-gray-900 text-right font-semibold">
                Rp {{ number_format($commission->biaya_legalitas ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="hover:bg-gray-50 bg-green-50">
                <td class="px-4 py-3 text-sm text-gray-700 font-medium">Net Price</td>
                <td class="px-4 py-3 text-sm text-green-700 text-right font-bold">
                Rp {{ number_format($commission->net_price ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-700">Fee 2.5%</td>
                <td class="px-4 py-3 text-sm text-gray-900 text-right font-semibold">
                Rp {{ number_format($commission->fee_2_5 ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="hover:bg-gray-50 bg-orange-50">
                <td class="px-4 py-3 text-sm text-gray-700 font-medium">Fee Affiliate 30%</td>
                <td class="px-4 py-3 text-sm text-orange-700 text-right font-bold">
                Rp {{ number_format($commission->fee_affiliate_30 ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-700">Sub Total Bulanan</td>
                <td class="px-4 py-3 text-sm text-gray-900 text-right font-semibold">
                Rp {{ number_format($commission->sub_total_bulanan ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
    @empty
    <div class="text-center py-8">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-gray-500 text-lg">Belum ada data komisi</p>
    </div>
    @endforelse
    @if($commissions->hasPages())
    <div class="mt-6">
    {{ $commissions->links() }}
    </div>
    @endif
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

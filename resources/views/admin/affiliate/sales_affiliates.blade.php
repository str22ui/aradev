@extends('admin.layouts.index', ['title' => 'Affiliate Saya', 'page_heading' => 'Daftar Affiliate yang Saya Referensikan'])

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill"></i> Affiliate dari {{ $sales->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Info Summary -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-person-badge"></i> Sales Info
                                    </h5>
                                    <p class="mb-1"><strong>Nama:</strong> {{ $sales->name }}</p>
                                    <p class="mb-1"><strong>Kode:</strong> <code
                                            class="text-white">{{ $sales->code ?? $sales->email }}</code></p>
                                    <p class="mb-0"><strong>Email:</strong> {{ $sales->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h1 class="display-4">{{ $affiliates->count() }}</h1>
                                    <p class="mb-0">Total Affiliate</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center">
                                    <h1 class="display-4">
                                        {{ $affiliates->sum(function ($aff) {return $aff->commissions->sum('total');}) }}
                                    </h1>
                                    <p class="mb-0">Total Komisi (Rp)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Affiliate -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Affiliate</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Tanggal Join</th>
                                    <th>Total Komisi</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($affiliates as $index => $affiliate)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $affiliate->code }}</span>
                                        </td>
                                        <td>{{ $affiliate->name }}</td>
                                        <td>{{ $affiliate->phone }}</td>
                                        <td>{{ \Carbon\Carbon::parse($affiliate->joined_at)->format('d M Y') }}</td>
                                        <td>
                                            <strong>Rp
                                                {{ number_format($affiliate->commissions->sum('total'), 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            @if ($affiliate->commissions->count() > 0)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-hourglass"></i> Belum Ada Komisi
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.editAffiliate', $affiliate->id) }}"
                                                    class="btn btn-sm btn-info" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.createCommission', $affiliate->id) }}"
                                                    class="btn btn-sm btn-success" title="Komisi">
                                                    <i class="bi bi-cash-coin"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            <i class="bi bi-inbox"></i> Belum ada affiliate yang Anda referensikan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-3">
                        <a href="{{ route('admin.affiliate') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Affiliate
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

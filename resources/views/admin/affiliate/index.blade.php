@extends('admin.layouts.index', ['title' => 'Data Affiliate', 'page_heading' => 'Data Affiliate'])

@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
         @if (auth()->user()->role !== 'sales')
        <a href="{{ route('admin.createAffiliate') }}">
            <button type="submit" class="btn btn-primary mr-2 mb-2">
                <i class="bi bi-plus-circle"></i> Insert Data
            </button>
        </a>
        @endif

        @if (auth()->user()->role !== 'sales')
        <form action="{{ url('affiliate/export/excel') }}" method="GET" class="d-flex justify-content-between align-items-center">
            <div>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </button>
            </div>
            <div class="form-group mb-0">
                <label for="exportOption" class="mr-2">Pilih Eksport:</label>
                <select id="exportOption" name="export_option" class="form-control mb-4" onchange="toggleMonthYearDropdown()">
                    <option value="all">Semua</option>
                    <option value="month_year">Bulan dan Tahun</option>
                </select>
                <div class="form-group mb-0" id="monthYearDropdown" style="display: none;">
                    <div class="form-row">
                        <div class="col">
                            <label for="month" class="mr-2">Pilih Bulan:</label>
                            <select id="month" name="month" class="form-control mb-4">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ date("F", mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col">
                            <label for="year" class="mr-2">Pilih Tahun:</label>
                            <select id="year" name="year" class="form-control mb-4">
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Referrer (Sales)</th>
                        <th>Kode Referrer</th>
                        <th>Tanggal Join</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($affiliate as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $item->code }}</span>
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->address }}</td>
                            <td>
                                @if($item->referrer)
                                    <span class="badge bg-success">
                                        <i class="bi bi-person-check"></i> {{ $item->referrer->name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->referrer)
                                    <code>{{ $item->referrer->code ?? $item->referrer->email }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->joined_at ? \Carbon\Carbon::parse($item->joined_at)->format('d M Y') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.editAffiliate', $item->id) }}"
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.createCommission', $item->id) }}"
                                       class="btn btn-info btn-sm" title="Komisi">
                                        <i class="bi bi-cash-coin"></i>
                                    </a>
                                    <form action="{{ route('admin.deleteAffiliate') }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus?')"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data affiliate</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

  </div>
</div>

</section>

<script>
function toggleMonthYearDropdown() {
    const exportOption = document.getElementById('exportOption').value;
    const monthYearDropdown = document.getElementById('monthYearDropdown');

    if (exportOption === 'month_year') {
        monthYearDropdown.style.display = 'block';
    } else {
        monthYearDropdown.style.display = 'none';
    }
}
</script>

@endsection

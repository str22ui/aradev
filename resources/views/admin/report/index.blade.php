@extends('admin.layouts.index', ['title' => 'Data Report', 'page_heading' => 'Data Report'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    {{-- @if(auth()->user()->role === 'admin'|| Auth::user()->role == 'salesAdmin' || Auth::user()->role == 'sales') --}}
    <a href="{{ route('admin.createReport') }}">
        <button type="submit" class="btn btn-primary mr-2 mb-2">+Insert Data</button>
    </a>
    {{-- @endif --}}
    {{-- @if(auth()->user()->role === 'admin'|| Auth::user()->role == 'salesAdmin') --}}
    <form action="{{ url('report/export/excel') }}" method="GET" class="d-flex justify-content-between align-items-center">
        <div>
            <button type="submit" class="btn btn-success">Export Excel</button>
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
    {{-- @endif --}}
    <div class="table-responsive">
        @include('admin.report.tableReport', ['report' => $report])
    </div>

		{{-- {{ $management->withQueryString()->links() }} --}}
  </div>
</div>

</section>
@endsection



@extends('admin.layouts.index', ['title' => 'Data Penawaran', 'page_heading' => 'Data Penawaran'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">


        {{-- <a href="{{ route('admin.createTeacher') }}" class="btn btn-success me-2 py-2" > --}}
        <a href="#" class="btn btn-success me-2 py-2" >
            + Insert Data
        </a>
        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
        {{ session('success') }}
        </div>
        @endif
		<!-- Table untuk memanggil data dari database -->
		<table class="table">
            <thead>
                <tr>
                    <th class="col-sm-1">No</th>
                    <th class="col-md-1">Nama </th>
                    <th class="col-md-1">No Kavling</th>
                    <th class="col-md-1">Perumahan</th>
                    <th class="col-md-1">Sumber Informasi</th>
                    <th class="col-md-2 ">Payment</th>
                    <th class="col-md-2">Income</th>
                    <th class="col-md-2">DP</th>
                    <th class="col-md-2">Tanggal</th>
                    <th class="col-md-2">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($penawaran as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->rumah->no_kavling}}</td>
                        <td>{{ $p->perumahan->perumahan }}</td>

                        <td>{{ $p->sumber_informasi}}</td>
                        <td>{{ $p->payment }}</td>
                        <td>{{ $p->income }}</td>
                        <td>{{ $p->dp }}</td>
                        <td>{{ $p->created_at->format('d/m/y') }}</td>



                        <td>
                            {{-- <a href='{{ route('admin.showTeacher', ['management' => $m->slug])  }}' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                            {{-- <a href='#' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                            {{-- <a href="{{ route('admin.editTeacher', ['management' => $m->slug]) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a> --}}
                            <a href="" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="{{ url('/penawaran/pdf/' . $p->id) }}" class="btn btn-primary btn-sm"  data-bs-toggle="tooltip" title="Download PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>

                            @if (auth()->user()->role !== 'salesAdmin')
                            <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deletePenawaran') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                                <input type="hidden" name="id" value="{{ $p->id }}">
                                <button type="submit" name="submit" class="btn btn-danger btn-sm"  data-bs-toggle="tooltip" title="Delete"><i class="bi bi-trash-fill"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
		</table>


		<div class="d-flex align-items-end flex-column p-2 mb-2">

		</div>

		{{-- {{ $management->withQueryString()->links() }} --}}
  </div>
</div>

</section>
@endsection


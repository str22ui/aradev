@extends('admin.layouts.index', ['title' => 'Survey', 'page_heading' => 'Data Survey'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">


        <a href="{{ route('admin.createSurvey') }}" class="btn btn-success me-2 py-2" >
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
                    <th class="col-md-2">Nama</th>
                    <th class="col-md-2">Perumahan</th>
                    <th class="col-md-2">No HP</th>
                    <th class="col-md-2">Sumber</th>
                    <th class="col-md-1">Survey</th>
                    <th class="col-md-1">Jam</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($survey as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nama_konsumen }}</td>
                    <td>{{ $s->perumahan }}</td>
                    <td>{{ $s->no_hp }}</td>
                    <td>{{ $s->sumber_informasi }}</td>
                    <td>{{ $s->tanggal_janjian }}</td>
                    <td>{{ $s->waktu_janjian }}</td>
                    {{-- <td>{{ $s->agent->nama ?? 'No Data'}}</td> --}}
                    <td>
                        {{-- <a href='' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                        {{-- <a href='{{ route('admin.showEbook', ['ebook' => $e->slug])  }}' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                        <a href="{{ route('admin.editSurvey', ['id' => $s->id]) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteSurvey') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                            <input type="hidden" name="id" value="{{ $s->id }}">
                            <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </tbody>
		</table>


		<div class="d-flex align-items-end flex-column p-2 mb-2">

		</div>

		{{-- {{ $ebook->withQueryString()->links() }} --}}
  </div>
</div>

</section>
@endsection



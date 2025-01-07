@extends('admin.layouts.index', ['title' => 'Article Category Bursa', 'page_heading' => 'Master Data Article Category Bursa'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		
        <a href="{{ route('admin.createCategoryBursa') }}" class="btn btn-success me-2 py-2" >
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
                    <th class="col-md-2">Name</th>
                    <th class="col-md-3">Slug</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoryBursa as $c)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->slug }}</td>
                    <td>
                        <a href="{{ route('admin.editCategoryBursa', ['categoryBursa' => $c->slug]) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteCategoryBursa', ['categoryBursa' => $c->slug]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </tbody>
		</table>
			
	
		<div class="d-flex align-items-end flex-column p-2 mb-2">
		
		</div>
		
		{{ $categoryBursa->withQueryString()->links() }}
  </div>
</div>

</section>
@endsection
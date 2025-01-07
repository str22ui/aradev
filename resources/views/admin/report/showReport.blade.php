@extends('admin.layouts.index', ['title' => 'Teacher', 'page_heading' => 'Detail Teacher'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="mt-3">{{ $management->name }}</h1>
            <p>{{ $management->position->name }}</p>
            <a class="btn btn-success" href="{{ route('admin.teacher') }}"><span data-feather="arrow-left"></span>Back to all my teacher</a>
            <a class="btn btn-warning" href="{{ route('admin.editTeacher', ['management' => $management->slug]) }}"><span data-feather="edit"></span>Edit</a>
            <form class="d-inline" action="{{ route('admin.deleteTeacher', ['management' => $management->slug]) }}" method="POST">
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Aare you sure?')"><span data-feather="x-circle"></span>Delete</button>
            </form>
            {{-- <div class="mt-3 p-2" style="background: #DFDFDF;">
                <a class="mt-3" target="_blank" href="{{ route('download', $ebook->slug) }}">Download URL : {{ route('download', $ebook->slug) }}</a>
            </div> --}}
            <img src="{{ env('STORAGE_URL') .$management->img }}" class="img-fluid mt-2 mb-2" alt="gambar laaa" />
                {{-- @if ($book->book_cover !== 'kosong')
                <div style="max-height: 600px; overflow: hidden;"> 
                    <img src="{{ env('STORAGE_URL') . $book->book_cover }}" class="img-fluid mt-2" alt="{{ $book->title }}">
                </div>
                @else
                <img src="https://source.unsplash.com/1200x600?programming" class="img-fluid mt-2" alt="{{ $book->title }}">
                @endif --}}
        </div>
    </div>
</div>
@endsection

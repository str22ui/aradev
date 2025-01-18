@extends('client.layouts.index')

@section('title', '')
<div class="mx-auto md:mt-32 px-6 mt-24 pt-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">{{ $info->title }}</h1>
<div class="container mx-auto px-4">
    <div class="bg-white shadow rounded overflow-hidden">
        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $info->imagesInfo->first()->image_path) }}" alt="Image">
        <div class="p-4">
            <p class="text-sm text-blue-500 font-semibold">{{ $info->status }}</p>
            <h1 class="text-2xl font-bold mb-4">{{ $info->title }}</h1>
            <p class="text-gray-600 mb-4">{{ $info->headline }}</p>
            <div class="prose">
                {!! $i->description !!}
            </div>
        </div>
    </div>
</div>


@extends('client.layouts.index')

@section('title', '')
<div class="bg-gradient-to-r from-blue-500 via-cyan-400 to-purple-600 py-12">
    <div class="container mx-auto px-4 pt-36">
        <h1 class="text-4xl font-extrabold text-white text-center mb-12">Apa Kata Mereka?</h1>
        <div class="flex flex-col gap-8">
            @foreach ($testimony as $t)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-transform transform hover:scale-105 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="relative w-16 h-16">
                            <img
                                class="w-full h-full rounded-full object-cover border-4 border-gradient-to-r from-purple-500 to-pink-500"
                                src="{{ asset('storage/' . $t->image) }}"
                                alt="{{ $t->name }}">
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">{{ $t->name }}</h2>
                            <h3 class="text-sm text-gray-600">{{ $t->pekerjaan }} - {{ $t->kota }}</h3>
                        </div>
                    </div>
                    <p class="prose text-gray-600 italic">
                        {!! $t->testimony !!}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>



@extends('client.layouts.index')

@section('title', '')
<div class="bg-gradient-to-r from-blue-500 via-cyan-400 to-purple-600 py-12">
    <div class="container mx-auto px-4 pt-36">
        <h1 class="text-4xl font-extrabold text-white text-center mb-12">Apa Kata Mereka?</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($testimony as $t)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-transform transform hover:scale-105 overflow-hidden">
                <div class="p-6 text-center">
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img
                            class="w-full h-full rounded-full object-cover border-4 border-transparent"
                            src="{{ asset('storage/' . $t->image) }}"
                            alt="{{ $t->name }}">
                        <div class="absolute inset-0 rounded-full border-4 border-gradient-to-r from-purple-500 to-pink-500"></div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $t->name }}</h2>

                    <td class="prose text-gray-600 italic mt-4">
                        {!! $t->testimony !!}
                    </td>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


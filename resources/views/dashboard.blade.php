{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}



@extends('layouts.app')

@section('content')
    <div class="flex min-h-lvh" style="background-image: linear-gradient( 111.4deg,  rgba(7,7,9,1) 6.5%, rgba(27,24,113,1) 93.2% );">
        @include('admin.sidebar') <!-- Include the sidebar template -->

        <div class="flex-1 ml-6 mt-10 mr-10 ">

            <p class="text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-rose-600 via-red-400 to-orange-500 mt-52 flex items-center justify-center"
                style="margin-left: -50px">
                DELICE PLACEMENT
            </p>
        </div>
    </div>
@endsection

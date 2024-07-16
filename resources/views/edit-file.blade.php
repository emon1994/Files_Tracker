<!-- resources/views/files/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="flex h-screen max-w-full">
        @include('admin.sidebar') <!-- Include the sidebar template -->

        <div class="flex-1 ml-6 mt-5 mr-10 ">

            <div class="flex items-center justify-center p-12">
                <!-- Author: FormBold Team -->
                <div class="mx-auto w-full max-w-[1000px]  rounded-md p-10 bg-gradient-to-r from-blue-800 to-indigo-900">

                    @if (session('success'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <p class="text-2xl font-bold text-yellow-50 ml-3">Edit File Information</p>
                    @if (session('success'))
                        <div
                            class="bg-gradient-to-r from-green-400 to-green-600 border-l-4 border-green-700 text-green-900 px-3 py-2 mb-4 rounded-md max-w-full">
                            <div class="flex justify-center items-center">
                                <svg class="h-4 w-4 text-green-700 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="text-sm text-white font-medium ">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('update-file', $file->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Client ID dropdown -->
                        <div class="mb-5">
                            <label for="client_id" class="block font-medium text-sm text-white">Client</label>
                            <select name="client_id" id="client_id"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $client->id == $file->client_id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    

                        <div class="mb-5">
                            <label for="country">Country</label>
                            <select name="country" id="country"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option value="" disabled>Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country }}"
                                        {{ $country->country == $file->country ? 'selected' : '' }}>
                                        {{ $country->country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Files input for adding new files -->
                        <div class="mb-5">
                            <label for="files">Add New Files</label>
                            <input type="file" name="files[]" id="files" multiple
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        </div>

                        <!-- Existing files display and delete option -->
                        <div class="mb-5">
                            <label class="block font-medium text-sm text-white">Existing Files</label>
                            <ul>
                                @foreach ($file->fileDetails as $fileDetail)
                                    <li>
                                        @if (pathinfo($fileDetail->file_path, PATHINFO_EXTENSION) === 'jpg' ||
                                                pathinfo($fileDetail->file_path, PATHINFO_EXTENSION) === 'jpeg' ||
                                                pathinfo($fileDetail->file_path, PATHINFO_EXTENSION) === 'png')
                                            <div class="flex justify-between bg-slate-100 p-3 rounded-lg mb-2">
                                                <div>
                                                    <img src="{{ asset(str_replace('public', 'storage', $fileDetail->file_path)) }}"
                                                        alt="{{ $fileDetail->filename }}"
                                                        style="width: 100px; height: 80px; margin-bottom: 10px;">
                                                </div>
                                                <div>
                                                    <a class="bg-red-700 px-3 py-2 rounded-md text-white "
                                                        href="{{ route('delete-filedetail', $fileDetail->id) }}">delete</a>
                                                </div>

                                            </div>
                                        @else
                                            <div class="flex justify-between bg-slate-100 p-3 rounded-lg mb-2">
                                                <div>
                                                    <a href="{{ asset(str_replace('public', 'storage', $fileDetail->file_path)) }}"
                                                        target="_blank"
                                                        class="text-blue-600">{{ $fileDetail->filename }}</a>
                                                </div>
                                                <div>
                                                    <a href="{{ route('delete-filedetail', $fileDetail->id) }}"
                                                        class="bg-red-700 px-3 py-2 rounded-md text-white ">delete</a>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- <form action="{{ route('delete-filedetail', $fileDetail->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 ml-2">Delete</button>
                                        </form> --}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Note input -->
                        <div class="mb-5">
                            <label for="note" class="block font-medium text-sm text-white">Note</label>
                            <textarea name="note" id="note"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ $file->note }}</textarea>
                        </div>

                        <!-- Receiver input -->
                        <div class="mb-5">
                            <label for="receiver" class="block font-medium text-sm text-white">Received By</label>
                            <input type="text" name="receiver" id="receiver" value="{{ $file->receiver }}"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        </div>
                        <div class="mb-5">
                            <label for="status" class="block font-medium text-sm text-white">Change status</label>
                            <select name="status" id=""
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option value="processing">processing</option>
                                <option value="success">success</option>
                                <option value="rejected">rejected</option>
                                <option value="return">return</option>
                            </select>
                        </div>

                        <!-- Submit button -->
                        <div>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Update File</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

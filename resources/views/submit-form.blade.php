@extends('layouts.app')

@section('content')
    <div class="flex  h-screen">
        @include('admin.sidebar') <!-- Include the sidebar template -->

        <div class="flex-1 ml-6 mt-5 mr-10 " style="margin-left: -40px;">

            <div class="flex items-center justify-center p-12">
                <!-- Author: FormBold Team -->
                <div class="mx-auto w-full max-w-[1000px]  rounded-md p-10"
                    style="background-image: linear-gradient(to right, #243949 0%, #517fa4 100%);">
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

                    @if (session('error'))
                        <div
                            class="bg-gradient-to-r from-red-400 to-red-600 border-l-4 border-red-700 text-red-900 px-3 py-2 mb-4 rounded-md max-w-xs">
                            <div class="flex justify-center items-center">
                                <svg class="h-4 w-4 text-red-700 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                                <p class="text-sm font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('file-information') }} " method="post" enctype="multipart/form-data">
                        @csrf


                        <div class="mb-5">
                            <label for="client_id" class="mb-2 block text-sm font-medium text-[#e0e0e6]">
                                B2B Partners
                            </label>
                            <select name="client_id" id="client_id"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option value="" disabled selected>Select Partner</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-5">
                            <label for="country" class="mb-2 block text-sm font-medium text-[#f2f2f7]">
                                Country
                            </label>
                            <select name="country" id="country"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option value="" disabled selected>Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country }}">{{ $country->country }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-5">
                            <label for="files" class="mb-2 block  font-medium text-[#f2f2f7] text-sm">
                                Files
                            </label>
                            <input type="file" name="files[]" id="files" multiple
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>

                        <div class="mb-5">
                            <label for="note" class="mb-2 block text-sm font-medium text-[#f2f2f7]">
                                Note
                            </label>
                            <textarea name="note" id="note" placeholder="Enter your note"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md resize-none"
                                rows="2"></textarea>
                        </div>

                        <div class="mb-5">
                            <label for="country" class="mb-2 block text-sm font-medium text-[#f2f2f7]">
                                Received By
                            </label>
                            <input type="text" name="receiver" id="receiver" placeholder="Enter the receiver name"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>


                        {{-- button --}}
                        <div class="mt-3">
                            <button type="submit"
                                class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-4 px-8 mt-4 text-center text-base font-semibold text-white outline-none">
                                Add File
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            </p>
        </div>
    </div>
@endsection

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

                    <form action="{{ route('client-information') }}" method="post">
                        @csrf

                        {{-- name field --}}
                        <div class="mb-5">
                            <label for="name" class="mb-2 block text-sm font-medium text-[#e0e0e6]">
                                Full Name
                            </label>
                            <input type="text" name="name" id="name" placeholder="Full Name"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>

                        {{-- mobile field --}}
                        <div class="mb-5">
                            <label for="mobile" class="mb-2 block text-sm font-medium text-[#f2f2f7]">
                                Phone Number
                            </label>
                            <input type="text" name="mobile" id="mobile" placeholder="Enter your phone number"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>

                        {{-- email address --}}
                        <div class="mb-5">
                            <label for="email" class="mb-2 block text-sm font-medium text-[#f2f2f7]">
                                Email Address
                            </label>
                            <input type="email" name="email" id="email" placeholder="Enter your email"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>

                        {{-- company field --}}
                        <div class="mb-5">
                            <label for="company" class="mb-2 block text-sm font-medium text-[#f2f2f7]">
                                Company
                            </label>
                            <input type="text" name="company" id="company" placeholder="Enter your company name"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>

                        {{-- address field --}}
                        <div class="mb-7">
                            <label for="address" class="mb-2 block text-sm font-medium text-[#f2f2f7]">
                                Address
                            </label>
                            <input type="text" name="address" id="address" placeholder="Enter your address"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">

                        </div>

                        {{-- button --}}
                        <div class="mt-3">
                            <button type="submit"
                                class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-4 px-8 text-center text-base font-semibold text-white outline-none">
                                Add Client
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            </p>
        </div>
    </div>
@endsection

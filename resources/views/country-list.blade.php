@extends('layouts.app')

@section('content')
    <div class="flex max-w-full min-h-lvh">
        @include('admin.sidebar')

        <div class="flex-1 ml-6 mt-2 mr-10" style="margin-left: -40px;">
            <div class="flex items-center justify-center p-12">
                <div class="mx-auto w-full max-w-[1000px] rounded-md p-10 bg-gradient-to-r from-blue-800 to-indigo-900">
                    <div class="flex justify-between border-b mb-1">
                        <div>
                            <p
                                class="text-3xl mb-2 font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-rose-600 via-red-400 to-orange-500  flex items-center justify-center">
                                FILES</p>
                        </div>
                        <div>
                            <a href="{{ route('add-country') }}"
                                class="bg-gradient-to-r from-red-500 to-pink-500 text-white mr-2 py-2 px-2 rounded-md">add
                                country</a>
                        </div>
                    </div>
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
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <p class="text-sm font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif


                    <div class="mb-3">

                        <table class="border-separate border-spacing-y-2 text-sm w-full">
                            <thead class="bg-gradient-to-r from-indigo-400 to-cyan-400 text-white text-center rounded">
                                <tr>
                                    <th class="px-4 py-3">Partner</th>
                                    <th class="px-4 py-3">Country</th>

                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="font-medium text-center">
                                @foreach ($countries as $country)
                                    <tr>
                                        <td class="td-class">{{ $country->id }}</td>
                                        <td class="td-class">{{ $country->country }}</td>
                                        <td class="td-class">
                                            <div class="flex justify-end">

                                                <a href="{{ route('edit-country', $country->id) }}"
                                                    class="mr-2 bg-gradient-to-r from-blue-400 to-emerald-400 text-white py-1 px-2 rounded-md">Edit</a>
                                                <a href="{{ route('delete-country', $country->id) }}"
                                                    class="delete-btn bg-gradient-to-r from-red-500 to-pink-500 text-white py-1 px-2 rounded-md"
                                                    data-id="{{ $country->id }}">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>


                    <!-- Pagination Links -->
                    <div class="flex justify-end text-white">
                        {{ $countries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');

            // Add click event listener to each delete button
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const fileId = this.getAttribute('data-id');

                    // Show SweetAlert confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to delete route
                            window.location.href = "{{ url('delete-file') }}/" + fileId;
                        }
                    });
                });
            });
        });
    </script> --}}
@endsection

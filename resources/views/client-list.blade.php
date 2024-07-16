@extends('layouts.app')

@section('content')
    <div class="flex h-screen max-w-full">
        @include('admin.sidebar') <!-- Include the sidebar template -->

        <div class="flex-1 ml-6 mt-5 mr-10 " style="margin-left: -40px;">

            <div class="flex items-center justify-center p-12">
                <!-- Author: FormBold Team -->
                <div class="mx-auto w-full max-w-[1000px]  rounded-md p-10 bg-gradient-to-r from-blue-800 to-indigo-900">
                    <p class="text-2xl font-bold text-yellow-50 ml-3">List Of Partners</p>
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
                    <div class="flex items-center justify-center">
                        <table class="border-separate border-spacing-y-2 text-sm">
                            <thead
                                class="bg-gradient-to-r from-indigo-400 to-cyan-400  text-white
                            text-center w-full rounded">
                                <tr>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Company</th>
                                    <th class="px-4 py-3">Mobile</th>
                                    <th class="px-4 py-3">Address</th>
                                    <th class="px-4 py-3"> Action</th>
                                </tr>
                            </thead>
                            <tbody class="font-medium">
                                @foreach ($clients as $client)
                                    <tr>
                                        <td span="col" class="td-class">{{ $client->name }}</td>
                                        <td class="td-class">{{ $client->email }}</td>
                                        <td class="td-class">{{ $client->company }}</td>
                                        <td class="td-class">{{ $client->mobile }}</td>
                                        <td class="td-class">{{ $client->address }}</td>
                                        <td class="td-class">
                                            <span class="flex justify-between">
                                                <a href="{{ route('view-client-files', $client->id) }}"
                                                    class="mr-2 bg-gradient-to-r from-blue-400 to-emerald-400 text-white py-1 px-2 rounded-md">
                                                    Files
                                                </a>
                                                <a href="{{ route('edit-client', $client->id) }}"
                                                    class="mr-2 bg-gradient-to-r from-blue-400 to-emerald-400 text-white py-1 px-2 rounded-md">
                                                    Edit
                                                </a>
                                                <a href="#"
                                                    class="delete-btn bg-gradient-to-r from-red-500 to-pink-500 text-white py-1 px-2 rounded-md"
                                                    data-id="{{ $client->id }}">
                                                    Delete
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
            </p>
        </div>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');

            // Add click event listener to each delete button
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const clientId = this.getAttribute('data-id');

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
                            window.location.href = "{{ url('delete-client') }}/" +
                                clientId;
                        }
                    });
                });
            });
        });
    </script>
@endsection

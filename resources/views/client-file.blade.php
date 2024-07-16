@extends('layouts.app')

@section('content')
    <div class="flex h-screen max-w-full">
        @include('admin.sidebar')

        <div class="flex-1 ml-6 mt-2 mr-10" style="margin-left: -40px;">
            <div class="flex items-center justify-center p-12">
                <div class="mx-auto w-full max-w-[1000px] rounded-md p-10 bg-gradient-to-r from-blue-800 to-indigo-900">
                    <div class="flex justify-between">
                        <div>
                            <p
                                class="text-3xl mb-2 font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-rose-600 via-red-400 to-orange-500  flex items-center justify-center">
                                FILES
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('export-client-file') }}"
                                class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-2 rounded">
                                export</a>
                        </div>
                    </div>
                    <hr>
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

                    @foreach ($codes as $code)
                        @if (isset($files[$code->code]))
                            <div class="mb-3 mt-2">
                                <p class="text-md font-bold text-white">
                                    <span class="text-sm">{{ $code->code }}</span>
                                </p>
                                <table class="border-separate border-spacing-y-2 text-sm w-full">
                                    <thead
                                        class="bg-gradient-to-r from-indigo-400 to-cyan-400 text-white text-center rounded">
                                        <tr>
                                            <th class="px-4 py-3">Partner</th>
                                            <th class="px-4 py-3">Country</th>
                                            <th class="px-4 py-3">Note</th>
                                            <th class="px-4 py-3">Receiver</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3">Files</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-medium">
                                        @foreach ($files[$code->code] as $file)
                                            <tr>
                                                <td class="td-class">{{ $file->client->name }}</td>
                                                <td class="td-class">{{ $file->country }}</td>
                                                <td class="td-class">{{ $file->note }}</td>
                                                <td class="td-class">{{ $file->receiver }}</td>
                                                <td class="td-class">{{ $file->status }}</td>
                                                <td class="td-class">
                                                    <ul>
                                                        @foreach ($file->fileDetails as $fileDetail)
                                                            <li class="mb-2">
                                                                @if (in_array(pathinfo($fileDetail->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                    <img src="{{ asset(str_replace('public', 'storage', $fileDetail->file_path)) }}"
                                                                        alt="{{ $fileDetail->filename }}"
                                                                        style="width: 100px; height: 80px;">
                                                                @else
                                                                    <a class="text-blue-600"
                                                                        href="{{ asset(str_replace('public', 'storage', $fileDetail->file_path)) }}"
                                                                        target="_blank">{{ $fileDetail->filename }}</a>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="td-class">
                                                    <div class="flex justify-end">
                                                        @if ($file->status == 'rejected')
                                                            <a href="{{ route('transfer-file', $file->id) }}"
                                                                class="mr-2 bg-gradient-to-r from-blue-400 to-emerald-400 text-white py-1 px-2 rounded-md">Transfer</a>
                                                        @endif
                                                        <a href="{{ route('edit-file', $file->id) }}"
                                                            class="mr-2 bg-gradient-to-r from-blue-400 to-emerald-400 text-white py-1 px-2 rounded-md">Edit</a>
                                                        <a href="#"
                                                            class="delete-btn bg-gradient-to-r from-red-500 to-pink-500 text-white py-1 px-2 rounded-md"
                                                            data-id="{{ $file->id }}">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endforeach

                    <!-- Pagination Links -->
                    <div class="flex justify-end text-white">
                        {{ $codes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const fileId = this.getAttribute('data-id');

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
                            window.location.href = "{{ url('delete-file') }}/" + fileId;
                        }
                    });
                });
            });
        });
    </script>
@endsection

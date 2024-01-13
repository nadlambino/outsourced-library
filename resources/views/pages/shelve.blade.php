<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shelve') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                @if(session('message'))
                    <div class="border border-green-500 p-3 mb-5 text-green-500 rounded-md w-full md:w-1/2 mx-auto text-center">
                        <span>{{ session('message') }}</span>
                    </div>
                @endif
                @error('bookId')
                <div class="border border-red-500 p-3 mb-5 text-red-500 rounded-md w-full md:w-1/2 mx-auto text-center">
                    @foreach($errors->get('history') as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
                @enderror
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Title</th>
                            <th scope="col" class="px-6 py-3">Author</th>
                            <th scope="col" class="px-6 py-3">Borrowed Since</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-4">{{ $history->book->title }}</td>
                                <td class="px-6 py-4">{{ $history->book->author->name }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($history->borrowed_at)->format('M d Y h:i A') }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('book.return') }}">
                                        @csrf
                                        <input type="hidden" name="history" value="{{ $history->id }}">
                                        <x-primary-button disabled="{{ isset($book->is_returned) }}">
                                            {{ __('Return') }}
                                        </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-4 text-center" colspan="4">No borrowed books to return.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

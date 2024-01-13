<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Library') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto">
                @if(session('message'))
                    <div class="border border-green-500 p-3 mb-5 text-green-500 rounded-md w-full md:w-1/2 mx-auto text-center">
                        <span>{{ session('message') }}</span>
                    </div>
                @endif
                @error('book')
                    <div class="border border-red-500 p-3 mb-5 text-red-500 rounded-md w-full md:w-1/2 mx-auto text-center">
                        @foreach($errors->get('book') as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @enderror

                @if(count($books) === 0)
                    <div class="text-gray-500 text-xl text-center">
                        No books are available to borrow.
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-5 md:grid-cols-3 lg:grid-cols-5 justify-items-center my-5 relative px-5">
                    @foreach($books as $book)
                        <div class="flex flex-col items-center gap-3" title="{{ $book->title }}">
                            <div class="bg-gray-700 rounded-l-md rounded-r-sm h-56 flex justify-end relative w-[180px] shadow-2xl">
                                <div class="w-[90%] bg-gray-500 flex flex-col justify-start pt-5 rounded-r-sm">
                                    <div class="bg-gray-300 h-[65px] line-clamp-3 px-5 py-1 text-sm font-bold">
                                        {{ $book->title }}
                                    </div>
                                </div>
                                <span class="absolute bottom-2 right-2 text-xs text-gray-900">{{ $book->author->name }}</span>
                            </div>
                            <form method="POST" action="{{ route('book.borrow') }}">
                                @csrf
                                <input type="hidden" name="book" value="{{ $book->id }}">
                                <x-primary-button disabled="{{ (bool) $book->is_borrowed }}">
                                    {{ __('Borrow') }}
                                </x-primary-button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

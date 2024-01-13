<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shelf') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto px-5">
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

                @if(count($histories) === 0)
                    <div class="text-gray-500 text-xl text-center">
                        Your shelf is empty, visit your
                        <a href="{{route('library')}}" class="hover:underline text-blue-500">library</a>
                        to borrow some books.
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-5 md:grid-cols-3 lg:grid-cols-5 justify-items-center my-5 relative px-5">
                    @foreach($histories as $history)
                        <div class="flex flex-col items-center gap-3" title="{{ $history->book->title }}">
                            <div class="bg-gray-700 rounded-l-md rounded-r-sm h-56 flex justify-end relative w-[180px] shadow-2xl">
                                <div class="w-[90%] bg-gray-500 flex flex-col justify-start pt-5 rounded-r-sm">
                                    <div class="bg-gray-300 h-[65px] line-clamp-3 px-5 py-1 text-sm font-bold">
                                        {{ $history->book->title }}
                                    </div>
                                </div>
                                <span class="absolute bottom-2 right-2 text-xs text-gray-900">{{ $history->book->author->name }}</span>
                            </div>
                            <form method="POST" action="{{ route('book.return') }}">
                                @csrf
                                <input type="hidden" name="history" value="{{ $history->id }}">
                                <x-primary-button disabled="{{ isset($book->is_returned) }}">
                                    {{ __('Return') }}
                                </x-primary-button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Shorts Listing
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">

                <div class="p-1">
                    <Link class="bg-indigo-600 text-white rounded-md  px-4 py-2" modal  href="{{ route('shorts.create') }}">Add New Short
                    </Link>
                </div>


                <x-splade-table class="mt-5" :for="$data">
                    <x-splade-cell file as="$item">
                        @if($item->file)
                            <video width="100" height="100" controls>
                                <source src="{{ $item->file }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </x-splade-cell>
                    <x-splade-cell actions as="$item">

{{--                        <Link class="text-green-600 hover:text-green-400 font-semibold" modal href="{{ route('versions.edit', $item) }}"> Edit </Link>--}}

                        <Link
                            class="text-red-600 hover:text-red-400 pl-3"
                            confirm="Delete"
                            confirm-text="Are you sure you want to delete this version?"
                            confirm-button="Delete"
                            cancel-button="Cancel"
                            href="{{ route('shorts.destroy', $item) }}" method="DELETE">
                        Delete
                        </Link>

                    </x-splade-cell>
                </x-splade-table>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            Create new user--}}
{{--        </h2>--}}
    </x-slot>

    <x-splade-modal>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editing  {{ $live->title }}
        </h2>
    <div class="py-12">

        <x-splade-form :default="$live" action="{{ route('live.store') }}">
            <x-splade-input class="mt-3" label="Title" name="title" />
            <x-splade-input class="mt-3" name="link" label="link" />


            <x-splade-submit class="mt-3" label="Update" />

        </x-splade-form>
    </div>
    </x-splade-modal>
</x-app-layout>

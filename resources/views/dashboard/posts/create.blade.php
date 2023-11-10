<x-app-layout>
    <x-slot name="header">
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            Create new user--}}
{{--        </h2>--}}
    </x-slot>

    <x-splade-modal>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add new ads
        </h2>
    <div class="py-12">

        <x-splade-form  action="{{ route('ads.store') }}">
            <x-splade-input class="mt-3" label="Title" name="title" />
            <x-splade-textarea class="mt-3" name="description" label="Description (optional)" autosize />

            <x-splade-file class="mt-3" filepond lable="Image" name="file" />

            <x-splade-submit class="mt-3" label="Submit" />

        </x-splade-form>
    </div>
    </x-splade-modal>
</x-app-layout>

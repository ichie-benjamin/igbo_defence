<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Wordpress News
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">


                <x-splade-table class="mt-5" :for="$data">
{{--                    <x-splade-cell video as="$item">--}}
{{--                        @if($item->video)--}}
{{--                            <video width="100" height="100" controls>--}}
{{--                                <source src="{{ $item->video }}" type="video/mp4">--}}
{{--                                Your browser does not support the video tag.--}}
{{--                            </video>--}}
{{--                        @endif--}}
{{--                    </x-splade-cell>--}}

                    <x-splade-cell thumbnail as="$item">
                        <img height="100px" width="100px" src="{{ $item->thumbnail->size(Corcel\Model\Meta\ThumbnailMeta::SIZE_THUMBNAIL)?->url }}" />
                    </x-splade-cell>

                </x-splade-table>
            </div>
        </div>
    </div>
</x-app-layout>

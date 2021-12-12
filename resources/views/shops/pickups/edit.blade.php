<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <x-utils.link href="{{ route('shops.show', $shop->id) }}" class="mr-4"><</x-utils.link>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($pickup) ? 'Edit Pickup Location #' . $pickup->id : 'Create New Pickup Location'  }} For {{ $shop->label }}
            </h2>
        </div>
    </x-slot>
    <x-utils.container class="py-12">
        <form action="{{ isset($pickup) ? route('shops.pickups.update', [$shop->id, $pickup->id]) : route('shops.pickups.store', $shop->id) }}" method="POST">

            @csrf

            @if (isset($pickup))
                @method('put')
            @else
                @method('post')
            @endif

            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Geo Location') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="label">{{ __('Latitude') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="latitude" id="latitude" value="{{ old('latitude', isset($pickup->geo_location) ? $pickup->geo_location->getLat() : '') }}" />
                                    </x-forms.input-group>
                                </div>
                                <div class="col-span-3">
                                    <x-forms.label for="label">{{ __('Longtitude') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="longtitude" id="longtitude" value="{{ old('longtitude', isset($pickup->geo_location) ? $pickup->geo_location->getLng() : '') }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end my-8">
                <x-forms.button type="reset" class="bg-white border-gray-300 mr-2">{{ __('Cancel') }}</x-button>
                <x-forms.button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-button>
            </div>

        </form>

    </x-utils.container>
</x-app-layout>

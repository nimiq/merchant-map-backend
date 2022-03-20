<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <x-utils.link href="{{ route('shops.show', $shop->id) }}" class="mr-4"><</x-utils.link>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($shipping) ? 'Edit Shipping Limits #' . $shipping->id : 'Create new Shipping Limits'  }} For {{ $shop->label }}
            </h2>
        </div>
    </x-slot>
    <x-utils.container class="py-12">
        <form action="{{ isset($shipping) ? route('shops.shippings.update', [$shop->id, $shipping->id]) : route('shops.shippings.store', $shop->id) }}" method="POST">

            @csrf
            @if (isset($shipping))
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
                                        <x-forms.input type="text" name="latitude" id="latitude" value="{{ old('latitude', isset($shipping->geo_location) ? $shipping->geo_location->getLat() : '') }}" />
                                    </x-forms.input-group>
                                </div>
                                <div class="col-span-3">
                                    <x-forms.label for="label">{{ __('Longtitude') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="longtitude" id="longtitude" value="{{ old('longtitude', isset($shipping->geo_location) ? $shipping->geo_location->getLng() : '') }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>
                            <div class="col-span-3">
                                <x-forms.label for="radius">{{ __('Radius') }}</x-forms.label>
                                <x-forms.input-group>
                                    <x-forms.input type="text" name="radius" id="radius" value="{{ old('radius', $shipping->radius ?? '') }}" />
                                </x-forms.input-group>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Countries') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="label">{{ __('Countries') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="countries" id="countries" placeholder="[&quot;NL&quot;, &quot;DE&quot;, &quot;CR&quot;]" value="{{ old('countries', $shipping->countries ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex justify-end my-8 items-center">
                <x-utils.link href="{{ route('shops.show', $shop->id) }}" class="mr-2">{{ __('Cancel') }}</x-utils.link>
                <x-forms.button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Save') }}</x-button>
            </div>

        </form>
    </x-utils.container>
</x-app-layout>

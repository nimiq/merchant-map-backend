<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <x-utils.link href="{{ route('shops.index') }}" class="mr-4"><</x-utils.link>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $shop->label }}
            </h2>
        </div>
    </x-slot>

    <x-utils.container class="py-12">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">General Information</h3>
                    <p class="mt-1 text-sm text-gray-600">
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('shops.update', $shop->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="label">{{ __('Label*') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="label" id="label" value="{{ old('label', $shop->label) }}" required />
                                    </x-forms.input-group>
                                </div>
                            </div>

                            <div class="col-span-3">
                                <x-forms.label for="description">{{ __('Description*') }}</x-forms.label>
                                <x-forms.input-group>
                                    <x-forms.text-area type="text" name="description" id="description" required>{{ old('description', $shop->description) }}</x-forms.text-area>
                                </x-forms.input-group>
                            </div>

                            <h2>Source</h2>

                            <div class="grid grid-cols-3 gap-6">

                                <div class="col-span-3">
                                    <x-forms.label for="object_id">{{ __('Object ID') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="object_id" id="object_id" value="{{ old('object_id', $shop->object_id) }}" />
                                    </x-forms.input-group>
                                </div>

                                <div class="col-span-3">
                                    <x-forms.label for="source_id">{{ __('Source ID') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="source_id" id="source_id" value="{{ old('source_id', $shop->source_id) }}" />
                                    </x-forms.input-group>
                                </div>

                            </div>

                            <h2>
                                Contact information
                            </h2>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="source_id">{{ __('Website URL') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="website" id="website" value="{{ old('website', $shop->website) }}" />
                                    </x-forms.input-group>
                                </div>

                                <div class="col-span-3">
                                    <x-forms.label for="source_id">{{ __('Email*') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="email" name="email" id="email" value="{{ old('email', $shop->email) }}" required/>
                                    </x-forms.input-group>
                                </div>

                                <div class="col-span-3">
                                    <x-forms.label for="phone">{{ __('Phone') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="tel" name="phone" id="phone" value="{{ old('phone', $shop->phone) }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>

                            <h2>
                                Address
                            </h2>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-2">
                                    <x-forms.label for="street">{{ __('Street') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="street" id="street" value="{{ old('street', $shop->street) }}" />
                                    </x-forms.input-group>
                                </div>
                                <div class="col-span-1">
                                    <x-forms.label for="number">{{ __('Number') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="number" id="number" value="{{ old('number', $shop->number) }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-1">
                                    <x-forms.label for="zip">{{ __('Zip') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="zip" id="zip" value="{{ old('zip', $shop->zip) }}" />
                                    </x-forms.input-group>
                                </div>
                                <div class="col-span-2">
                                    <x-forms.label for="city">{{ __('City') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="city" id="city" value="{{ old('city', $shop->city) }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="country">{{ __('Country') }}</x-frms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="country" id="country" value="{{ old('country', $shop->country) }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>

                            <div class="flex flex-row-reverse">
                                <x-forms.button type="submit" class="bg-blue-400 text-white">{{ __('Save') }}</x-button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="md:grid md:grid-cols-3 md:gap-6 mt-16">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Locations</h3>
                    <p class="mt-1 text-sm text-gray-600">
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="#" method="POST">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </x-utils.container>
</x-app-layout>

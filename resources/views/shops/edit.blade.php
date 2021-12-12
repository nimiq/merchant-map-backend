<x-app-layout>

    <x-slot name="header">
        <div class="flex">
            <x-utils.link href="{{ route('shops.index') }}" class="mr-4"><</x-utils.link>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($shop) ? $shop->label : __('Add Shop') }}
            </h2>
        </div>
    </x-slot>

    <x-utils.container class="py-12">
        <form action="{{ isset($shop) ? route('shops.update', $shop->id) : route('shops.store')}}" method="POST">

            @csrf
            @if(isset($shop))
                @method('put')
            @else
                @method('post')
            @endif

            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('General Information') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="label">{{ __('Label*') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="label" id="label" value="{{ old('label', $shop->label ?? '') }}" required />
                                    </x-forms.input-group>
                                    @error('label')<span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-span-3">
                                <x-forms.label for="description">{{ __('Description*') }}</x-forms.label>
                                <x-forms.input-group>
                                    <x-forms.text-area type="text" name="description" id="description" required>{{ old('description', $shop->description ?? '') }}</x-forms.text-area>
                                </x-forms.input-group>
                                @error('description')<span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Source') }}</h3>
                        <p class="mt-1 text-sm text-gray-600"></p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="object_id">{{ __('Object ID') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="object_id" id="object_id" value="{{ old('object_id', $shop->object_id ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                                <div class="col-span-3">
                                    <x-forms.label for="source_id">{{ __('Source ID') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="source_id" id="source_id" value="{{ old('source_id', $shop->source_id ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Contact Information') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="source_id">{{ __('Website URL') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="website" id="website" value="{{ old('website', $shop->website ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                                <div class="col-span-3">
                                    <x-forms.label for="source_id">{{ __('Email*') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="email" name="email" id="email" value="{{ old('email', $shop->email ?? '') }}" required/>
                                    </x-forms.input-group>
                                    @error('email')<span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-span-3">
                                    <x-forms.label for="phone">{{ __('Phone') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="tel" name="phone" id="phone" value="{{ old('phone', $shop->phone ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Address') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-2">
                                    <x-forms.label for="street">{{ __('Street') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="street" id="street" value="{{ old('street', $shop->street ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                                <div class="col-span-1">
                                    <x-forms.label for="number">{{ __('Number') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="number" id="number" value="{{ old('number', $shop->number ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-1">
                                    <x-forms.label for="zip">{{ __('Zip') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="zip" id="zip" value="{{ old('zip', $shop->zip ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                                <div class="col-span-2">
                                    <x-forms.label for="city">{{ __('City') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="city" id="city" value="{{ old('city', $shop->city ?? '') }}" />
                                    </x-forms.input-group>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="country">{{ __('Country') }}</x-frms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="country" id="country" value="{{ old('country', $shop->country ?? '') }}" />
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

        @if (isset($shop))
            <div class="my-8 border-t border-gray-300 w-full"></div>
            <div class="md:grid md:grid-cols-3 md:gap-6 mt-16">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Shipping limits') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="bg-white space-y-6">
                            <x-table.table>
                                <x-slot name="tableHead">
                                    <x-table.header>{{ __('ID') }}</x-table.header>
                                    <x-table.header>
                                        <span class="sr-only">{{ __('Show') }}</span>
                                        <span class="sr-only">{{ __('Delete') }}</span>
                                    </x-table.header>
                                </x-slot>
                                <x-slot name="tableBody">
                                    @foreach($shop->shippings as $shipping)
                                        <tr>
                                            <x-table.data>{{ $shipping->id }}</x-table.data>
                                            <x-table.data class="text-right text-sm font-medium">
                                                <x-utils.link href="{{ route('shops.shippings.show', [ $shop->id, $shipping->id ]) }}" class="mr-4">{{ __('Edit') }}</x-utils.link>
                                                <form action="{{ route('shops.shippings.destroy', [ $shop->id, $shipping->id ]) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="text-red-500">{{ __('Delete') }}</button>
                                                </form>
                                            </x-table.data>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <x-table.data colspan="2">
                                            <x-utils.link href="{{ route('shops.shippings.create', $shop->id) }}">{{ __('Add New Shipping Limit') }}</x-utils.link>
                                        </x-table.data>
                                    </tr>
                                </x-slot>
                            </x-table.table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:grid md:grid-cols-3 md:gap-6 mt-16">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Pickup locations') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="bg-white space-y-6">
                            <x-table.table>
                                <x-slot name="tableHead">
                                    <x-table.header>{{ __('ID') }}</x-table.header>
                                    <x-table.header>
                                        <span class="sr-only">{{ __('Show') }}</span>
                                        <span class="sr-only">{{ __('Delete') }}</span>
                                    </x-table.header>
                                </x-slot>
                                <x-slot name="tableBody">
                                    @foreach($shop->pickups as $pickup)
                                        <tr>
                                            <x-table.data>{{ $pickup->id }}</x-table.data>
                                            <x-table.data class="text-right text-sm font-medium">
                                                <x-utils.link href="{{ route('shops.pickups.show', [ $shop->id, $pickup->id ]) }}" class="mr-4">{{ __('Edit') }}</x-utils.link>
                                                <form action="{{ route('shops.pickups.destroy', [ $shop->id, $shipping->id ]) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="text-red-500">{{ __('Delete') }}</button>
                                                </form>
                                            </x-table.data>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <x-table.data colspan="2">
                                            <x-utils.link href="{{ route('shops.pickups.create', $shop->id) }}">{{ __('Add New Pickup Location') }}</x-utils.link>
                                        </x-table.data>
                                    </tr>
                                </x-slot>
                            </x-table.table>
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </x-utils.container>
</x-app-layout>

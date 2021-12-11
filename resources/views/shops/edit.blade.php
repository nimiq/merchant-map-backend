<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shops Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white -b -gray-200">
                    <form action="{{ isset($shop) ? route('shops.update', $shop->id) : route('shops.store')}}" method="POST">

                        @csrf
                        @if(isset($shop))
                            @method('put')
                        @else
                            @method('post')
                        @endif

                        <h2 class="mb-4">{{ __('Create New Shop') }}</h2>

                        <div class="mb-4">
                            <x-label for="label">{{ __('Label*') }}</x-label>
                            <x-input id="label" name="label" class=" w-full" :value="old('label', $shop->label ?? '')" required />
                            @error('label')<x-error>{{ $message }}</x-error>@enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="description">{{ __('Description*') }}</x-label>
                            <x-input id="description" name="description" class=" w-full" :value="old('description', $shop->description ?? '')" required />
                            @error('description')<x-error>{{ $message }}</x-error>@enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="object_id">{{ __('Object ID') }}</x-label>
                            <x-input id="object_id" name="object_id" class=" w-full" :value="old('object_id', $shop->object_id ?? '')"/>
                        </div>

                        <div class="mb-4">
                            <x-label for="source_id">{{ __('Source ID') }}</x-label>
                            <x-input id="source_id" name="source_id" class=" w-full" :value="old('source_id', $shop->source_id ?? '')"/>
                        </div>


                        <h2 class="mb-4">{{ __('Contact Information') }}</h2>

                        <div class="mb-4">
                            <x-label>{{ __('Website URL') }}</x-label>
                            <x-input id="website" name="website" class=" w-full" :value="old('website', $shop->website ?? '')"/>
                        </div>

                        <div class="mb-4">
                            <x-label for="email">{{ __('Email*') }}</x-label>
                            <x-input id="email" name="email" class=" w-full" :value="old('email', $shop->email ?? '')" required />
                            @error('phone')<x-error>{{ $message }}</x-error>@enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="phone">{{ __('Phone') }}</x-label>
                            <x-input id="phone" name="phone" class=" w-full" :value="old('phone', $shop->phone ?? '')"/>
                        </div>


                        <h2 class="mb-4">{{ __('Address') }}</h2>

                        <div class="mb-4 flex gap-1">
                            <div class="w-3/4">
                                <x-label for="street">{{ __('Street') }}</x-label>
                                <x-input id="street" name="street" class=" w-full" :value="old('street', $shop->street ?? '')" />
                            </div>
                            <div class="w-1/4">
                                <x-label for="number">{{ __('Number') }}</x-label>
                                <x-input id="number" name="number" class=" w-full" :value="old('number', $shop->number ?? '')" />
                            </div>
                        </div>

                        <div class="mb-4 flex gap-1">
                            <div class="w-1/4">
                                <x-label for="zip">{{ __('Zip') }}</x-label>
                                <x-input id="zip" name="zip" class=" w-full" :value="old('zip', $shop->zip ?? '')" />
                            </div>
                            <div class="w-3/4">
                                <x-label for="city">{{ __('City') }}</x-label>
                                <x-input id="city" name="city" class=" w-full" :value="old('city', $shop->city ?? '')" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-label for="country">{{ __('Country') }}</x-label>
                            <x-input id="country" name="country" class=" w-full" :value="old('country', $shop->country ?? '')" />
                        </div>

                        <div class="flex flex-row-reverse">
                            <x-button type="submit">{{ __('submit') }}</x-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

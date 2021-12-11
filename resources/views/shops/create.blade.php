<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shops Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('shops.store') }}" method="POST">
                        @csrf
                        <h2 class="mb-4">{{ __('Create New Shop') }}</h2>
                        <div class="mb-4">
                            <x-label for="label">{{ __('Label') }}</x-label>
                            <x-input id="label" name="label" class="border w-full" :value="old('label')" />
                        </div>
                        <div class="mb-4">
                            <x-label for="description">{{ __('Description') }}</x-label>
                            <x-input id="description" name="description" class="border w-full" :value="old('description')" />
                        </div>
                        <h2></h2>
                        <div class="mb-4">
                            <x-label for="object_id">{{ __('Object ID') }}</x-label>
                            <x-input id="object_id" name="object_id" class="border w-full" :value="old('object_id')" />
                        </div>
                        <div class="mb-4">
                            <x-label for="source_id">{{ __('Source ID') }}</x-label>
                            <x-input id="source_id" name="source_id" class="border w-full" :value="old('source_id')" />
                        </div>
                        <h2 class="mb-4">{{ __('Contact Information') }}</h2>
                        <div class="mb-4">
                            <x-label>{{ __('Website URL') }}</x-label>
                            <x-input id="website" name="website" class="border w-full" :value="old('website')" />
                        </div>
                        <div class="mb-4">
                            <x-label for="email">{{ __('Email') }}</x-label>
                            <x-input id="email" name="email" class="border w-full" :value="old('email')" />
                        </div>
                        <div class="mb-4">
                            <x-label for="phone">{{ __('Phone') }}</x-label>
                            <x-input id="phone" name="phone" class="border w-full" :value="old('phone')" />
                        </div>
                        <h2 class="mb-4">{{ __('Address') }}</h2>
                        <div class="mb-4 flex gap-1">
                            <div class="w-3/4">
                                <x-label for="street">{{ __('Street') }}</x-label>
                                <x-input id="street" name="street" class="border w-full" :value="old('street')" />
                            </div>
                            <div class="w-1/4">
                                <x-label for="number">{{ __('Number') }}</x-label>
                                <x-input id="number" name="number" class="border w-full" :value="old('number')" />
                            </div>
                        </div>
                        <div class="mb-4 flex gap-1">
                            <div class="w-1/4">
                                <x-label for="zip">{{ __('Zip') }}</x-label>
                                <x-input id="zip" name="zip" class="border w-full" :value="old('zip')" />
                            </div>
                            <div class="w-3/4">
                                <x-label for="city">{{ __('City') }}</x-label>
                                <x-input id="city" name="city" class="border w-full" :value="old('city')"/>
                            </div>
                        </div>
                        <div class="mb-4">
                            <x-label for="country">{{ __('Country') }}</x-label>
                            <x-input id="country" name="country" class="border w-full" :value="old('country')"/>
                        </div>
                        <div class="flex flex-row-reverse">
                            <x-button type="submit">Submit</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

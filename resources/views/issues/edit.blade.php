<x-app-layout>

    <x-slot name="header">
        <div class="flex">
            <x-utils.link href="{{ route('issues.index') }}" class="mr-4"><</x-utils.link>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $issue->id }}
            </h2>
        </div>
    </x-slot>

    <x-utils.container class="py-12">
        <form action="{{ route('issues.update', $issue->id) }}" method="POST">

            @csrf
            @method('put')

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
                                    <x-forms.label for="id">{{ __('ID') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="id" id="id" value="{{ old('id', $issue->id) }}" required disabled/>
                                    </x-forms.input-group>
                                    @error('id')<span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-span-3">
                                <x-forms.label for="shop">{{ __('Shop') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="shop" id="shop" value="{{ old('shop', $issue->shop->label) }}" required disabled/>
                                    </x-forms.input-group>
                                    @error('shop')<span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-span-3">
                                <x-forms.label for="category">{{ __('Category') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="category" id="category" value="{{ old('category', $issue->issue_category->label) }}" required disabled/>
                                    </x-forms.input-group>
                                    @error('category')<span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-span-3">
                                <x-forms.label for="description">{{ __('Description') }}</x-forms.label>
                                <x-forms.input-group>
                                    <x-forms.text-area type="text" name="description" id="description">{{ old('description', $issue->description) }}</x-forms.text-area>
                                </x-forms.input-group>
                                @error('description')<span class="text-red-500">{{ $message }}</span>@enderror
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

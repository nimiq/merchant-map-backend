<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center">
            <x-utils.link href="{{ route('candidates.index') }}" class="mr-4 text-purple-600 font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z" clip-rule="evenodd" />
                </svg>
            </x-utils.link>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($candidate) ? $candidate->google_place_id : __('Create candidate') }}
            </h2>
        </div>
        <p>
            This table is suppose to be filled by the user. It is a list of shops that are not yet in the database.
        </p>
    </x-slot>

    <x-utils.container class="py-12 max-w-7xl px-4 mx-auto">
        <form action="{{ isset($candidate) ? route('candidates.update', $candidate->google_place_id) : route('candidates.store')}}" method="POST">

            @csrf
            @if(isset($candidate))
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
                                    <x-forms.label for="google_place_id">{{ __('Google Place ID*') }}</x-forms.label>
                                    <x-forms.input-group>
                                        <x-forms.input type="text" name="google_place_id" id="google_place_id" value="{{ old('google_place_id', $candidate->google_place_id ?? '') }}" required />
                                    </x-forms.input-group>
                                    @error('google_place_id')<span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-span-3">
                                <x-forms.label for="currencies">{{ __('Currencies') }}</x-forms.label>
                                <x-forms.input-group>
                                    <x-forms.input type="text" name="currencies" id="currencies" value="{{ old('currencies', $candidate->currencies ?? '') }}" required disabled/>
                                </x-forms.input-group>
                                @error('category')<span class="text-red-500">{{ $message }}</span>@enderror
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

<x-app-layout>

    <x-slot name="header">
        <div class="flex">
            <x-utils.link href="{{ route('shops.index') }}" class="mr-4"><</x-utils.link>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Import shops via CSV') }}
            </h2>
        </div>
    </x-slot>

    <x-utils.container class="py-12">
        <form action="{{ route('shops.importCsv') }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('post')

            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Import file') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <x-forms.label for="csv_file_import">{{ __('CSV File') }} <b>*Note, the importer assumes the first row is a header thus will be skipped.</b></x-forms.label>
                                    <br>
                                    <x-forms.input-group>
                                        <x-forms.input type="file" name="csv_file_import" id="csv_file_import" accept=".csv" />
                                    </x-forms.input-group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end my-8">
                <x-forms.button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white">{{ __('Import') }}</x-button>
            </div>

        </form>

    </x-utils.container>
</x-app-layout>
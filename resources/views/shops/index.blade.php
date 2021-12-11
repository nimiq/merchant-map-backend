<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shops') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="pb-4 flex justify-end">
                <a class="text-indigo-600 hover:text-indigo-900" href="{{ route('shops.create') }}">{{ __('Add Shop') }}</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200 overflow-x-scroll">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>

                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('ID') }}
                                </th>

                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Label') }}
                                </th>

                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Object ID') }}
                                </th>

                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Source ID') }}
                                </th>

                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Show</span>
                                </th>

                            </tr>

                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @foreach($shops as $shop)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $shop->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $shop->label }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $shop->object_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $shop->source_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('shops.show', $shop->id) }}" class="text-indigo-600 hover:text-indigo-900">Show</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

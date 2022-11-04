<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Shops') }}
            </h2>

            <div class="self-end">
                <x-utils.link-button href="{{ route('shops.create') }}">{{ __('New Shop') }}</x-utils.link-button> | 
                <x-utils.link-button href="/shops/import/csv">{{ __('Import via CSV') }}</x-utils.link-button>
            </div>

        </div>
    </x-slot>

    <x-utils.container class="py-12">

        <x-card.card>

            <x-table.table>

                <x-slot name="tableHead">

                    <x-table.header>{{ __('ID') }}</x-table.header>
                    <x-table.header>{{ __('Label') }}</x-table.header>
                    <x-table.header>{{ __('Object ID') }}</x-table.header>
                    <x-table.header>{{ __('Source ID') }}</x-table.header>
                    <x-table.header>{{ __('Issues') }}</x-table.header>
                    <x-table.header><span class="sr-only">Show</span></x-table.header>

                </x-slot>

                <x-slot name="tableBody">

                    @foreach($shops as $shop)

                        <tr>
                            <x-table.data>{{ $shop->id }}</x-table.data>
                            <x-table.data>{{ $shop->label }}</x-table.data>
                            <x-table.data>{{ $shop->object_id }}</x-table.data>
                            <x-table.data>{{ $shop->source_id }}</x-table.data>
                            <x-table.data>
                                <span class="text-red-700 text-bold">
                                    {{ $shop->issues->where('resolved', false)->count() }}
                                </span>
                                / 
                                <span class="text-green-700 text-bold">
                                    {{ $shop->issues->where('resolved', true)->count() }}
                                </span>
                            </x-table.data>
                            <x-table.data class="text-right text-sm font-medium">
                                <x-utils.link href="{{ route('shops.show', $shop->id) }}">Show</x-utils.link>
                                <form action="{{ route('shops.destroy', [ $shop->id ]) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('delete')
                                    <button class="text-red-500">{{ __('Delete') }}</button>
                                </form>
                            </x-table.data>
                        </tr>

                    @endforeach

                </x-slot>

            </x-table.table>

        </x-card.card>

    </x-utils.container>
</x-app-layout>

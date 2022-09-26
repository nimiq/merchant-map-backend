<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Issues') }}
            </h2>
        </div>
    </x-slot>

    <x-utils.container class="py-12">

        <x-card.card>

            <x-table.table>

                <x-slot name="tableHead">

                    <x-table.header>{{ __('ID') }}</x-table.header>
                    <x-table.header>{{ __('Shop') }}</x-table.header>
                    <x-table.header>{{ __('Category') }}</x-table.header>
                    <x-table.header>{{ __('Description') }}</x-table.header>
                    <x-table.header><span class="sr-only">Show</span></x-table.header>

                </x-slot>

                <x-slot name="tableBody">

                    @foreach($issues as $issue)

                        <tr>
                            <x-table.data>{{ $issue->id }}</x-table.data>
                            <x-table.data>{{ $issue->shop->label }}</x-table.data>
                            <x-table.data>{{ $issue->issue_category->label }}</x-table.data>
                            <x-table.data>{{ $issue->description }}</x-table.data>
                            <x-table.data class="text-right text-sm font-medium">
                                <x-utils.link href="{{ route('issues.show', $issue->id) }}">Show</x-utils.link>
                                <form action="{{ route('issues.destroy', [ $issue->id ]) }}" method="POST" class="inline-block">
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

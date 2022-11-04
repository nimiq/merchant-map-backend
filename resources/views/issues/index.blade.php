<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Issues') }}
            </h2>
        </div>
        <p>
            These are all the issues that have been reported by users and not yet resolved.
            <br>
            <details class="pl-2">
                <summary>Actions</summary>
                <ul class="list-disc ml-8">
                    <li>
                        <b>Resolve</b>:
                        It will mark the issue as resolved. Issues that are resolved will not be shown in the list.
                    </li>
                    <li><b>Details</b>: Show the details of the issue</li>
                    <li><b>See shop</b>: Show the details of the shop</li>
                    <li><b>Delete</b>: It will remove the issue from the database. This action is not reversible.</li>
                </ul>
            </details>
        </p>
    </x-slot>

    <x-utils.container class="py-12 max-w-7xl px-4">

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
                            <x-table.data class="text-right text-sm font-medium space-x-4">
                                @if (!$issue->resolved)
                                <form action="{{ route('issues.resolve', [ $issue ]) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('post')
                                    <button class="text-indigo-600">{{ __('Resolve') }}</button>
                                    <!-- TODO Show error state if somethings goes kaput -->
                                </form>
                                @endif
                                <x-utils.link href="{{ route('issues.show', $issue->id) }}">Details</x-utils.link>
                                <x-utils.link href="{{ route('shops.show', $issue->shop_id) }}">See shop</x-utils.link>
                                <form action="{{ route('issues.destroy', [ $issue->id ]) }}"
                                        method="POST" class="inline-block">
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

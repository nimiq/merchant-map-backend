<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Candidates') }}
            </h2>

            <div class="self-end">
                <x-utils.link-button href="{{ route('candidates.create') }}">{{ __('New candidate') }}</x-utils.link-button> 
            </div>

        </div>
        
        <p>
            These are all the entries that have been submitted by users in the UI.
            <br>
            <details class="pl-2">
                <summary>Actions</summary>
                <ul class="list-disc ml-8">
                    <li><b>Process</b>: It will fetch all the information from GMaps and will publish the location automatically</li>
                    <li><b>GMaps</b>: Opens in GMaps</li>
                    <li><b>Reject</b>: It will remove the item from the database. This action is not reversible.</li>
                </ul>
            </details>
        </p>
    </x-slot>

    <x-utils.container class="py-12 px-4 max-w-7xl">

        <x-card.card>

            <x-table.table>

                <x-slot name="tableHead">

                    <x-table.header class="text-right">{{ __('Created at') }}</x-table.header>
                    <x-table.header class="text-right">{{ __('Processed') }}</x-table.header>
                    <x-table.header class="text-right">{{ __('Google Place ID') }}</x-table.header>
                    <x-table.header>{{ __('Currencies') }}</x-table.header>
                    <x-table.header><span class="sr-only">Show</span></x-table.header>

                </x-slot>

                <x-slot name="tableBody">

                    @foreach($candidates as $candidate)

                        <tr>
                            <x-table.data class="text-right">{{ $candidate->created_at->format('d/m/y H:i') }}</x-table.data>
                            <x-table.data class="text-right">{{ $candidate->processed ? '✅' : '❌'}}</x-table.data>
                            <x-table.data class="text-right">{{ $candidate->google_place_id }}</x-table.data>
                            <x-table.data>
                                @if ($candidate->currencies->count() === 0)
                                    None
                                @else
                                    {{ $candidate->currencies->pluck('name')->join(', ') }}
                                @endif
                            </x-table.data>
                            <x-table.data class="text-right text-sm font-medium space-x-4">
                                <x-utils.link href="{{ route('candidates.process', [ $candidate->id ]) }}">
                                    Process
                                </x-utils.link>
                                <x-utils.link target="_blank" href="{{ 'https://goo.gl/maps/' . $candidate->google_place_id }}">
                                    GMaps
                                </x-utils.link>
                                <form action="{{ route('candidates.destroy', [ $candidate->id ]) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('delete')
                                    <button class="text-red-500">{{ __('Reject') }}</button>
                                </form>
                            </x-table.data>
                        </tr>

                    @endforeach

                </x-slot>

            </x-table.table>

        </x-card.card>

    </x-utils.container>
</x-app-layout>

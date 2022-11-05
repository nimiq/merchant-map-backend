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

         <p>
            These are all the shops shown in the crypto map.
            <br>
            <details class="pl-2">
                <summary>Actions</summary>
                <ul class="list-disc ml-8">
                    <li><b>See in app</b>: Opens the location in the map</li>
                    <li><b>Details</b>: Opens details of the shop. You might change them.</li>
                    <li><b>Delete</b>: It will remove the item from the database. This action is not reversible.</li>
                </ul>
            </details>
        </p>
    </x-slot>

    <x-utils.container class="py-12 px-4">

        <x-card.card style="overflow: initial">

            <x-table.table>

                <x-slot name="tableHead">

                    <x-table.header>{{ __('ID') }}</x-table.header>
                    <x-table.header>{{ __('Label') }}</x-table.header>
                    <x-table.header>{{ __('Object ID') }}</x-table.header>
                    <x-table.header>{{ __('Source ID') }}</x-table.header>
                    <x-table.header>{{ __('Status') }}</x-table.header>
                    <x-table.header>{{ __('Issues') }}</x-table.header>
                    <x-table.header>{{ __('Currencies') }}</x-table.header>
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
                                <div class="hidden sm:flex sm:items-center sm:ml-6">
                                    <x-dropdown align="right" width="32">
                                        <x-slot name="trigger">
                                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                                <div>
                                                    @if ($shop->isApproved())
                                                        <p title="Approved">✅</p>
                                                    @elseif ($shop->isPending())
                                                        <span title="Pending">⏳</span>
                                                    @elseif ($shop->isRejected())
                                                        <span title="Hide">❌</span>
                                                    @elseif ($shop->isPostponed())
                                                        <span title="Postponed">⏩</span>
                                                    @endif
                                                </div>

                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <form action="{{ route('shop.status', [ $shop, 'approve' ]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('post')
                                                
                                                <x-dropdown-link
                                                    class="cursor-pointer"
                                                    onclick="event.preventDefault();this.closest('form').submit();">
                                                    ✅ {{ __('Approve') }}
                                                </x-dropdown-link>
                                            </form>

                                            <form action="{{ route('shop.status', [ $shop, 'reject' ]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('post')
                                                
                                                <x-dropdown-link
                                                    class="cursor-pointer"
                                                    onclick="event.preventDefault();this.closest('form').submit();">
                                                    ❌ {{ __('Reject') }}
                                                </x-dropdown-link>
                                            </form>

                                            <form action="{{ route('shop.status', [ $shop, 'postpone' ]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('post')
                                                
                                                <x-dropdown-link
                                                    class="cursor-pointer"
                                                    onclick="event.preventDefault();this.closest('form').submit();">
                                                    ⏩ {{ __('Postponed') }}
                                                </x-dropdown-link>
                                            </form>

                                        </x-slot>
                                    </x-dropdown>
                                </div>

                                
                            </x-table.data>
                            
                            <x-table.data>
                                <span class="text-red-700 text-bold">
                                    {{ $shop->issues->where('resolved', false)->count() }}
                                </span>
                                / 
                                <span class="text-green-700 text-bold">
                                    {{ $shop->issues->where('resolved', true)->count() }}
                                </span>
                            </x-table.data>


                            <x-table.data>
                                @if ($shop->currencies->count() === 0)
                                    None
                                @else
                                    {{ $shop->currencies->pluck('symbol')->join(', ') }}
                                @endif
                            </x-table.data>
                             
                            <x-table.data class="text-right text-sm font-medium space-x-4">
                                <x-utils.link target="_blank" href="https://nimiq-map.netlify.app/location/{{$shop->source_id}}">See in app</x-utils.link>
                                <x-utils.link href="{{ route('shops.show', $shop->id) }}">Details</x-utils.link>

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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shops Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('shops.store') }}" method="POST">
                        @csrf
                        <div class="flex">
                            <label  class="w-24">Label </label>
                            <input name="label" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">description</label>
                            <input name="description" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">object_id</label>
                            <input name="object_id" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">source_id</label>
                            <input name="source_id" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">website</label>
                            <input name="website" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">email</label>
                            <input name="email" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">phone</label>
                            <input name="phone" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">street</label>
                            <input name="street" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">number</label>
                            <input name="number" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">zip</label>
                            <input name="zip" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">city</label>
                            <input name="city" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">country</label>
                            <input name="country" class="border">
                        </div>
                        <div class="flex">
                            <label class="w-24">digital_goods</label>
                            <input type="checkbox" name="digital_goods" class="border">
                        </div>
                        <div class="flex">
                            <button type="submit" class="border border-blue-400">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

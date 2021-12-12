<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}>
    {{ $slot }}
</button>


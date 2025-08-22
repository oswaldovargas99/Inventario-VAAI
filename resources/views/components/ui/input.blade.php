@props(['type' => 'text'])
<input type="{{ $type }}"
    {{ $attributes->class([
        'w-full px-3 py-2 rounded border',
        'bg-white text-gray-900 placeholder-gray-500 border-gray-300',
        'dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-400 dark:border-gray-700',
        'focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500'
    ]) }}>

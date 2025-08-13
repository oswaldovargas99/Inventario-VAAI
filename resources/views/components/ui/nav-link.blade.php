@props(['active' => false, 'href' => '#'])

@php
$classes = $active
    ? 'flex items-center px-3 py-2 rounded-xl text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white'
    : 'flex items-center px-3 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700';
@endphp

<a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
    {{ $slot }}
</a>

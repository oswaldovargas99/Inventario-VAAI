@props(['active' => false])

@php
$classes = 'flex items-center px-3 py-2 rounded-xl transition '.
    ($active
        ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300'
        : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700');
@endphp

<a {{ $attributes->merge([
        'class' => $classes,
        'wire:navigate' => true,          // ← SPA
        'wire:navigate.hover' => true,    // ← prefetch al pasar el mouse
    ]) }}>
  {{ $slot }}
</a>


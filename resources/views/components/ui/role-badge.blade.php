@props(['role'])

@php
$map = [
    'Admin' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200',
    'Aprobador' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200',
    'Secretario' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200',
    'Usuario' => 'bg-gray-100 text-gray-800 dark:bg-gray-700/60 dark:text-gray-200',
];
$cls = $map[$role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700/60 dark:text-gray-200';
@endphp
<span class="px-2 py-0.5 rounded-full text-xs {{ $cls }}">{{ $role }}</span>

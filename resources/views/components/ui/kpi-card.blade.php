@props(['label','value' => '—','hint' => null])

<div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $label }}</div>
    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $value }}</div>
    @if($hint)
        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</div>
    @endif
</div>

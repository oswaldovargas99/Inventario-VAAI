@props(['title', 'subtitle' => null])

<div class="mb-4">
    <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</h1>
    @if($subtitle)
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $subtitle }}</p>
    @endif
</div>

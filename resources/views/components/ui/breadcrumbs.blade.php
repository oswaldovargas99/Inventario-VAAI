@props(['items' => []])
<nav class="ml-4 text-sm text-gray-600 dark:text-gray-300" aria-label="Breadcrumb">
    <ol class="inline-flex items-center gap-2">
        @foreach($items as $i => $item)
            @if($i > 0)
                <span class="opacity-60">/</span>
            @endif
            @if(isset($item['url']))
                <a href="{{ $item['url'] }}" class="hover:underline">{{ $item['label'] }}</a>
            @else
                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $item['label'] }}</span>
            @endif
        @endforeach
    </ol>
</nav>

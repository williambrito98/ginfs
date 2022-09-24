@props(['type', 'url'])
@if ($type == 'link')
    <a href="{{ $url }}" {{ $attributes->merge(['class' => 'my-4  px-8 py-2 rounded']) }}>
        {{ $slot }}
    </a>
@else
    @if ($type == 'icon')
        <button {{ $attributes->merge(['class' => 'px-8 py-2 rounded']) }}>
            {{ $slot }}
        </button>
    @else

        <button {{ $attributes->merge(['class' => 'bg-btn-yellow my-4  px-8 py-2 rounded hover:bg-yellow-200']) }}>
            {{ $slot }}
        </button>
    @endif
@endif

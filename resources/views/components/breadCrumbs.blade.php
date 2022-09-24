@props(['breadCrumbs'])

<div class="flex flex-end items-center border-bottom-breadCrumbs">
    @if (isset($breadCrumbs))
        @foreach ($breadCrumbs as $bread)
            @if ($bread['url'])
                <div class="text-xl mb-1"> 
                    <a href="{{ $bread['url'] }}">{{ $bread['title'] }}</a></span>
                </div>
                <div class="mx-3">
                    <x-svg.chevronRight />
                </div>
            @else
                <div class="font-bold">
                    <span>{{ $bread['title'] }}</span>
                </div>
            @endif
        @endforeach
    @endif
</div>

@props(['tabs'])

<section class="container mx:auto">
    <div class="rounded-xl bg-table">
        @foreach ($tabs as $tab)
            @if ($tab['url'])
                <div class="flex-basis-50 m-2 {{ $tab['active'] }} bg-FCD34D">
                    <a href="{{ $tab['url'] }}" class="text-5C5C5C">{{ $tab['title'] }}</a>
                </div>
            @else
                <div class="bg-gray-400 bg-btn-dropdown-client py-2 rounded-t-md">
                    <h3 class="text-center color-header-table">{{ $tab['title'] }}</h3>
                </div>
            @endif
        @endforeach
        <div class="max-w-screen-md mx-auto py-2">
            {{ $slot ?? '' }}
        </div>
    </div>

</section>

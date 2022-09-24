@props(['value'])

<label {{ $attributes->merge(['class' => 'text-5C5C5C label-after inline-block']) }}>
    {{ $value ?? $slot }}
</label>

@props(['name', 'error'])

@error($name)
    @php
    $attributes->setAttributes(array_values((array) $attributes->merge(['class' => 'border-2 border-error']))[0]);
    @endphp
@enderror
<input {{ $attributes->merge(['class' => 'border-input border-white rounded focus:border-yellow-400 focus:ring-yellow-200']) }} name={{ $name }} />

@error($name)
    <p class='text-red-500'>{{ $message }}</p>
@enderror

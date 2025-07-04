@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-dark']) }}>
    {{ $value ?? $slot }}
</label>

@props(['text' => null, 'option' => [], 'icon' => null])
<button {{ $attributes->merge($option) }}>
    <i class="{{ $icon }}"></i>
    {{ $text }}
</button>

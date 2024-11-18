@props(['route'])

@php
$isActive = false;

if (isset($route)) {
    if (is_int(strpos(url()->current(), $route))) {
        $isActive = true;
    }
}

$classes = $isActive ? 'active' : '';
@endphp

<li {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</li>

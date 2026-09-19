@props(['stock' => 0])

@php
    $status = match(true) {
        $stock <= 0 => 'Habis',
        $stock < 10 => 'Menipis',
        default => 'Aman',
    };

    $colorClasses = match($status) {
        'Habis' => 'bg-red-100 text-red-700',
        'Menipis' => 'bg-yellow-100 text-yellow-700',
        'Aman' => 'bg-green-100 text-green-700',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-block px-3 py-1 rounded-full text-xs font-semibold $colorClasses"]) }}>
    {{ $status }}
</span>
@props(['field', 'label'])
@php
    $current = request('sort') === $field;
    $dir = ($current && request('direction') === 'asc') ? 'desc' : 'asc';
    $url = request()->fullUrlWithQuery(['sort' => $field, 'direction' => $dir, 'page' => 1]);
@endphp
<th {{ $attributes->merge(['class' => 'px-6 py-4 font-semibold']) }}>
    <a href="{{ $url }}" class="inline-flex items-center gap-1 hover:text-indigo-600 transition">
        {{ $label }}
        @if($current)
            <span class="text-indigo-500 text-xs">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
        @endif
    </a>
</th>

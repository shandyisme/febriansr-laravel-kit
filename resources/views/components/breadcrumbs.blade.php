@props([
    'items' => [],
])

<nav {{ $attributes->merge(['class' => 'flex items-center gap-1.5 text-sm text-slate-500']) }} aria-label="Breadcrumb">
    @foreach ($items as $item)
        @php $last = $loop->last; @endphp

        @if (! $last && ! empty($item['href']))
            <a href="{{ $item['href'] }}" class="transition hover:text-slate-700">{{ $item['label'] }}</a>
        @else
            <span class="font-medium text-slate-700" @if ($last) aria-current="page" @endif>{{ $item['label'] }}</span>
        @endif

        @unless ($last)
            <span class="text-slate-300">/</span>
        @endunless
    @endforeach
</nav>

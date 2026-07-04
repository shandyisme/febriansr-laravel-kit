@props([
    'paginator' => null,
])

@if ($paginator && $paginator->hasPages())
    @php
        $onEachSide = $paginator->onEachSide ?? 3;
        $range = $paginator->getUrlRange(
            max($paginator->currentPage() - $onEachSide, 1),
            min($paginator->currentPage() + $onEachSide, $paginator->lastPage())
        );
    @endphp

    <nav {{ $attributes->merge(['class' => 'flex items-center justify-between gap-2']) }} aria-label="Navigasi halaman">
        {{-- Prev --}}
        @if ($paginator->previousPageUrl())
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 ring-1 ring-inset ring-slate-300 transition hover:bg-slate-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                <span>Sebelumnya</span>
            </a>
        @else
            <span class="inline-flex cursor-not-allowed items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-300 ring-1 ring-inset ring-slate-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                <span>Sebelumnya</span>
            </span>
        @endif

        {{-- Page numbers --}}
        <div class="hidden items-center gap-1 sm:flex">
            @foreach ($range as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-brand-600 px-3 text-sm font-semibold text-white">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg px-3 text-sm font-medium text-slate-600 transition hover:bg-slate-100">{{ $page }}</a>
                @endif
            @endforeach
        </div>

        {{-- Next --}}
        @if ($paginator->nextPageUrl())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 ring-1 ring-inset ring-slate-300 transition hover:bg-slate-50">
                <span>Berikutnya</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </a>
        @else
            <span class="inline-flex cursor-not-allowed items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-300 ring-1 ring-inset ring-slate-200">
                <span>Berikutnya</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </span>
        @endif
    </nav>
@endif

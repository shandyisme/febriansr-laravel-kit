@props(['title' => null])

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ? $title.' — '.brand('app_name') : brand('app_name') }}</title>

@if (brand('favicon'))
    <link rel="icon" href="{{ brand('favicon') }}">
@endif

{{-- App CSS first (theme defaults), then brand overrides so config wins. --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
<x-brand-styles />

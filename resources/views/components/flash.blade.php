@if (session('success'))
    <div class="mb-4">
        <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
    </div>
@endif

@if (session('error'))
    <div class="mb-4">
        <x-alert variant="error" dismissible>{{ session('error') }}</x-alert>
    </div>
@endif

@if (session('warning'))
    <div class="mb-4">
        <x-alert variant="warning" dismissible>{{ session('warning') }}</x-alert>
    </div>
@endif

@if (session('status'))
    <div class="mb-4">
        <x-alert variant="info" dismissible>{{ session('status') }}</x-alert>
    </div>
@endif

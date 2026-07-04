<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('settings.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'app_name' => ['required', 'string', 'max:100'],
            'timezone' => ['required', 'timezone'],
            'locale' => ['required', 'in:id,en'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'currency' => ['required', 'in:IDR,USD'],
            'date_format' => ['required', 'string', 'max:20'],
        ]);

        foreach ($data as $key => $value) {
            setting_set($key, $value, 'string');
        }

        setting_set('wa_notifications', $request->boolean('wa_notifications'), 'bool');

        app(ActivityLogger::class)->log('settings.updated', 'Memperbarui pengaturan aplikasi');

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}

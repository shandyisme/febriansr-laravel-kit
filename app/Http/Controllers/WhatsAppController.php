<?php

namespace App\Http\Controllers;

use App\Models\WhatsappMessageLog;
use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhatsAppController extends Controller
{
    public function index(Request $request): View
    {
        $logs = WhatsappMessageLog::latest()->paginate(15);

        return view('whatsapp.index', compact('logs'));
    }

    public function send(Request $request, WhatsAppService $wa): RedirectResponse
    {
        $data = $request->validate([
            'to' => ['required', 'string'],
            'type' => ['required', 'in:message,otp,notification,reminder'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($data['type'] === 'otp') {
            $wa->sendOtp($data['to'], (string) random_int(100000, 999999));
        } else {
            $wa->send($data['to'], $request->input('message') ?: 'Pesan uji dari Febrian Kit.', $data['type']);
        }

        return back()->with('success', 'Pesan diantrikan untuk dikirim.');
    }
}

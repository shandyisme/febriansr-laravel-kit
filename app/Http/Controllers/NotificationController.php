<?php

namespace App\Http\Controllers;

use App\Notifications\DemoNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = auth()->user()->notifications()->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function read(string $id): RedirectResponse
    {
        $n = auth()->user()->notifications()->findOrFail($id);
        $n->markAsRead();

        return back();
    }

    public function readAll(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai dibaca.');
    }

    public function sendDemo(): RedirectResponse
    {
        auth()->user()->notify(new DemoNotification(
            'Notifikasi Uji',
            'Ini contoh notifikasi in-app dari Febrian Kit.',
            route('dashboard'),
        ));

        return back()->with('success', 'Notifikasi uji dikirim.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $notifications = $user->notifications()->latest()->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function read(string $id)
    {
        $user = auth()->user();

        /** @var DatabaseNotification|null $notification */
        $notification = $user->notifications()->where('id', $id)->firstOrFail();

        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        $url = $notification->data['url'] ?? route('admin.dashboard');
        return redirect($url);
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}

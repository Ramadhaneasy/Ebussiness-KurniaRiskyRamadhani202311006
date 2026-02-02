<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Order',
            'message' => "Order #{$this->order->order_number} created by {$this->order->user->name}",
            // arahkan ke detail order user (atau halaman admin order kalau nanti kamu buat)
            'url' => route('admin.dashboard'),
            'icon' => 'shopping', // opsional buat styling
        ];
    }
}

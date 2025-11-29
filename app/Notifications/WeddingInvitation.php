<?php

namespace App\Notifications;

use App\Models\Wedding;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WeddingInvitation extends Notification
{
    use Queueable;

    protected $wedding;
    protected $senderName;

    public function __construct(Wedding $wedding, string $senderName)
    {
        $this->wedding = $wedding;
        $this->senderName = $senderName;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'invitation',
            'title'   => 'Undangan Pernikahan 💍',
            'message' => "{$this->senderName} mengundangmu bergabung ke project: {$this->wedding->title}",
            'url'     => route('wedding.accept-invitation', $this->wedding->invitation_token),
        ];
    }
}

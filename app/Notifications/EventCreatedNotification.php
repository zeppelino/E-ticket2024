<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification
{
    use Queueable;

    private $eventName;
    private $eventId;

    /**
     * Create a new notification instance.
     */
    public function __construct($eventName, $eventId)
    {
        $this->eventName = $eventName;
        $this->eventId = $eventId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'title' => 'Nuevo Evento Creado',
            'message' => "Evento creado: {$this->eventName}.",
            'event_id' => $this->eventId,
            'event_name'=> $this->eventName,
            'url' => '/eventos',
            'type' => 'event_created',     
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;



use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewContactMessage extends Notification
{
    public $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Contact Message Received')
            ->greeting('Hello Admin,')
            ->line('You have received a new message from: ' . $this->contact->name)
            ->line('Email: ' . $this->contact->email)
            ->line('Message:')
            ->line($this->contact->message)
            ->line('Check the admin panel to reply.');
    }
}

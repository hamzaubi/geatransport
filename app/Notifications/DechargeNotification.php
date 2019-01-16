<?php

namespace App\Notifications;

use App\Decharge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DechargeNotification extends Notification //implements ShouldQueue
{
    use Queueable;
    public $decharge;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Decharge $decharge)
    {
        $this->decharge = $decharge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Décharge document véhicule')
                    ->greeting('Bonjour '.$this->decharge->user->name)
                    ->line('Nous vous informons qu\'une décharge des documents véhicule a été enregistrer pour vous.')
                    ->line('Infos Véhicule:'.'Mat( '.$this->decharge->vehicule->matricule.')')
                    ->line('Date Restitution des documents: ' .$this->decharge->date_restitution)
                    ->salutation('Salutations');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

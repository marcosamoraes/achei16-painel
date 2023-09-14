<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSaleToAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Order $order)
    { }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nova Venda')
            ->greeting('Olá ' . $notifiable->name . ',')
            ->line("Foi realizada uma nova venda da empresa {$this->order->company->name}.")
            ->action('Acesse para ver mais', url("/orders/{$this->order->id}/edit"))
            ->line('Obrigado por usar nossa plataforma!');
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

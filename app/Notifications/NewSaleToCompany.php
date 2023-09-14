<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSaleToCompany extends Notification
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
        //Para ativar a exibição da sua empresa em nosso portal realize o aceite do contrato e pagamento do pacote assinado. %Linkcontrato
        return (new MailMessage)
            ->subject('Nova compra realizada')
            ->greeting('Olá ' . $notifiable->name . ',')
            ->line('Para ativar a exibição da sua empresa em nosso portal, realize o aceite do contrato e pagamento do pacote assinado.')
            ->action('Link do contrato', url("/venda/{$this->order->uuid}/contrato"))
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

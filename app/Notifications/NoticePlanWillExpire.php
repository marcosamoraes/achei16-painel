<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NoticePlanWillExpire extends Notification
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
//Olá %cliente seu plano expira em %datavencimento. Nao deixe sua %empresa ficar sem visualização. Renove sua assinatura conosco %linkwhatsapp

        return (new MailMessage)
            ->subject('Seu plano exirará em breve')
            ->greeting('Olá ' . $notifiable->name . ',')
            ->line("Seu plano irá expirar em {$this->order->expire_at->format('d/m/Y')}. Não deixe a sua empresa {$this->order->company->name} ficar sem visualização. Renove sua assinatura conosco:")
            ->action('Clique para renovar', "https://wa.me/+5516981938181?text=Olá, sou responsável pela empresa {$this->order->company->name}. Gostaria de renovar o meu plano!")
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

<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Notifications\NoticePlanWillExpire;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEmailNoticePlanWillExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-notice-plan-will-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check orders that will expire in 45 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('status', 'approved')->whereDate('expire_at', now()->addDays(45))->get();
        $orders->each(fn ($order) => Notification::send($order->company->client->user, new NoticePlanWillExpire($order)));
    }
}

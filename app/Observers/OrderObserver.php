<?php

namespace App\Observers;

use App\Http\Enums\UserRoleEnum;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NewSaleToAdmin;
use App\Notifications\NewSaleToCompany;
use Illuminate\Support\Facades\Notification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $this->sendNewSaleToCompany($order);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->isDirty('status') && $order->status === 'approved') {
            $this->sendNewSaleToAdmin($order);
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }

    private function sendNewSaleToCompany(Order $order): void
    {
        Notification::send($order->company->client->user, new NewSaleToCompany($order));
    }

    private function sendNewSaleToAdmin(Order $order): void
    {
        $users = User::select()->role(UserRoleEnum::Admin->value)->get();
        Notification::send($users, new NewSaleToAdmin($order));
    }
}

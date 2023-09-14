<?php

namespace App\Observers;

use App\Http\Enums\UserRoleEnum;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\NewContactToAdmin;
use App\Notifications\NewContactToCompany;
use Illuminate\Support\Facades\Notification;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     */
    public function created(Contact $contact): void
    {
        if ($contact->user_id) {
            $this->sendNewContactToCompany($contact);
        } else {
            $this->sendNewContactToAdmin();
        }
    }

    /**
     * Handle the Contact "updated" event.
     */
    public function updated(Contact $contact): void
    {
        //
    }

    /**
     * Handle the Contact "deleted" event.
     */
    public function deleted(Contact $contact): void
    {
        //
    }

    /**
     * Handle the Contact "restored" event.
     */
    public function restored(Contact $contact): void
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     */
    public function forceDeleted(Contact $contact): void
    {
        //
    }

    private function sendNewContactToCompany(Contact $contact): void
    {
        Notification::send($contact->user, new NewContactToCompany());
    }

    private function sendNewContactToAdmin(): void
    {
        $users = User::select()->role(UserRoleEnum::Admin->value)->get();
        Notification::send($users, new NewContactToAdmin());
    }
}

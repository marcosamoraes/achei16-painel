<?php

namespace App\Observers;

use App\Models\Review;
use App\Notifications\NewReviewToCompany;
use Illuminate\Support\Facades\Notification;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review): void
    {
        $this->sendNewReviewToCompany($review);
    }

    /**
     * Handle the Review "updated" event.
     */
    public function updated(Review $review): void
    {
        //
    }

    /**
     * Handle the Review "deleted" event.
     */
    public function deleted(Review $review): void
    {
        //
    }

    /**
     * Handle the Review "restored" event.
     */
    public function restored(Review $review): void
    {
        //
    }

    /**
     * Handle the Review "force deleted" event.
     */
    public function forceDeleted(Review $review): void
    {
        //
    }

    private function sendNewReviewToCompany(Review $review): void
    {
        Notification::send($review->company->client->user, new NewReviewToCompany());
    }
}

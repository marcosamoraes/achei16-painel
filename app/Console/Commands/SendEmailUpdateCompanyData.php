<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Notifications\UpdateCompanyData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEmailUpdateCompanyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-update-company-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check companies that have not updated their data for 6 months';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companies = Company::where('updated_at', '<', now()->subMonths(6))->get();
        $companies->each(function ($company) {
            $company->update(['updated_at' => now()]);
            Notification::send($company->client->user, new UpdateCompanyData($company));
        });
    }
}

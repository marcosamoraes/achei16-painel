<?php

namespace App\Http\Controllers;

use App\Http\Enums\OrderStatusEnum;
use App\Http\Enums\UserRoleEnum;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function __invoke(Request $request)
    {
        $initialDate = $request->initial_date ?? now()->subDays(30)->startOfDay()->format('Y-m-d H:i:s');
        $finalDate = $request->final_date ?? now()->endOfDay()->format('Y-m-d H:i:s');

        if (auth()->user()->role === UserRoleEnum::Admin->value) {
            return $this->getAdminDashboard($initialDate, $finalDate);
        } else if (auth()->user()->role === UserRoleEnum::Seller->value) {
            return $this->getSellerDashboard($initialDate, $finalDate);
        } else if (auth()->user()->role === UserRoleEnum::Client->value) {
            return $this->getClientDashboard($initialDate, $finalDate);
        }
    }

    private function getAdminDashboard($initialDate, $finalDate)
    {
        $countClients = Client::where('created_at', '>=', $initialDate)
            ->where('created_at', '<=', $finalDate)
            ->whereHas('user', function ($query) {
                $query->where('status', true);
            })
            ->count();

        $countCompanies = Company::where('created_at', '>=', $initialDate)
            ->where('created_at', '<=', $finalDate)
            ->where('status', true)
            ->count();

        $countSellers = Seller::where('created_at', '>=', $initialDate)
            ->where('created_at', '<=', $finalDate)
            ->whereHas('user', function ($query) {
                $query->where('status', true);
            })
            ->count();

        $sumOrdersTotal = Order::where('created_at', '>=', $initialDate)
            ->where('created_at', '<=', $finalDate)
            ->where('status', OrderStatusEnum::Approved)
            ->sum('total');

        $companiesPerCity = Company::selectRaw('count(*) as total, city')
            ->where('created_at', '>=', $initialDate)
            ->where('created_at', '<=', $finalDate)
            ->where('status', true)
            ->groupBy('city')
            ->orderBy('city', 'asc')
            ->get();

        $companiesPerCityLabels = $companiesPerCity->map(fn ($item) => "&quot;{$item->city}&quot;")->join(',');
        $companiesPerCityValues = $companiesPerCity->map(fn ($item) => $item->total)->join(',');

        return view('dashboard', compact('countClients', 'countCompanies', 'countSellers', 'sumOrdersTotal', 'companiesPerCity', 'companiesPerCityLabels', 'companiesPerCityValues'));
    }

    private function getSellerDashboard($initialDate, $finalDate)
    {
        $countCompanies = Company::where('created_at', '>=', $initialDate)
            ->where('created_at', '<=', $finalDate)
            ->where('user_id', auth()->id())
            ->where('status', true)
            ->count();

        $sumOrdersTotal = Order::where('created_at', '>=', $initialDate)
            ->where('created_at', '<=', $finalDate)
            ->where('status', OrderStatusEnum::Approved)
            ->where('user_id', auth()->id())
            ->sum('total');

        return view('dashboard', compact('countCompanies', 'sumOrdersTotal'));
    }

    private function getClientDashboard($initialDate, $finalDate)
    {
        $client = Client::where('user_id', auth()->id())->firstOrFail();
        $countVisits = $client->total_visits;
        $countContacts = Contact::where('user_id', auth()->id())->count();

        return view('dashboard', compact('countVisits', 'countContacts'));
    }
}

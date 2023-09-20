<?php

namespace App\Http\Controllers;

use App\Http\Enums\UserRoleEnum;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\Pack;
use App\Models\Seller;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::when($request->search, function ($query) use ($request) {
                $query->orWhereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->search}%");
                    $query->orWhere('email', 'like', "%{$request->search}%");
                });
                $query->orWhereHas('company', function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->search}%");
                });
                $query->orWhereHas('pack', function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->search}%");
                });
                $query->orWhere('id', $request->search);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->seller, function ($query) use ($request) {
                $query->where('user_id', $request->seller);
            })
            ->when($request->payment_method, function ($query) use ($request) {
                $query->where('payment_method', $request->payment_method);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->whereHas('company', function ($query) use ($request) {
                    $query->whereHas('categories', function ($query) use ($request) {
                        $query->where('category_id', $request->category);
                    });
                });
            })
            ->when($request->city, function ($query) use ($request) {
                $query->whereHas('company', function ($query) use ($request) {
                    $query->where('city', $request->city);
                });
            })
            ->when($request->initial_approved_at, function ($query) use ($request) {
                $query->whereDate('approved_at', '>=', $request->initial_approved_at);
            })
            ->when($request->final_approved_at, function ($query) use ($request) {
                $query->whereDate('approved_at', '<=', $request->final_approved_at);
            })
            ->when($request->initial_expire_at, function ($query) use ($request) {
                $query->whereDate('expire_at', '>=', $request->initial_expire_at);
            })
            ->when($request->final_expire_at, function ($query) use ($request) {
                $query->whereDate('expire_at', '<=', $request->final_expire_at);
            })
            ->where(function ($query) {
                if (Auth::user()->role !== UserRoleEnum::Admin->value) {
                    $query->where('user_id', Auth::id());
                }
            })
            ->latest()
            ->paginate(50);

        $sellers = Seller::all();
        $categories = Category::whereHas('companies')->where('status', true)->get();
        $cities = Company::distinct()->orderBy('city', 'asc')->pluck('city')->toArray();

        return view('orders.index', compact('orders', 'sellers', 'categories', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where(function ($query) {
            if (Auth::user()->role === UserRoleEnum::Seller->value) {
                $query->where('user_id', Auth::id());
            }
        })->get();
        $packs = Pack::all();
        return view('orders.create', compact('companies', 'packs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $validated['user_id'] = $request->user()->role === UserRoleEnum::Seller->value ? $request->user()->id : null;
            $validated['uuid'] = Str::uuid();

            Order::create($validated);

            DB::commit();

            Alert::toast('Pedido cadastrado com sucesso.', 'success');
            return Redirect::route('orders.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            Alert::toast('Falha ao cadastrar pedido.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $companies = Company::all();
        $packs = Pack::all();
        return view('orders.edit', compact('order', 'companies', 'packs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            if ($order->status === 'pending' && $validated['status'] === 'approved') {
                $validated['approved_at'] = now();
                $validated['expire_at'] = $order->getExpireAt();
            }

            if ($order->status === 'pending' && $validated['status'] === 'canceled') {
                $validated['canceled_at'] = now();
            }

            if ($order->status !== 'pending' && $validated['status'] === 'pending') {
                $validated['approved_at'] = null;
                $validated['canceled_at'] = null;
            }

            $order->update($validated);

            DB::commit();

            Alert::toast('Pedido editado com sucesso.', 'success');
            return Redirect::route('orders.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            Alert::toast('Falha ao editar pedido.', 'error');
            return back()->withInput();
        }
    }

    public function generatePaymentLink(Order $order)
    {
        $pagseguroEmail = env('PAGSEGURO_EMAIL');
        $pagseguroToken = env('PAGSEGURO_TOKEN');
        $generateCodeUrl = "https://ws.pagseguro.uol.com.br/v2/checkout?email={$pagseguroEmail}&token={$pagseguroToken}";

        try {
            $id = $order->pack->id;
            $title = $order->pack->title;
            $amount = number_format($order->value, 2, '.', '');
            $orderId = $order->id;

            $data =
                <<<XML
                    <checkout>
                        <email>{{$pagseguroEmail}}</email>
                        <token>{{$pagseguroToken}}</token>
                        <currency>BRL</currency>
                        <items>
                            <item>
                                <id>{{$id}}</id>
                                <description>{{$title}}</description>
                                <amount>{{$amount}}</amount>
                                <quantity>1</quantity>
                                <weight>0</weight>
                                <shippingCost>0.00</shippingCost>
                            </item>
                        </items>
                        <shippingAddressRequired>false</shippingAddressRequired>
                        <reference>{{$orderId}}</reference>
                    </checkout>
                XML;

            $client = new Client();

            $headers = [
                'Content-Type' => 'application/xml; charset=ISO-8859-1',
            ];
            $response = $client->post($generateCodeUrl, [
                'headers' => $headers,
                'body' => $data,
            ]);

            $xml = simplexml_load_string($response->getBody());

            if (!$xml) {
                throw new Exception("Error Processing Request", 1);
            }

            return redirect("https://pagseguro.uol.com.br/v2/checkout/payment.html?code={$xml->code}");
        } catch (RequestException $e) {
            dd($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Endpoint for Pagseguro webhook.
     */
    public function paymentWebhook(Request $request)
    {
        Log::info('Pagseguro webhook', $request->all());
    }

    public function viewContract(Order $order)
    {
        return view('orders.contract', compact('order'));
    }

    public function signContract(Request $request, Order $order)
    {
        $filePath = 'contracts/' . uniqid() . '.jpg';

        list(, $fileData) = explode(';', $request->signature);
        list(, $fileData) = explode(',', $fileData);

        // change permissions of public/contracts to 777
        $path = storage_path('app/public/' . $filePath);
        chmod(dirname($path), 0777);

        Storage::put("public/{$filePath}", base64_decode($fileData));

        $order->update([
            'contract_name' => $request->contract_name,
            'contract_cpf' => $request->contract_cpf,
            'contract_url' => $filePath,
            'contract_signed_at' => now(),
            'contract_ip' => $request->ip(),
        ]);

        Alert::toast('Contrato assinado com sucesso.', 'success');
        return Redirect::route('companies.index');
    }
}

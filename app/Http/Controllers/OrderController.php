<?php

namespace App\Http\Controllers;

use App\Http\Enums\UserRoleEnum;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\Pack;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->role === UserRoleEnum::Admin->value) {
            $orders = Order::paginate(50);
        } else {
            $orders = Order::where('user_id', Auth::id())->paginate(50);
        }
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
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

            $order = Order::create($validated);

            $paymentUrl = $this->generatePaymentLink($order);

            $order->update(['payment_code' => $paymentUrl]);

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

            if ($order->value != $validated['value']) {
                $validated['payment_code'] = $this->generatePaymentLink($order);
            }

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

    private function generatePaymentLink(Order $order)
    {
        $pagseguroEmail = env('PAGSEGURO_EMAIL');
        $pagseguroToken = env('PAGSEGURO_TOKEN');
        $generateCodeUrl = "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout?email={$pagseguroEmail}&token={$pagseguroToken}";

        $data = [
            'email' => $pagseguroEmail,
            'token' => $pagseguroToken,
            'currency' => 'BRL',
            'itemId1' => '1',
            'itemDescription1' => $order->pack->title,
            'itemAmount1' => number_format($order->value, 2, '.', ''),
            'itemQuantity1' => '1',
            'reference' => $order->id,
        ];

        $ch = curl_init($generateCodeUrl);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        if (!$response || !simplexml_load_string($response)) {
            throw new Exception("Error Processing Request", 1);
        }

        $xml = simplexml_load_string($response);
        return $xml->code;
    }

    /**
     * Endpoint for Pagseguro webhook.
     */
    public function paymentWebhook(Request $request)
    {
        Log::info('Pagseguro webhook', $request->all());
    }
}

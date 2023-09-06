<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Requests\UpdateSettingsClientRequest;
use App\Models\Client;
use App\Models\User;
use App\Notifications\ClientCreated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::paginate(50);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        try {
            $validated = $request->validated();

            $password = Str::random(8);
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($password),
            ]);

            $validated['client']['user_id'] = $user->id;

            Client::create($validated['client']);

            $user->notify(new ClientCreated($password));

            Alert::toast('Cliente cadastrado com sucesso.', 'success');
            return Redirect::route('clients.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao cadastrar cliente.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        try {
            $validated = $request->validated();

            $user = User::find($client->user_id);
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $client->update($validated['client']);
            Alert::toast('Cliente editado com sucesso.', 'success');
            return Redirect::route('clients.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao editar cliente.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        $client->user->update(['status' => 0]);
        Alert::toast('Cliente deletado com sucesso.', 'success');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function settings()
    {
        $client = Client::where('user_id', auth()->id())->first();
        return view('settings', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSettings(UpdateSettingsClientRequest $request)
    {
        $client = Client::where('user_id', auth()->id())->first();
        try {
            $validated = $request->validated();

            $client->update($validated);

            Alert::toast('Dados editados com sucesso.', 'success');
            return Redirect::route('settings');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao editar dados.', 'error');
            return back()->withInput();
        }
    }
}

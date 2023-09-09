<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSellerRequest;
use App\Http\Requests\UpdateSellerRequest;
use App\Models\Seller;
use App\Models\User;
use App\Notifications\SellerCreated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sellers = Seller::when($request->search, function ($query) use ($request) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
                $query->orWhere('email', 'like', "%{$request->search}%");
            });
            $query->orWhere('id', $request->search);
        })->latest()->paginate(50);

        return view('sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSellerRequest $request)
    {
        try {
            $validated = $request->validated();

            $password = Str::random(8);
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($password),
            ]);

            $validated['seller']['user_id'] = $user->id;

            Seller::create($validated['seller']);

            $user->assignRole('seller');

            $user->notify(new SellerCreated($password));

            Alert::toast('Vendedor cadastrado com sucesso.', 'success');
            return Redirect::route('sellers.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao cadastrar vendedor.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seller $seller)
    {
        return view('sellers.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSellerRequest $request, Seller $seller)
    {
        try {
            $validated = $request->validated();

            $user = User::find($seller->user_id);
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $seller->update($validated['seller']);
            Alert::toast('Vendedor editado com sucesso.', 'success');
            return Redirect::route('sellers.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao editar vendedor.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller)
    {
        $seller->delete();
        $seller->user->update(['status' => 0]);
        Alert::toast('Vendedor deletado com sucesso.', 'success');
        return back();
    }
}

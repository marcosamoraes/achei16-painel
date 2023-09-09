<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackRequest;
use App\Http\Requests\UpdatePackRequest;
use App\Models\Contract;
use App\Models\Pack;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $packs = Pack::when($request->search, function ($query) use ($request) {
            $query->where('title', 'like', "%{$request->search}%");
            $query->orWhere('id', $request->search);
        })->latest()->paginate(50);

        return view('packs.index', compact('packs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contracts = Contract::where('status', true)->get();
        return view('packs.create', compact('contracts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackRequest $request)
    {
        try {
            Pack::create($request->validated());
            Alert::toast('Pacote cadastrado com sucesso.', 'success');
            return Redirect::route('packs.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao cadastrar pacote.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pack $pack)
    {
        $contracts = Contract::where('status', true)->get();
        return view('packs.edit', compact('pack', 'contracts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackRequest $request, Pack $pack)
    {
        try {
            $pack->update($request->validated());
            Alert::toast('Pacote editado com sucesso.', 'success');
            return Redirect::route('packs.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao editar pacote.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pack $pack)
    {
        $pack->delete();
        Alert::toast('Pacote deletado com sucesso.', 'success');
        return back();
    }
}

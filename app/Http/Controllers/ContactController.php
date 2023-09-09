<?php

namespace App\Http\Controllers;

use App\Http\Enums\UserRoleEnum;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contacts = Contact::when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->orWhere('id', $request->search);
                    $query->orWhere('name', 'like', "%{$request->search}%");
                    $query->orWhere('email', 'like', "%{$request->search}%");
                });
            })
            ->where(function ($query) {
                if (Auth::user()->role === UserRoleEnum::Admin->value) {
                    $query->whereNull('user_id')->whereNull('city');
                } else {
                    $query->where('user_id', Auth::id());
                }
            })
            ->latest()
            ->paginate(50);

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        Alert::toast('Contato deletado com sucesso.', 'success');
        return back();
    }
}

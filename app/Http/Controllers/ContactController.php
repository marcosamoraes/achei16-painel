<?php

namespace App\Http\Controllers;

use App\Http\Enums\UserRoleEnum;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === UserRoleEnum::Admin->value) {
            $contacts = Contact::whereNull('user_id')->whereNull('city')->latest()->paginate();
        } else {
            $contacts = Contact::where('user_id', Auth::id())->latest()->paginate();
        }
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
<?php

namespace App\Http\Controllers;

use App\Http\Enums\UserRoleEnum;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::whereNull('user_id')->whereNotNull('city')->latest()->paginate();
        return view('registers.index', compact('contacts'));
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

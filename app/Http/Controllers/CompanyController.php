<?php

namespace App\Http\Controllers;

use App\Http\Enums\UserRoleEnum;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::paginate(50);
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $categories = Category::all();
        return view('companies.create', compact('clients', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $validated['image'] = $validated['image']->store('companies');

            if (isset($validated['images']) && count($validated['images']) > 0) {
                $images = [];
                foreach ($validated['images'] as $image) {
                    $images[] = $image->store('companies');
                }
                $validated['images'] = $images;
            }

            $validated['user_id'] = $request->user()->role === UserRoleEnum::Seller->value ? $request->user()->id : null;

            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

            $company = Company::create($validated);

            foreach ($validated['categories'] as $category) {
                $company->categories()->attach($category);
            }

            foreach ($validated['tags'] as $name) {
                $tag = Tag::updateOrCreate(['name' => $name], ['name' => $name]);
                $company->tags()->attach($tag);
            }

            DB::commit();

            Alert::toast('Empresa cadastrada com sucesso.', 'success');
            return Redirect::route('companies.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            Alert::toast('Falha ao cadastrar empresa.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $clients = Client::all();
        $categories = Category::all();
        return view('companies.edit', compact('company', 'clients', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            if (isset($validated['image'])) {
                if ($company->image && file_exists('storage/' . $company->image)) {
                    unlink('storage/' . $company->image);
                }

                $validated['image'] = $validated['image']->store('companies');
            }

            if (isset($validated['images']) && count($validated['images']) > 0) {
                foreach ($company->images as $image) {
                    if (!file_exists('storage/' . $image)) continue;
                    unlink('storage/' . $image);
                }

                $images = [];
                foreach ($validated['images'] as $image) {
                    $images[] = $image->store('companies');
                }
                $validated['images'] = $images;
            }

            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

            $company->update($validated);

            $company->categories()->detach();
            foreach ($validated['categories'] as $category) {
                $company->categories()->attach($category);
            }

            $company->tags()->detach();
            foreach ($validated['tags'] as $name) {
                $tag = Tag::updateOrCreate(['name' => $name], ['name' => $name]);
                $company->tags()->attach($tag);
            }

            DB::commit();

            Alert::toast('Empresa editada com sucesso.', 'success');
            return Redirect::route('companies.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            Alert::toast('Falha ao editar empresa.', 'error');
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        $company->user->update(['status' => 0]);
        Alert::toast('Empresa deletada com sucesso.', 'success');
        return back();
    }
}

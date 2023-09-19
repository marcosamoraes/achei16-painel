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
use Buglinjo\LaravelWebp\Webp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $companies = Company::when($request->search, function ($query) use ($request) {
                $query->whereHas('client', function ($query) use ($request) {
                    $query->whereHas('user', function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search}%");
                        $query->orWhere('email', 'like', "%{$request->search}%");
                    });
                });
                $query->orWhere('name', 'like', "%{$request->search}%");
                $query->orWhere('id', $request->search);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('status_sell'), function ($query) use ($request) {
                if ($request->status_sell) {
                    $query->whereHas('orders', function ($query) {
                        $query->where('status', 'approved');
                        $query->where('expire_at', '>', now());
                    });
                } else {
                    $query->whereDoesntHave('orders', function ($query) {
                        $query->where('status', 'approved');
                        $query->where('expire_at', '>', now());
                    });
                }
            })
            ->when($request->seller, function ($query) use ($request) {
                $query->where('user_id', $request->seller);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->whereHas('categories', function ($query) use ($request) {
                    $query->where('category_id', $request->category);
                });
            })
            ->when($request->city, function ($query) use ($request) {
                $query->where('city', $request->city);
            })
            ->when($request->initial_created_at, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->initial_created_at);
            })
            ->when($request->final_created_at, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->final_created_at);
            })
            ->when($request->initial_expire_at, function ($query) use ($request) {
                $query->whereDate('expire_at', '>=', $request->initial_expire_at);
            })
            ->when($request->final_expire_at, function ($query) use ($request) {
                $query->whereDate('expire_at', '<=', $request->final_expire_at);
            })
            ->where(function ($query) {
                if (Auth::user()->role === UserRoleEnum::Seller->value) {
                    $query->where('user_id', Auth::id());
                } else if (Auth::user()->role === UserRoleEnum::Client->value) {
                    $client = Client::where('user_id', Auth::id())->first();
                    $query->where('client_id', $client->id);
                }
            })
            ->latest()
            ->paginate(50);

        $sellers = User::select()->role(UserRoleEnum::Seller->value)->get();
        $categories = Category::whereHas('companies')->where('status', true)->get();
        $cities = Company::distinct()->orderBy('city', 'asc')->pluck('city')->toArray();

        return view('companies.index', compact('companies', 'sellers', 'categories', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where(function ($query) {
            if (Auth::user()->role === UserRoleEnum::Seller->value) {
                $query->where('seller_id', Auth::id());
            }
        })->get();
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

            if (isset($validated['image'])) {
                $webp = Webp::make($validated['image']);
                $fileName = 'companies/' . uniqid() . '.webp';

                if (!file_exists(public_path('storage/companies'))) {
                    mkdir(public_path('storage/companies'), 0777, true);
                }

                if ($webp->save(public_path('storage/' . $fileName))) {
                    $validated['image'] = $fileName;
                }
            }

            if (isset($validated['images']) && count($validated['images']) > 0) {
                $images = [];
                foreach ($validated['images'] as $image) {
                    $webp = Webp::make($image);
                    $fileName = 'companies/' . uniqid() . '.webp';

                    if ($webp->save(public_path('storage/' . $fileName))) {
                        $images[] = $fileName;
                    }
                }
                $validated['images'] = $images;
            }

            $validated['user_id'] = $request->user()->role === UserRoleEnum::Seller->value ? $request->user()->id : null;

            $validated['slug'] = Str::slug($validated['name']);

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
        $clients = Client::where(function ($query) {
            if (Auth::user()->role === UserRoleEnum::Seller->value) {
                $query->where('seller_id', Auth::id());
            }
        })->get();
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

                if (!file_exists(public_path('storage/companies'))) {
                    mkdir(public_path('storage/companies'), 0777, true);
                }

                $webp = Webp::make($validated['image']);
                $fileName = 'companies/' . uniqid() . '.webp';

                if ($webp->save(public_path('storage/' . $fileName))) {
                    $validated['image'] = $fileName;
                }
            }

            if (isset($validated['images']) && count($validated['images']) > 0) {
                foreach ($company->images as $image) {
                    if (!file_exists('storage/' . $image)) continue;
                    unlink('storage/' . $image);
                }

                $images = [];
                foreach ($validated['images'] as $image) {
                    $webp = Webp::make($image);
                    $fileName = 'companies/' . uniqid() . '.webp';

                    if ($webp->save(public_path('storage/' . $fileName))) {
                        $images[] = $fileName;
                    }
                }
                $validated['images'] = $images;
            }

            $validated['slug'] = Str::slug($validated['name']);

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
        Alert::toast('Empresa deletada com sucesso.', 'success');
        return back();
    }
}

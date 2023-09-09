<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Buglinjo\LaravelWebp\Webp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $banners = Banner::latest()->paginate(50);
        return view('banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        try {
            $validated = $request->validated();

            $webp = Webp::make($validated['image']);
            $fileName = 'banners/' . uniqid() . '.webp';

            if (!file_exists(public_path('storage/banners'))) {
                mkdir(public_path('storage/banners'), 0777, true);
            }

            if ($webp->save(public_path('storage/' . $fileName))) {
                $validated['image'] = $fileName;
            }

            Banner::create($validated);
            Alert::toast('Banner cadastrado com sucesso.', 'success');
            return Redirect::route('banners.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao cadastrar banner.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        try {
            $validated = $request->validated();

            if (isset($validated['image'])) {
                if ($banner->image && file_exists('storage/' . $banner->image)) {
                    unlink('storage/' . $banner->image);
                }

                $webp = Webp::make($validated['image']);
                $fileName = 'banners/' . uniqid() . '.webp';

                if (!file_exists(public_path('storage/banners'))) {
                    mkdir(public_path('storage/banners'), 0777, true);
                }

                if ($webp->save(public_path('storage/' . $fileName))) {
                    $validated['image'] = $fileName;
                }
            }

            $banner->update($validated);
            Alert::toast('Banner editado com sucesso.', 'success');
            return Redirect::route('banners.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Alert::toast('Falha ao editar banner.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        Alert::toast('Banner deletado com sucesso.', 'success');
        return back();
    }
}

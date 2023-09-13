<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reviews = Review::when($request->search, function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('id', $request->search);
                $query->orWhere('name', 'like', "%{$request->search}%");
                $query->orWhere('title', 'like', "%{$request->search}%");
                $query->orWhereHas('company', function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->search}%");
                });
            });
        })
        ->latest()
        ->paginate(50);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        Alert::toast('Avaliação deletada com sucesso.', 'success');
        return back();
    }
}

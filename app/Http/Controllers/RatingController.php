<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $rating = Rating::where('ratingable_id', $request->ratingable_id)->where('ratingable_type', $request->ratingable_type)->orderBy('created_at', 'desc')->get();

        return $rating;
    }

    public function store(Request $request)
    {
        $cek_rating = Rating::where('ratingable_id', $request->ratingable_id)->where('ratingable_type', $request->ratingable_type)->where('user_id', auth()->user()->id);
        $request['user_id'] = auth()->user()->id;
        if ($cek_rating->count() >= 1) {
            $cek_rating->update($request->all());
        } else {
            $cek_rating = Rating::create($request->all());
        }

        $rating = Rating::where('ratingable_id', $request->ratingable_id)->where('ratingable_type', $request->ratingable_type);
        $sum = $rating->sum('value');
        $count = $rating->count();
        $data = $sum / $count;

        return ['message' => 'Rating has been added', 'data' => $data];
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $rating = Rating::find($id);
        $rating->delete();
        return ['message' => 'rating has been deleted', 'data' => $rating];
    }
}

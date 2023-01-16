<?php

namespace App\Http\Controllers;

use App\Models\SearchBox;
use Illuminate\Http\Request;

class SearchBoxController extends Controller
{
    public function index(Request $request)
    {
        $user = SearchBox::when($request->keyword, function ($q) use ($request) {
            return $q->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('descryption', 'like', '%' . $request->keyword . '%')
                ->orWhere('searcable_type', 'like', '%' . $request->keyword . '%')
                ->orWhere('tag', 'like', '%' . $request->keyword . '%');
        })
            ->with(['searcable.attachment', 'searcable.user'])->orderBy('created_at', 'desc');

        return $user->get();
    }
}

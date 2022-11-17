<?php

namespace App\Http\Controllers;

use App\Models\VideoContent;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index()
    {
        return VideoContent::with('attachment')->get();
        # code...
    }
    //
}

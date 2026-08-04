<?php

namespace App\Http\Controllers;

use App\Models\SocialLinks;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $links = SocialLinks::all();
        return response()->json($links);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\SocialLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SocialController extends Controller
{
    public function index()
    {
    return SocialLinks::all();
    }
}

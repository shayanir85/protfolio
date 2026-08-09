<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function get_email()
    {
        $user = User::first();
        return response()->json([
            'email' => $user ? $user->email : null,
        ]);
    }
}

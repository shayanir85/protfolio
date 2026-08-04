<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function get_email(User $user)
    {
        return response()->json([
            'email' => $user->email,
        ]);
    }
}

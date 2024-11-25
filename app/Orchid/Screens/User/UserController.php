<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUserByEmail(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        return response()->json(['user' => $user]);
    }
}
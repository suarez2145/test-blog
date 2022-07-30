<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserDetailsController extends Controller
{
    public function profile() {
        $currentUser =  Auth::user();
        
        return view('profile.details')->with('currentUser', $currentUser);
    }
}

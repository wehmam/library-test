<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view("admin.pages.login");
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(Auth::user()->getRoleNames()->isEmpty()) {
                Auth::logout();
                alertNotify(false, "You doesnt have role to access this site!");
                return back();
            }

            return redirect()->intended('/dashboard');
        }

        alertNotify(false, "Authentication Failed");
        return back();
    }

    public function logout() {
        Auth::guard('web')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }
}

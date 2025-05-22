<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->messages());
            return redirect()->back()->withInput();
        }
        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        try {
            if (auth()->attempt($credentials)) {
                Alert::success('success', 'Login Berhasil di lakukan');

                $request->session()->regenerate();
                $request->session()->put('name', auth()->user()->name);
                $request->session()->put('email', auth()->user()->email);
                $request->session()->put('id', auth()->user()->id);

                Alert::success('Success', 'Login Berhasil');

                return redirect()->route('dashboard')->with('success', 'Login Berhasil');
            } else {
                Alert::error('Gagal', "Email atau password salah");
                return back();
            }
        } catch (Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat login');
            return back();
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the token to prevent CSRF attacks
        $request->session()->regenerateToken();

        Alert::success('Success', 'Logout Berhasil');
        return redirect()->route('dashboard');;
    }
}

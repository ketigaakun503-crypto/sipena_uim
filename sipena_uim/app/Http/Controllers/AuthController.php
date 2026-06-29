<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
{
    $result = $this->authService->login($request->only('email', 'password'));

    if (!$result) {
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    return redirect()->route('dashboard');
}

    public function logout(Request $request)
    {
        $this->authService->logout();
        return redirect()->route('login');
    }
}
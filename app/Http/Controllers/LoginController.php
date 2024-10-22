<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Mostrar vista de login
    public function showLoginForm()
    {
        return view('login');
    }

    // Manejar el login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Registrar login
            LoginLog::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'action_at' => now(),
            ]);

            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    // Manejar el logout
    public function logout()
    {
        // Registrar logout
        LoginLog::create([
            'user_id' => Auth::id(),
            'action' => 'logout',
            'action_at' => now(),
        ]);

        Auth::logout();
        return redirect('/');
    }

    // Mostrar el formulario de registro
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Manejar el registro de un nuevo usuario
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Iniciar sesión automáticamente después del registro
        auth()->login($user);

        // Redirigir a la página deseada (por ejemplo, dashboard)
        return redirect()->route('dashboard');
    }
}

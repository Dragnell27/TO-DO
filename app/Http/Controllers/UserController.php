<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Retorna la vista para el inicio de sesión.
    function index()
    {
        return view('auth.login');
    }

    //Función que registra un nuevo usuario
    function storage(Request $request)
    {

        $request->validate([
            'username' => ['required', 'string', 'max:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        Auth::login($user);
        return redirect()->route('login');
    }

    function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'username' => 'required|string',
            'password' => 'required', // Ejemplo de validación adicional
        ]);

        // Obtener credenciales
        $credentials = $request->only('username', 'password');

        // Intentar autenticar
        if (Auth::attempt($credentials)) {
            // Regenerar sesión
            $request->session()->regenerate();

            // Redirigir al usuario a la página principal
            return redirect()->intended('/');
        }

        // Si la autenticación falla, redirigir de vuelta con un mensaje de error
        return back()->withErrors([
            'username' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput(); // Mantiene los datos ingresados para el caso de que el usuario quiera corregir el error
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}

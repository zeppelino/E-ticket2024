<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            /* 'password' => ['required', 'confirmed', Rules\Password::defaults()], */
            'password' => [
                'required',
                'confirmed',
                Password::min(8) // Mínimo de 8 caracteres
                    ->mixedCase() // Al menos una letra mayúscula y una minúscula
                    ->numbers() // Al menos un número
                    ->symbols(), // Al menos un símbolo
            ],
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.mixedCase' => 'La contraseña debe contener al menos una letra mayúscula y una minúscula.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
            'password.symbols' => 'La contraseña debe incluir al menos un símbolo.',
        ]);

        /* Regla confirmed: Esta regla busca automáticamente un campo con el sufijo: _confirmation
        por ejemplo: nombreCampo_confirmation. Si no se encuentra o si los valores no coinciden,
        Laravel generará un error de validación.
        En este caso se utiliza para confirmar que los 2 campos de contraseña sean iguales  */

        $user = User::create([
            'name' => $request->nombre,
            'lastName' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profileImage' => "1729278981.png",
        ]);

        $user->assignRole('Cliente');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;

class PerfilController extends Controller
{
    public function mostrarPerfil(){
        return view('admin.perfil');
    }

    public function modificarPerfil(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación para la imagen
            'current_password' => 'nullable', // Solicitar la contraseña actual
            'password' => [
                'nullable',
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

        $user = auth()->user(); // Obtener el usuario autenticado

    // Verificar si se hicieron cambios en los datos
    $hasChanges = false;

    if ($user->name !== $request->input('nombre')) {
        $user->name = $request->input('nombre');
        $hasChanges = true;
    }

    if ($user->lastName !== $request->input('apellido')) {
        $user->lastName = $request->input('apellido');
        $hasChanges = true;
    }
  
 // Verificar que la contraseña actual sea correcta
 if($request->filled('current_password')){
 if (!Hash::check($request->input('current_password'), $user->password)) {
    return redirect()->back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
 }
 // Si el campo de contraseña no está vacío, actualiza la contraseña
 else{
    $request->validate([
    'password' => ['required', 'confirmed', Rules\Password::defaults()]]);
    $user->password = Hash::make($request->input('password'));
    $hasChanges = true;
}}
    // Si hay una imagen, procesarla
    if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');
        $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
        $imagen->move(public_path('path_to_images'), $nombreImagen);

        // Actualiza el campo de imagen del usuario
        $imagenVieja= $user-> profileImage;
        $user-> profileImage = $nombreImagen;
        $hasChanges = true;
        $rutaImagenVieja = public_path('path_to_images/' . $imagenVieja);
       
    if($imagenVieja!="1729278981.png"){    
        if (File::exists($rutaImagenVieja)) {
            File::delete($rutaImagenVieja);
        }}
}
     // Guardar solo si hubo cambios
     if ($hasChanges) {
        $user->save();
        return redirect()->route('dashboard')->with('success', 'Se realizaron los cambios correctamente');
    }
    /*return redirect()->back()->with('success', 'Perfil actualizado correctamente');*/ 
    return redirect()->route('dashboard')->with('success', 'No se realizaron cambios');

    }
}
 
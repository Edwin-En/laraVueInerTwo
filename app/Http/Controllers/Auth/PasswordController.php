<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\UserPasswordLog;


class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/', // Al menos una mayúscula
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Al menos un símbolo
            ],
        ]);
    
        $user = $request->user();
    
        // Verificar que la nueva contraseña no esté entre las últimas 5 contraseñas
        $recentPasswords = UserPasswordLog::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->pluck('password')
            ->toArray();
    
        foreach ($recentPasswords as $password) {
            if (Hash::check($validated['password'], $password)) {
                return back()->withErrors(['password' => 'La nueva contraseña no puede ser una de las últimas 5 contraseñas utilizadas.']);
            }
        }
    
        // Guardar la contraseña anterior en el historial de contraseñas
        UserPasswordLog::create([
            'user_id' => $user->id,
            'password' => $user->password,
        ]);
    
        // Actualizar la contraseña del usuario
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
    
        return back();
    }
}

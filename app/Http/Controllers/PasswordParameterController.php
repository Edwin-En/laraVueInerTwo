<?php

namespace App\Http\Controllers;

use App\Models\PasswordParameter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class PasswordParameterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'length' => 'required|integer|min:1',
            'uppercase' => 'required|boolean',
            'lowercase' => 'required|boolean',
            'digits' => 'required|boolean',
            'special_characters' => 'required|boolean',
        ]);

        PasswordParameter::create($request->all());

        return redirect()->back()->with('success', 'Parámetros de contraseña guardados correctamente.');
    }

    public function index()
    {
        $parameters = PasswordParameter::latest()->first();

        return Inertia::render('ManagePassword/Index', ['parameters' => $parameters]);
    }
}

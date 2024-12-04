<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('facturas.index', [
            'facturas' => Factura::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facturas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'numero' => 'required|max:4|unique:facturas,numero',
        ]);
        $factura = new Factura($validated);
        $factura->user_id = Auth::id();
        $factura->save();
        session()->flash('exito', 'Factura creada correctamente.');
        return redirect()->route('facturas.show', $factura);
    }

    /**
     * Display the specified resource.
     */
    public function show(Factura $factura)
    {
        return view('facturas.show', [
            'factura' => $factura,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factura $factura)
    {
        return view('facturas.edit', [
            'factura' => $factura,
            'users' => User::All(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Factura $factura)
    {
        $validated = $request->validate([
            'numero' => [
                'required',
                'max:4',
                Rule::unique('facturas')->ignore($factura),
            ],
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
        ]);
        $factura->fill($validated);
        $factura->save();
        session()->flash('exito', 'Factura modificado correctamente.');
        return redirect()->route('facturas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factura $factura)
    {
        $factura->articulos()->detach();
        $factura->delete();
        return redirect()->route('facturas.index');
    }
}

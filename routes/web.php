<?php

use Illuminate\Support\Facades\Route;
use App\Models\Citas;

// Página de inicio con un botón para crear cita
Route::get('/citas', function () {
    return view('citas.inicio');
});

// Mostrar el formulario para crear una cita
Route::get('/citas/create', function () {
    return view('citas.create');
});

// Crear la cita y redirigir a la página de edición
Route::post('/citas', function () {
    $cita = Citas::create(request()->all());
    return redirect()->route('citas.edit', ['id' => $cita->id]);
});

// Mostrar la página de edición de una cita
Route::get('/citas/{id}/edit', function ($id) {
    $cita = Citas::findOrFail($id);
    return view('citas.edit', compact('cita'));
})->name('citas.edit');

// Actualizar la cita
Route::put('/citas/{id}', function ($id) {
    $cita = Citas::findOrFail($id);
    $cita->update(request()->all());
    return redirect()->route('citas.edit', ['id' => $cita->id]);
});

// Eliminar una cita
Route::delete('/citas/{id}', function ($id) {
    $cita = Citas::findOrFail($id);
    $cita->delete();
    return redirect('/citas');
});

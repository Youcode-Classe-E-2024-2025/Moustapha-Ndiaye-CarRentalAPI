<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Car::all(), 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'is_available' => 'boolean',
            'daily_rate' => 'required|numeric|min:0',
        ]);

        $car = Car::create($validated);

        return response()->json($car, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return response()->json($car, 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'model' => 'string|max:255',
            'image_url' => 'nullable|url',
            'is_available' => 'boolean',
            'daily_rate' => 'numeric|min:0',
        ]);

        $car->update($validated);

        return response()->json($car, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return response()->json(['message' => 'Car deleted'], 204);
    }

}

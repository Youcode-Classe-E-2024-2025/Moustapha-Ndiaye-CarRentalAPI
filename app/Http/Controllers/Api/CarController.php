<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => ['required', 'string', 'min:3', 'max:255'],
            'image_url' => ['nullable', 'string'], 
            'is_available' => ['boolean'],
            'daily_rate' => ['required', 'numeric', 'min:1']
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ], 422);
        }

        $cars = Car::create($request->all());
        return response()->json([
            'status' => true, 
            'message' => 'Car created successfuly',
            'data' => new CarResource($cars)
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // retrive car by id
        $car = Car::find($id);

        // handle error response 
        if (!$car) {
            return response()->json([
                'status' => false, 
                'message' => 'Car not found!',
            ], 404);
        }

        // handle success reponse 
        return response()->json([
            'status' => true, 
            'message' => 'Car retrieved successfully!',
            'data' => new CarResource($car),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

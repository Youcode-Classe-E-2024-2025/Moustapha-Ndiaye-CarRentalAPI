<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;
use App\Models\User;
use OpenApi\Annotations as OA;

/**
 * @OA\Components(
 *     @OA\Schema(
 *         schema="Car",
 *         type="object",
 *         required={"id", "model", "daily_rate"},
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="model", type="string", example="Toyota Corolla"),
 *         @OA\Property(property="image_url", type="string", example="http://example.com/car.jpg"),
 *         @OA\Property(property="is_available", type="boolean", example=true),
 *         @OA\Property(property="daily_rate", type="number", format="float", example=29.99)
 *     )
 * )
 */


class CarController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/cars",
     *     summary="Cars list",
     *     tags={"Cars"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des voitures",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Car"))
     *     )
     * )
     */
    public function index()
    {
        //   // retrive car by id
        //   $car = Car::all();

        //   // handle error response 
        //   if (!$car) {
        //       return response()->json([
        //           'status' => false, 
        //           'message' => 'Car not found!',
        //       ], 404);
        //   }
  
        //   // handle success reponse 
        //   return response()->json([
        //       'status' => true, 
        //       'message' => 'Cars retrieved successfully!',
        //       'data' => CarResource::collection($car),
        //   ], 200);
        
        //with pagination

        // retrive car by id
        
        $cars = Car::orderBy('updated_at', 'desc')->paginate(3);

        // handle error response 
        if ($cars->isEmpty()) {
            return response()->json([
                'status' => false, 
                'message' => 'No cars found!',
            ], 404);
        }

        // handle success reponse 
        return response()->json([
            'status' => true, 
            'message' => 'Cars retrieved successfully!',
            'data' => [
                'cars' => CarResource::collection($cars),
                'pagination' => [
                    'total' => $cars->total(),
                    'perPage' => $cars->perPage(),
                    'currentPage' => $cars->currentPage(),
                    'lastPage' => $cars->lastPage(),
                    'nextPageUrl' => $cars->nextPageUrl(),
                    'previousPageUrl' => $cars->previousPageUrl(),
                ]
            ],
        ], 200);
    }

    /**
 * @OA\Post(
 *     path="/api/cars",
 *     summary="New Car",
 *     tags={"Cars"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"model", "daily_rate"},
 *             @OA\Property(property="model", type="string", example="Toyota Corolla"),
 *             @OA\Property(property="image_url", type="string", example="http://example.com/car.jpg"),
 *             @OA\Property(property="is_available", type="boolean", example=true),
 *             @OA\Property(property="daily_rate", type="number", format="float", example=29.99)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Voiture créée avec succès",
 *         @OA\JsonContent(ref="#/components/schemas/Car")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreur de validation des champs"
 *     )
 * )
 */

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
     * @OA\Get(
     *     path="/api/cars/{id}",
     *     summary="Retrive car by id",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voiture récupérée",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voiture non trouvée"
     *     )
     * )
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
 * @OA\Put(
 *     path="/api/cars/{id}",
 *     summary="Update car infos",
 *     tags={"Cars"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"model", "daily_rate"},
 *             @OA\Property(property="model", type="string", example="Toyota Corolla"),
 *             @OA\Property(property="image_url", type="string", example="http://example.com/car.jpg"),
 *             @OA\Property(property="is_available", type="boolean", example=true),
 *             @OA\Property(property="daily_rate", type="number", format="float", example=29.99)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Voiture mise à jour avec succès",
 *         @OA\JsonContent(ref="#/components/schemas/Car")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Voiture non trouvée"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreur de validation des champs"
 *     )
 * )
 */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

        // retrive car by id
        $car = Car::find($id);

        // handle error response 
        if (!$car) {
            return response()->json([
                'status' => false, 
                'message' => 'Car not found!',
            ], 404);
        }

        $car->update($request->all());
        return response()->json([
            'status' => true, 
            'message' => 'Car updated successfuly',
            'data' => new CarResource($car)
        ], 201);
    }

    /**
 * @OA\Delete(
 *     path="/api/cars/{id}",
 *     summary="Delete car",
 *     tags={"Cars"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Voiture supprimée avec succès"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Voiture non trouvée"
 *     )
 * )
 */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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

        $car->destroy($id);
        return response()->json([
            'status' => true, 
            'message' => 'Car deleted successfuly!'
        ]);
    }
}

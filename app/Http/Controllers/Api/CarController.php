<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;
use App\Models\User;
use OpenApi\Annotations as OA;


class CarController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/cars",
     *     summary="Get a list of cars",
     *     description="Returns a paginated list of cars",
     *     @OA\Response(
     *         response=200,
     *         description="A list of cars",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="cars", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="pagination", type="object")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No cars found"
     *     )
     * )
     */
    /**
     * Display a listing of the resource.
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
     *     summary="Create a new car",
     *     description="Add a new car to the database",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"model", "daily_rate"},
     *             @OA\Property(property="model", type="string"),
     *             @OA\Property(property="image_url", type="string"),
     *             @OA\Property(property="is_available", type="boolean"),
     *             @OA\Property(property="daily_rate", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Car created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object")
     *         )
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
     *     summary="Get a specific car",
     *     description="Fetch the details of a single car",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car details",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found"
     *     )
     * )
     */

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
     * @OA\Put(
     *     path="/api/cars/{id}",
     *     summary="Update an existing car",
     *     description="Modify the details of an existing car",
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
     *             @OA\Property(property="model", type="string"),
     *             @OA\Property(property="image_url", type="string"),
     *             @OA\Property(property="is_available", type="boolean"),
     *             @OA\Property(property="daily_rate", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors"
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
     *     summary="Delete a specific car",
     *     description="Remove a car from the database",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found"
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RentalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rentals",
     *     summary="Get a list of rentals",
     *     tags={"Rentals"},
     *     @OA\Response(
     *         response=200,
     *         description="List of rentals",
     *         @OA\JsonContent(type="array", @OA\Items(type="string"))
     *     )
     * )
     */
    public function index()
    {
        // Lister les locations
    }

    /**
     * @OA\Post(
     *     path="/api/rentals",
     *     summary="Create a new rental",
     *     tags={"Rentals"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"car_id", "user_id", "start_date", "end_date"},
     *             @OA\Property(property="car_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="start_date", type="string", format="date-time"),
     *             @OA\Property(property="end_date", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Rental created"),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    public function store(Request $request)
    {
        // Créer une nouvelle location
    }

    /**
     * @OA\Get(
     *     path="/api/rentals/{id}",
     *     summary="Get a rental by ID",
     *     tags={"Rentals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Rental found"),
     *     @OA\Response(response=404, description="Rental not found")
     * )
     */
    public function show(string $id)
    {
        // Afficher une location par son ID
    }

    /**
     * @OA\Put(
     *     path="/api/rentals/{id}",
     *     summary="Update a rental",
     *     tags={"Rentals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"car_id", "user_id", "start_date", "end_date"},
     *             @OA\Property(property="car_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="start_date", type="string", format="date-time"),
     *             @OA\Property(property="end_date", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Rental updated"),
     *     @OA\Response(response=400, description="Invalid input"),
     *     @OA\Response(response=404, description="Rental not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        // Mettre à jour une location
    }

    /**
     * @OA\Delete(
     *     path="/api/rentals/{id}",
     *     summary="Delete a rental",
     *     tags={"Rentals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Rental deleted"),
     *     @OA\Response(response=404, description="Rental not found")
     * )
     */
    public function destroy(string $id)
    {
        // Supprimer une location
    }
}

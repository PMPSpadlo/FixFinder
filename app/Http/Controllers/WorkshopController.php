<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Workshops",
 *     description="Operations related to workshops"
 * )
 */
class WorkshopController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/workshops",
     *     summary="Get list of workshops",
     *     tags={"Workshops"},
     *     @OA\Response(response=200, description="List of workshops")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Workshop::with('services')->get());
    }

    /**
     * @OA\Get(
     *     path="/api/workshops/{id}",
     *     summary="Get workshop details",
     *     tags={"Workshops"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Workshop ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Workshop details")
     * )
     */
    public function show($id): JsonResponse
    {
        $workshop = Workshop::with(['services', 'reviews'])->findOrFail($id);
        return response()->json($workshop);
    }

    /**
     * @OA\Post(
     *     path="/api/workshops",
     *     summary="Create a workshop",
     *     tags={"Workshops"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "name", "address", "city"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="latitude", type="number", format="float"),
     *             @OA\Property(property="longitude", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Workshop created")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);

        $workshop = Workshop::create($validated);

        return response()->json($workshop, 201);
    }
}

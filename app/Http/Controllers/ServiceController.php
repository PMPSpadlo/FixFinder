<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Services",
 *     description="Operations related to services"
 * )
 */
class ServiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/services",
     *     summary="Get list of services",
     *     tags={"Services"},
     *     @OA\Response(response=200, description="List of services")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Service::all());
    }

    /**
     * @OA\Post(
     *     path="/api/services",
     *     summary="Create a service",
     *     tags={"Services"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"workshop_id", "name", "price"},
     *             @OA\Property(property="workshop_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Service created")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'workshop_id' => 'required|exists:workshops,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0'
        ]);

        $service = Service::create($validated);

        return response()->json($service, 201);
    }
}

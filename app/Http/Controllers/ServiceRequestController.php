<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="ServiceRequests",
 *     description="Operations related to service requests"
 * )
 */
class ServiceRequestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/service-requests",
     *     summary="Get list of service requests",
     *     tags={"ServiceRequests"},
     *     @OA\Response(response=200, description="List of service requests")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(ServiceRequest::all());
    }

    /**
     * @OA\Get(
     *     path="/api/service-requests/{id}",
     *     summary="Get service request details",
     *     tags={"ServiceRequests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Service request ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Service request details")
     * )
     */
    public function show($id): JsonResponse
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        return response()->json($serviceRequest);
    }

    /**
     * @OA\Post(
     *     path="/api/service-requests",
     *     summary="Create a new service request",
     *     tags={"ServiceRequests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "workshop_id", "description"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="workshop_id", type="integer"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string", enum={"pending", "accepted", "in_progress", "completed", "declined"})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Service request created")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'workshop_id' => 'required|exists:workshops,id',
            'description' => 'required|string',
            'status' => 'nullable|in:pending,accepted,in_progress,completed,declined',
        ]);

        $serviceRequest = ServiceRequest::create($validated);

        return response()->json($serviceRequest, 201);
    }

    /**
     * @OA\Patch(
     *     path="/api/service-requests/{id}",
     *     summary="Update service request status",
     *     tags={"ServiceRequests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Service request ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"pending", "accepted", "in_progress", "completed", "declined"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Service request status updated")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,in_progress,completed,declined',
        ]);

        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Service request status updated successfully.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Reviews",
 *     description="Operations related to reviews"
 * )
 */
class ReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Get list of reviews",
     *     tags={"Reviews"},
     *     @OA\Response(response=200, description="List of reviews")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Review::all());
    }

    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Create a review",
     *     tags={"Reviews"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "workshop_id", "rating"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="workshop_id", type="integer"),
     *             @OA\Property(property="rating", type="integer", minimum=1, maximum=5),
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Review created")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'workshop_id' => 'required|exists:workshops,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = Review::create($validated);

        return response()->json($review, 201);
    }
}

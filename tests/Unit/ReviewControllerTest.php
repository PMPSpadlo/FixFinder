<?php

namespace Tests\Unit;

use App\Models\Review;
use PHPUnit\Framework\TestCase;

class ReviewControllerTest extends TestCase
{
    public function test_example()
    {
        // Tworzymy 3 recenzje
        $reviews = Review::factory()->count(3)->create();

        // Sprawdzamy, czy recenzje zostały utworzone
        $this->assertCount(3, $reviews);
    }

    public function test_create_review()
    {
        $data = [
            'user_id' => 1,
            'workshop_id' => 1,
            'rating' => 5,
            'comment' => 'Świetna obsługa!',
        ];

        // Sprawdzamy, czy recenzja została poprawnie utworzona
        $review = Review::create($data);

        $this->assertEquals($data['user_id'], $review->user_id);
        $this->assertEquals($data['workshop_id'], $review->workshop_id);
        $this->assertEquals($data['rating'], $review->rating);
        $this->assertEquals($data['comment'], $review->comment);
    }
}

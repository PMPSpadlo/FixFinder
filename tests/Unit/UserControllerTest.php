<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    public function test_example()
    {
        // Tworzymy 3 użytkowników
        $users = User::factory()->count(3)->create();

        // Sprawdzamy, czy użytkownicy zostali utworzeni
        $this->assertCount(3, $users);
    }
}

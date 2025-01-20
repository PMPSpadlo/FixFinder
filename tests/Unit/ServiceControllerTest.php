<?php

namespace Tests\Unit;

use App\Models\Service;
use PHPUnit\Framework\TestCase;

class ServiceControllerTest extends TestCase
{
    public function test_example()
    {
        // Tworzymy 3 usługi
        $services = Service::factory()->count(3)->create();

        // Sprawdzamy, czy usługi zostały utworzone
        $this->assertCount(3, $services);
    }

    public function test_create_service()
    {
        $data = [
            'workshop_id' => 1,
            'name' => 'Naprawa samochodów',
            'price' => 100.50,
            'description' => 'Szczegółowa naprawa samochodów',
        ];

        // Sprawdzamy, czy usługa została poprawnie utworzona
        $service = Service::create($data);

        $this->assertEquals($data['workshop_id'], $service->workshop_id);
        $this->assertEquals($data['name'], $service->name);
        $this->assertEquals($data['price'], $service->price);
        $this->assertEquals($data['description'], $service->description);
    }
}

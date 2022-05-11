<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_making_an_api_request()
    {
        $response = $this->getJson('/api/hello');
 
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => "Hello World!",
            ]);
    }

}

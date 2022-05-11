<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_404()
    {
        $response = $this->get('/Laravel');

        $response->assertStatus(404);
    }

    public function test_interacting_with_headers()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/about', ['name' => 'Nero'], ['age' => '20']);
 
        $response->assertStatus(201);
    }

    public function test_interacting_without_headers()
    {
        $response = $this->get('/about');
 
        $response->assertStatus(200);
    }
}

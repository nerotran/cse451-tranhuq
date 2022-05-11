<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_404()
    {
        $response = $this->get('/Laravel');

        $response->assertStatus(404);
    }

    public function test_View()
    {
        $response = $this->view('hello', ['name' => 'James']);

        $response->assertSee('Hello James');
    }

    public function test_making_an_api_request()
    {
        $this->postJson('/api/hello')
            ->assertStatus(201)
            ->assertJson([
                'message' => "Hello World!",
            ]);
    }

}

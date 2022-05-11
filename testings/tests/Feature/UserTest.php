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

    public function test_View()
    {
        $response = $this->view('/Hello', ['name' => 'James']);

        $response->assertSee('Hello James');
    }

}

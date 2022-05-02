<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class SongApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_can_create_song(){
	$formData = [
            'title' => "test song",
	    'artist' => "adele",
	    'rank' => 1
	];

	$this->post(route('songs.store'), $formData)
	    ->assertStatus(201)
            ->assertJson($formData)
	    ->assertJsonStructure([
                'id',
		'title',
		'artist',
		'rank'
            ]);
    }
}

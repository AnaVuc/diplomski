<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Rating;
use App\Models\Watch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_top_rated_films()
    {
        Rating::factory(10)->create();

        $response = $this->call('GET','api/topRatedMovies')
        ->assertSuccessful();
    }
    public function test_my_watched_films()
    {
        Watch::factory(7)->create([
            'idUser' => 4
        ]);
        Watch::factory(3)->create([]);

        $response = $this->call('POST','api/myWatchedFilms',['user'=>4])
        ->assertSuccessful();
    }
}

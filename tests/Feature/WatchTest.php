<?php

namespace Tests\Feature;

use App\Models\Watch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WatchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_watch_film()
    {
        $param = [
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/watchFilm',$param)
        ->assertSuccessful();
        $this->assertDatabaseCount('watched',Watch::all()->count());
        $response->assertStatus(200);
    }
    public function test_watched_film()
    {
        Watch::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        $param = [
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/watchFilm',$param)
        ->assertSuccessful();
        $this->assertDatabaseCount('watched',1);
        $response->assertStatus(200);
    }

    public function test_delete_watch()
    {
        Watch::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        $param = [
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/deleteWatch',$param)
        ->assertSuccessful();
        $this->assertDatabaseCount('watched',0);

    }

    public function test_check_if_watched()
    {
        Watch::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        $param = [
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/checkIfWatched',$param)
        ->assertSuccessful()
        ->assertJsonFragment([
            'idFilm' => 'tt123456',
        ]);

    }

    // public function test_my_watched_films()
    // {
    //     Watch::create([
    //         'idFilm' => 'tt123456',
    //         'idUser' => 1,
    //     ]);
    //     Watch::create([
    //         'idFilm' => 'tt654321',
    //         'idUser' => 1,
    //     ]);
    //     $param = [
    //         'user' => 1,
    //     ];
    //     $response = $this->call('POST','/api/myWatchedFilms',$param)
    //     ->assertSuccessful();
    //     $this->assertEquals(Watch::orderBy('created_at', 'desc')->get(),$response->getOriginalContent());
    // }

    public function test_count_film_watched()
    {
        Watch::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        Watch::create([
            'idFilm' => 'tt123456',
            'idUser' => 2,
        ]);
        Watch::create([
            'idFilm' => 'tt123456',
            'idUser' => 3,
        ]);
        $param = [
            'idFilm' => 'tt123456',
        ];
        $response = $this->call('POST','/api/countFilmWatched',$param)
        ->assertSuccessful();
        $this->assertEquals(3,$response->getOriginalContent());
    }
}

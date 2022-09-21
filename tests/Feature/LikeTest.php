<?php

namespace Tests\Feature;

use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_like_film()
    {

        $param = [
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/likeFilm',$param)
        ->assertSuccessful();
        $this->assertDatabaseCount('likes',Like::all()->count());
        $response->assertStatus(200);

    }
    public function test_liked_film()
    {
        Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        $param = [
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/likeFilm',$param)
        ->assertSuccessful();
        $this->assertDatabaseCount('likes',1);
        $response->assertStatus(200);

    }

    public function test_delete_like()
    {
        Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        $param = [
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/deleteLike',$param)
        ->assertSuccessful();
        $this->assertDatabaseCount('likes',0);

    }

    public function test_check_if_liked()
    {
        Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        $param = [
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/checkIfLiked',$param)
        ->assertSuccessful()
        ->assertJsonFragment([
            'idFilm' => 'tt123456',
        ]);

    }

    public function test_my_liked_films()
    {
        Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        Like::create([
            'idFilm' => 'tt654321',
            'idUser' => 1,
        ]);
        $param = [
            'user' => 1,
        ];
        $response = $this->call('POST','/api/myLikedFilms',$param)
        ->assertSuccessful();
        $this->assertEquals(['tt123456','tt654321'],$response->getOriginalContent());
    }

    public function test_count_film_liked()
    {
        Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ]);
        Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 2,
        ]);
        Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 3,
        ]);
        $param = [
            'idFilm' => 'tt123456',
        ];
        $response = $this->call('POST','/api/countFilmLiked',$param)
        ->assertSuccessful();
        $this->assertEquals(3,$response->getOriginalContent());
    }
}

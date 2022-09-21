<?php

namespace Tests\Feature;

use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_rate_film()
    {
        $response = $this->post('/api/rateFilm',[
            'idFilm' => 'tt123456',
            'idUser' => '1',
            'rating' => '3',
        ])->assertSuccessful();
        $this->assertDatabaseCount('ratings',Rating::all()->count());

    }

    public function test_calculate_film_rating()
    {
        Rating::factory(3)->create([
            'idFilm' => 'tt123456',
        ]);
        $response = $this->post('/api/calculateFilmRating',[
            'idFilm' => 'tt123456',
        ])->assertSuccessful();
        $this->assertIsNumeric($response->getOriginalContent());
        $this->assertEquals(Rating::all()->pluck('rating')->average(),$response->getOriginalContent());
        // dd(Rating::all(),$response->getOriginalContent());

    }
    public function test_get_rating()
    {
        Rating::factory()->create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
            'id' =>1,
            'rating' =>4
        ]);
        $response = $this->call('GET','/api/getRating',[
            'idFilm' => 'tt123456',
            'idUser' => 1,
        ])->assertSuccessful();
        $this->assertEquals(Rating::where('id',1)->pluck('rating'),$response->getOriginalContent());

    }
    // public function test_rating_can_be_updated()
    // {
    //     Rating::factory()->create([
    //         'idFilm' => 'tt123456',
    //         'idUser' => 1,
    //         'rating' =>4,
    //         'id' =>1
    //     ]);
    //     $params=[
    //         'idFilm' => 'tt1234561',
    //         'idUser' => 1,
    //         'rating' => 2,
    //     ];
    //     // dd(Rating::where('idFilm','tt123456')->first(),$params);
    //     $reponse = $this->call('POST','api/updateRating',$params);
    //     dd($reponse);
    //     // ->assertSuccessful()
    //     // ->assertJsonFragment(['idFilm' => 'tt1234561']);
    // }
}

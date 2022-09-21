<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Watch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_review()
    {
        Review::create([
            'idFilm' => 'tt1375666',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        $param = [
            'idFilm' => 'tt1375666',
            'idUser' => 1,
        ];
        $response = $this->call('POST','/api/deleteReview',$param)
        ->assertSuccessful();
        $this->assertDatabaseCount('watched',0);

    }
    public function test_review_has_rating()
    {
        Review::create([
            'id' =>1,
            'idFilm' => 'tt1375666',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        Rating::create([
            'idFilm' => 'tt1375666',
            'idUser' => 1,
            'rating' => 2,
            'review_id' => 1
        ]);
        $param = [
            'reviewId' => 1
        ];
        $response = $this->call('POST','/api/reviewHasRating',$param)
        ->assertSuccessful();
        $this->assertArrayHasKey('rating',$response->getOriginalContent()->toArray()[0]);
    }
    public function test_review_doesnt_have_rating()
    {
        Review::create([
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        Rating::create([
            'idFilm' => 'tt1375666',
            'idUser' => 1,
            'rating' => 2,
            'review_id' => null

        ]);
        $param = [
            'reviewId' => 1
        ];
        $response = $this->call('POST','/api/reviewHasRating',$param)
        ->assertSuccessful();
        $this->assertEmpty($response->getOriginalContent());
    }
    public function test_review_has_like()
    {
        Review::create([
            'id' =>1,
            'idFilm' => 'tt1375666',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        Like::create([
            'idFilm' => 'tt1375666',
            'idUser' => 1,
            'review_id' => 1
        ]);
        $param = [
            'reviewId' => 1
        ];
        $response = $this->call('POST','/api/reviewHasLike',$param)
        ->assertSuccessful();
        // dd($response->getOriginalContent()->toArray()[0]);
        $this->assertArrayHasKey('review_id',$response->getOriginalContent()->toArray());
    }
    public function test_review_doesnt_have_like()
    {
        Review::create([
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        Like::create([
            'idFilm' => 'tt1375666',
            'idUser' => 1,
            'review_id' => null

        ]);
        $param = [
            'reviewId' => 1
        ];
        $response = $this->call('POST','/api/reviewHasLike',$param)
        ->assertSuccessful();
        $this->assertEmpty($response->getOriginalContent());
    }

    public function test_save_review(){
        $param = [
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception',
            'rating' => 4,
            'like' =>true
        ];
        $response = $this->call('POST','/api/saveReview',$param)
        ->assertSuccessful();
        $this->assertDatabaseCount('reviews',1);
        $this->assertDatabaseCount('watched',1);
        $this->assertDatabaseCount('ratings',1);
        $this->assertDatabaseCount('likes',1);

    }
    public function test_review_can_be_updated()
    {
        Review::create([
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception',

        ]);
        $params=[
            'idFilm'=>'tt4372623',
            'idUser'=>1,
            'reviewText'=>'Great movie!',
            'filmTitle'=>'Inception',
            'like' =>true,
        ];
        $response = $this->call('POST','api/updateReview',$params)
        ->assertSuccessful()
        ->assertJsonFragment(['reviewText'=>'Great movie!']);
    }
    public function test_review_can_be_updated_without_like()
    {
        Review::create([
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        Like::create([
            'review_id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
        ]);
        $params=[
            'idFilm'=>'tt4372623',
            'idUser'=>1,
            'reviewText'=>'Great movie!',
            'filmTitle'=>'Inception',
            'like' =>false,
            'rating' => false
        ];
        $response = $this->call('POST','api/updateReview',$params)
        ->assertSuccessful()
        ->assertJsonFragment(['reviewText'=>'Great movie!']);
        $this->assertDatabaseCount('likes',0,);
    }
    public function test_rating_can_be_updated()
    {
        Rating::create([
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'rating' => 3
        ]);
        $params=[
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'rating' => 4.0
        ];
        $response = $this->call('POST','api/updateRating',$params)
        ->assertSuccessful();
        $this->assertEquals(4.0,Rating::first()->pluck('rating')[0]);
    }

    public function test_get_for_moderator()
    {
        Review::create([
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        $response = $this->call('GET','api/getReviewsForModerator')
        ->assertSuccessful();
        $this->assertEquals(1,$response->decodeResponseJson()->count());
    }

    public function test_accept_review()
    {
        Review::create([
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        $params=[
            'id' =>1,
        ];
        $this->call('POST','api/acceptReview',$params)
        ->assertSuccessful();
        $this->assertNotNull(Review::first()->pluck('approved_at'));
    }


}

<?php

namespace Tests\Unit\Entities;

use App\Models\Like;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    protected $rating;

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() :void
    {
        parent::setUp();
        Review::create([
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        $this->rating = Rating::factory()->create(
           [ 'review_id' =>1]
        );
    }
    public function test_rating_has_review()
    {
        $this->assertInstanceOf(Review::class, $this->rating->review);
    }
}

<?php

namespace Tests\Unit\Entities;

use App\Models\Like;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    protected $review;

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() :void
    {
        parent::setUp();
        $this->review = Review::create([
            'id' =>1,
            'idFilm' => 'tt4372623',
            'idUser' => 1,
            'reviewText' => 'booo!',
            'filmTitle' => 'Inception'
        ]);
        Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
            'review_id' => 1
        ]);
        Rating::factory()->create([
            'review_id' =>1
        ]);
    }
    public function test_review_has_like()
    {
        $this->assertTrue($this->review->like->exists());
    }

    public function test_review_has_rating()
    {
        $this->assertTrue($this->review->rating->exists());
    }
}

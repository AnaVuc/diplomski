<?php

namespace Tests\Unit\Entities;

use App\Models\Like;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    protected $like;

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
        $this->like = Like::create([
            'idFilm' => 'tt123456',
            'idUser' => 1,
            'review_id' => 1
        ]);
    }
    public function test_like_has_review()
    {
        $this->assertInstanceOf(Review::class, $this->like->review);
    }
}

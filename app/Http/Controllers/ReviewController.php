<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Watch;
use DateTime;

class ReviewController extends Controller
{
    public function checkIfReviewed(){
        return Review::where('idFilm',request()->idFilm)->where('idUser',request()->idUser)->first();
    }

    public function saveReview(){

        $review=Review::create([
            'reviewText'=>request()->reviewText,
            'idFilm'=>request()->idFilm,
            'idUser'=>request()->idUser,
            'filmTitle'=>request()->filmTitle
        ]);
        

        $watch=Watch::create([
            'idUser'=>request()->idUser,
            'idFilm'=>request()->idFilm
        ]);
        $watch->save();


        if (request()->like){
            $like = Like::where('idFilm',request()->idFilm)->where('idUser',request()->idUser)->first();
            if ($like){
                $like->review_id = $review->id;
                $like->fresh();
            }
            else{
                $likeCreate=Like::create([
                    'idUser'=>request()->idUser,
                    'idFilm'=>request()->idFilm
                ]);
                $review->like()->save($likeCreate);
            }
        }

        if (request()->rating){
            $ratingCreate=Rating::create([
                'idUser'=>request()->idUser,
                'idFilm'=>request()->idFilm,
                'rating'=>request()->rating,
            ]);

            $review->rating()->save($ratingCreate);
        }

    }

    public function updateReview(){
        $idFilm=request()->idFilm;
        $idUser=request()->idUser;
        $reviewText=request()->reviewText;
        $filmTitle=request()->filmTitle;

        $attributes= request()->validate([
            'idFilm'=>'required',
            'idUser'=>'required',
            'reviewText'=>'required',
            'filmTitle'=>'required',
        ]);

        $r=Review::where('idFilm',$idFilm)->where('idUser',$idUser)->update($attributes);
        $r=$r->fresh();

        $film_controller=new FilmController;
        //check if like is updated
        $ifLiked=$film_controller->checkIfLiked($idFilm,$idUser);
        if (request()->like && $ifLiked->isEmpty()){
            $likeCreate=Like::create([
                'idUser'=>request()->idUser,
                'idFilm'=>request()->idFilm
            ]);
            $r->like()->save($likeCreate);
        }
        if (!request()->like && $ifLiked){
            $film_controller->deleteLike($idFilm,$idUser);
        }

        //rating
        $ratingForReview=Rating::where('review_id',$r->id)->first();
        // dd($ratingForReview,request()->rating);
        if ($ratingForReview && !request()->rating){
            $ratingForReview->delete();
        }

        if (!$ratingForReview && request()->rating){
            $film_controller->rateFilm($idFilm,$idUser,request()->rating);
        }
        if ($ratingForReview && request()->rating){
            $ratingForReview->rating=request()->rating;
            $ratingForReview->save();
        }

        return response()->json($r,201);

    }

    public function reviewHasLike(){
        return Like::where('review_id',request()->reviewId)->first();
    }

    public function reviewHasRating(){
        return Rating::where('review_id',request()->reviewId)->get();

    }

    public function delete(){
        $r= Review::where('idUser',request()->idUser)
                    ->where('idFilm',request()->idFilm)
                    ->first();
        $r->delete();

    }

    public function getForModerator(){
        return Review::where('approved_at',null)->get();
    }

    public function acceptReview(){
        $review=Review::where('id',request()->id)->first();
        $review->approved_at = new DateTime();
        $review->save();
    }

    public function getReviews(){
        return Review::where('idFilm',request()->idFilm)->whereNotNull('approved_at')->with('rating')->paginate(request()->numberForShowing);
    }

    public function reviewsForUser(){
        return Review::where('idUser',request()->user)->get();
    }
}

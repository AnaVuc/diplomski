<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Watch;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function likeFilm($idFilm=null,$idUser=null){

        $idFilm=request()->idFilm;
        $idUser=request()->$idUser;
        $liked=Like::where('idFilm',$idFilm)->where('idUser',$idUser)->first();
        if ($liked){
            return;
        }
        $data=request()->all();
        $model=new Like($data);

        $model->save();
    }

    public function deleteLike($idFilm=null,$idUser=null){

        $idFilm=request()->idFilm;
        $idUser=request()->idUser;
        $deleted=Like::where('idFilm',$idFilm)->where('idUser',$idUser)->delete();
        // dd($deleted);
        return response()->json([], 204);

    }

    public function watchFilm(){

        $liked=Watch::where('idFilm',request()->idFilm)->where('idUser',request()->idUser)->first();
        // dd($liked);
        if ($liked){
            return;
        }
        $data=request()->all();
        $model=new Watch($data);

        $model->save();
    }

    public function deleteWatch(){

        Watch::where('idFilm',request()->idFilm)->where('idUser',request()->idUser)->delete();
        return response()->json([], 204);

    }

    public function checkIfLiked($film=null,$user=null){
        $film=request()->idFilm;
        $user=request()->idUser;
        // dd('checkIfLiked',$film,$user);
        return Like::where('idFilm',$film)->where('idUser',$user)->get();
    }

    public function checkIfWatched(){
        $film=request()->idFilm;
        $user=request()->idUser;
        return Watch::where('idFilm',$film)->where('idUser',$user)->get();
    }

    public function myWatchedFilms(){
        $user=request()->user;
        return Watch::select('idFilm','created_at')->where('idUser',$user)->orderBy('created_at', 'desc')->get();
    }


    public function myLikedFilms(){
        $user=request()->user;
        return Like::where('idUser',$user)->pluck('idFilm')->all();
    }

    public function rateFilm($idFilm=null,$idUser=null,$rating=null){
        $idFilm=request()->idFilm;
        $idUser=request()->idUser;
        $rating=request()->rating;

        $validator= request()->validate([
            'idFilm'=>'required',
            'idUser'=>'required',
            'rating'=>'required',
        ]);

        $rating=Rating::create([
            'idFilm'=>request()->idFilm,
            'idUser'=>request()->idUser,
            'rating'=>request()->rating,
        ]);
    }

    public function calculateFilmRating(){
        $film=request()->idFilm;

        return Rating::where('idFilm',$film)->average('rating');
    }

    public function countFilmWatched(){
        $film=request()->idFilm;

        return Watch::where('idFilm',$film)->count();
    }


    public function countFilmLiked(){
        $film=request()->idFilm;

        return Like::where('idFilm',$film)->count();
    }

    public function getRating(){
        $film=request()->idFilm;
        $user=request()->idUser;

        return Rating::where('idFilm',$film)->where('idUser',$user)->pluck('rating');
    }

    public function updateRating(){
        $film=request()->idFilm;
        $user=request()->idUser;

        $attributes= request()->validate([
            'idFilm'=>'required',
            'idUser'=>'required',
            'rating'=>'required',
        ]);
        $r=Rating::where('idFilm',$film)->where('idUser',$user)->first();
        $r->update($attributes);
        $r=$r->fresh();
        return response()->json($r,201);
    }

    public function topRated(){
        return Rating::groupBy('idFilm')->orderBy('rating','desc')->limit(5)->pluck('idFilm');
    }

    public function statsForFilms(){
        $films=request()->films;

        foreach ($films as &$film){
            $film["numWatched"]=Watch::where('idFilm',$film["id"])->count();
            $film["numLiked"]=Like::where('idFilm',$film["id"])->count();
            $film["rating"]=Rating::where('idFilm',$film["id"])->average('rating')?? '/';
            info($film["numWatched"]);
        }
        return $films;
    }



}

<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//rate
Route::post('rateFilm',[FilmController::class,'rateFilm']);
Route::post('calculateFilmRating',[FilmController::class,'calculateFilmRating']);
Route::get('getRating',[FilmController::class,'getRating']);
Route::post('updateRating',[FilmController::class,'updateRating']);

//like
Route::post('likeFilm',[FilmController::class,'likeFilm']);
Route::post('deleteLike',[FilmController::class,'deleteLike']);
Route::post('checkIfLiked',[FilmController::class,'checkIfLiked']);
Route::post('myLikedFilms',[FilmController::class,'myLikedFilms']);
Route::post('countFilmLiked',[FilmController::class,'countFilmLiked']);



//watch
Route::post('watchFilm',[FilmController::class,'watchFilm']);
Route::post('deleteWatch',[FilmController::class,'deleteWatch']);
Route::post('checkIfWatched',[FilmController::class,'checkIfWatched']);
Route::post('myWatchedFilms',[FilmController::class,'myWatchedFilms']);
Route::post('countFilmWatched',[FilmController::class,'countFilmWatched']);

//user
Route::get('userByUsername',[ProfileController::class, 'findByUsername']);
Route::get('getUsers',[UserController::class, 'getUsers']);
Route::get('getRoles',[UserController::class, 'getRoles']);
Route::post('updateUser',[UserController::class, 'updateUser']);
Route::post('createUser',[UserController::class, 'createUser']);
Route::delete('deleteUser',[UserController::class, 'deleteUser']);

//review

Route::post('saveReview',[ReviewController::class,'saveReview']);
Route::post('updateReview',[ReviewController::class,'updateReview']);
Route::post('checkIfReviewed',[ReviewController::class,'checkIfReviewed']);
Route::post('reviewHasRating',[ReviewController::class,'reviewHasRating']);
Route::post('reviewHasLike',[ReviewController::class,'reviewHasLike']);
Route::post('deleteReview',[ReviewController::class,'delete']);
Route::get('getReviewsForModerator',[ReviewController::class,'getForModerator']);
Route::post('acceptReview',[ReviewController::class,'acceptReview']);
Route::post('getReviews',[ReviewController::class,'getReviews']);
Route::post('reviewsForUser',[ReviewController::class,'reviewsForUser']);

//index page
Route::get('topRatedMovies',[FilmController::class,'topRated']);
Route::post('getMovieById',[FilmController::class,'movieById']);
Route::post('statsForFilms',[FilmController::class,'statsForFilms']);

//permissions
Route::get('getPermissions',[UserController::class,'getPermissions']);
Route::post('updateRole',[UserController::class,'updateRole']);
Route::post('createRole',[UserController::class,'createRole']);
Route::delete('deleteRole',[UserController::class, 'deleteRole']);



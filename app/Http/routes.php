<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
   	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$host = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$database = substr($url["path"], 1);
   	echo $host."   => ".$username."   => ".$password."   => ".$database;
});


$app->get('login', 'AuthController@login');

$app->get('maker/get', ['uses' => 'AuthController@getMarker', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('maker/data/{id}', ['uses' => 'AuthController@getFirstMarker', 'middleware' => ['cors', 'jwt.auth']]);
$app->post('maker/add', ['uses' => 'AuthController@add', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('maker/data/{id}', ['uses' => 'AuthController@add', 'middleware' => ['cors', 'jwt.auth']]);
$app->put('maker/edit/{id}', ['uses' => 'AuthController@add', 'middleware' => ['cors', 'jwt.auth']]);
$app->delete('maker/hapus/{id}', ['uses' => 'AuthController@add', 'middleware' => ['cors', 'jwt.auth']]);










$app->get('profile', 'TestController@test');
$app->get('long', ['as' => 'long', 'uses' => 'TestController@long', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('detail', ['as' => 'long', 'uses' => 'TestController@detail', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('comments/place', ['uses' => 'CommentController@place', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('comments/community', ['uses' => 'CommentController@comunity', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('place/photo/all', ['uses' => 'PhotosController@placeAll', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('community/photo/all', ['uses' => 'PhotosController@communityAll', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('place/all', ['uses' => 'PlaceController@all', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('community/all', ['uses' => 'ComunityController@all', 'middleware' => ['cors', 'jwt.auth']]);
$app->get('insert', ['uses' => 'TestController@insertMarkers', 'middleware' => ['cors']]);
$app->post('place/checkin', ['uses' => 'PlaceController@checkin', 'middleware' => ['cors', 'jwt.auth']]);
$app->post('community/join', ['uses' => 'ComunityController@join', 'middleware' => ['cors', 'jwt.auth']]);








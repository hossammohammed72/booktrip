<?php

/** @var \Laravel\Lumen\Routing\Router $router */


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

$router->get('/cities',['as'=>'cities.index','uses'=>'CityController@index']);

$router->post('/trip',['as'=>'trip.store','uses'=>'TripController@store']);
$router->get('/trip/{id}',['as'=>'trip.show','uses'=>'TripController@show']);

$router->post('/ticket/book',['as'=>'trip.book','uses'=>'BookingController@book']);
$router->post('/ticket/cancel',['as'=>'trip.book','uses'=>'BookingController@cancel']);

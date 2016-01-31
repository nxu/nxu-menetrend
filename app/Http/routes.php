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

$app->get('/', 'MenetrendController@showHomepage');

$app->get('/menetrend', function() {
    return redirect('/');
});

$app->post('/menetrend', 'MenetrendController@postScheduleRequest');

$app->get('/api/v1/stations/{term}', 'MenetrendController@autocompleteStations');

$app->get('/api/v1/schedule', 'MenetrendController@getMenetrend');

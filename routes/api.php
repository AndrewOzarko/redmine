<?php

use Illuminate\Http\Request;

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

Route::post('login', 'Authentication\AuthenticationController@login');


Route::middleware('auth:api')->group(function () {

    Route::get('projects', 'Integration\IntegrationController@getAllProjects');
    Route::get('projects/{id}/issues', 'Integration\IntegrationController@getIssuesForProject');
    Route::post('track-time', 'Integration\IntegrationController@trackTime');
});

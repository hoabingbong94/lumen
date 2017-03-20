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

$app->get('/', function() use ($app) {
    return "Lumen RESTful API By CoderExample";
});
$app->group(['prefix' => 'api/v1'], function($app)
{
//    $app->get('/test',function (){
//        dd(1);
//    });
    $app->get('book','BookController@index');

    $app->get('book/{id}','BookController@getbook');

    $app->post('book','BookController@createBook');

    $app->put('book/{id}','BookController@updateBook');

    $app->delete('book/{id}','BookController@deleteBook');
});

$app->group(['prefix'=>'api/v2'],function ($app){
    //get uploads
    $app->post('uploads','UploadsController@uploads');
});
$app->group(['prefix'=>'backend'],function () use ($app)
{
    $app->get('index','PostController@index');
    $app->post('create','PostController@create');
    $app->post('update/{id}','PostController@update');
    $app->post('save','PostController@save');
});
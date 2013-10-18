<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index')->with('queues', RedisQueue::getAll());
});

Route::get('queue/{name}/{type?}', function($name, $type = 'queued')
{
	$items = RedisQueue::getItems($name, $type);

	return View::make('queue')->with('items', $items);
});

Route::group(array('prefix' => 'api'), function()
{

	Route::get('queue', function()
	{
		$redisQueue = new RedisQueue;
		$queues = $redisQueue->getQueues();

		return Response::json($queues);
	});

});
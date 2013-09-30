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
	$redisQueue = new RedisQueue;
	$queues = $redisQueue->getQueues();

	return View::make('layout')->nest('content', 'index', array('queues' => $queues));
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

Route::get('job', function()
{
	Queue::push(function($job)
	{
		echo "hi"; sleep(2);
		$job->delete();
	}, array(), 'test');
});

Route::get('{queue}/{type?}', 'HomeController@show');
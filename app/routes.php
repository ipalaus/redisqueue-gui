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
	$queues = RedisQueue::getAll();

	return View::make('index')->withQueues($queues);
});

Route::get('queue/{name}/{type}', function($name, $type)
{
	$items = RedisQueue::getItems($name, $type);
	$listType = RedisQueue::type("queues:{$name}:{$type}");

	// jobs are stored as json encoded, we will decode them to create our list
	$items = $items->map(function($item, $index) use ($listType)
	{
		$object = json_decode($item);

		$object->encoded = $item;
		$object->delete  = ($listType === 'list') ? $index : urlencode($item);

		return $object;
	});

	return View::make('queue')->with(['name' => $name, 'type' => $type, 'items' => $items]);
});

Route::get('queue/{name}/{type}/delete', function($name, $type)
{
	$value = Input::get('value');

	RedisQueue::remove("queues:{$name}:{$type}", $value);

	return Redirect::to("queue/{$name}/{$type}");
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
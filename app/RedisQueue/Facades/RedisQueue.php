<?php namespace RedisQueue\Facades;

use Illuminate\Support\Facades\Facade;

class RedisQueue extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'redisqueue'; }

}
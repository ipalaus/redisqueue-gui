<?php namespace RedisQueue;

use Illuminate\Redis\Database;
use Illuminate\Support\Collection;

class Repository {

	/**
	 * Redis connection.
	 *
	 * @var \Illuminate\Redis\Database
	 */
	protected $database;

	/**
	 * Default namespace where our queues are grouped.
	 *
	 * @var string
	 */
	protected $namespace = 'queues';

	/**
	 * Create a new RedisQueue repository.
	 *
	 * @param  \Illuminate\Redis\Database $database
	 * @return void
	 */
	public function __construct(Database $database)
	{
		$this->database = $database;
	}

	/**
	 * Fetch all the queues inside the 'queues' namespace with the delayed and
	 * reserved.
	 *
	 * @return \RedisQueue\Collection
	 */
	public function getAll()
	{
		$collection = new Collection();

		$keys = $this->database->keys($this->namespace.':*');

		foreach ($keys as $key)
		{
			list($namespace, $name) = explode(':', $key);

			if ( ! $collection->has($name))
			{
				$collection->put($name, $this->get($name));
			}
		}

		return $collection;
	}

	/**
	 * Get the items that a concrete queue contain.
	 *
	 * @param  string  $name
	 * @return array
	 */
	public function get($name)
	{
		$queued   = $this->database->llen($this->namespace.':'.$name);
		$delayed  = $this->database->zcard($this->namespace.':'.$name.':delayed');
		$reserved = $this->database->zcard($this->namespace.':'.$name.':reserved');

		return array('queued' => $queued, 'delayed' => $delayed, 'reserved' => $reserved);
	}

	public function getItems($name, $type)
	{
		$namespaced = $this->namespace.':'.$name;

		$key = ($type === 'queued') ? $namespaced : $namespaced.':'.$type;

		if ( ! $this->exists($key)) return new Collection();
	}

	public function exists($key)
	{
		return (bool) $this->database->exists($key);
	}

}
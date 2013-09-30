<?php

class RedisQueue
{

	protected $redis;

	public function __construct()
	{
		$this->redis = app('redis');
	}

	public function getQueues()
	{
		$queues = $this->getQueueNames();

		foreach ($queues as $name => $queue) {
			$queues[$name]['total'] = $this->redis->llen('queues:'.$name);

			foreach (array('delayed', 'reserved') as $option) {
				$queues[$name][$option]['total'] = $this->redis->zcard('queues:'.$name.':'.$option);
			}
		}

		return $queues;
	}

	public function getQueueNames()
	{
		$keys    = $this->redis->keys('queues:*');
		$names   = array();
		$default = array(
			'total'    => 0,
			'delayed'  => array('total' => 0),
			'failed'   => array('total' => 0),
			'reserved' => array('total' => 0),
		);

		foreach ($keys as $key) {
			$parts = explode(':', $key);
			$name  = $parts[1];

			// set the default if not previously added
			if ( ! isset($names[$name])) $names[$name] = $default;
		}

		return $names;
	}

}
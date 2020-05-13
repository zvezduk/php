<?php

namespace Api\Model;

/**
 * Class StatsModel
 *
 * @package Api\Model
 */
class StatsModel
{
    protected \Redis $redis;

    /**
     * StatsModel constructor.
     *
     * @param \Redis $redis
     */
    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param string $code
     *
     * @return int
     */
    public function set(string $code): int
    {
        return $this->redis->incr($code);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $values = [];

        foreach ($this->getKeys() as $key) {
            $values[$key] = (int)$this->redis->get($key);
        }

        return $values;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getKeys(): array
    {
        $keys = $this->redis->keys('*');

        if (empty($keys)) {
            throw new \Exception('empty');  // todo
        }

        return $keys;
    }
}

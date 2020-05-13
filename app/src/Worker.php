<?php

namespace Api;

use Api\Model\StatsModel;
use Redis;

/**
 * Class Worker
 *
 * @package Api
 */
class Worker
{
    protected const CHANNEL = 'stats';

    protected \Redis $redis;
    protected StatsModel $statsModel;

    /**
     * StatsModel constructor.
     *
     * @param \Redis     $redis
     * @param StatsModel $statsModel
     */
    public function __construct(\Redis $redis, StatsModel $statsModel = null)
    {
        $redis->setOption(Redis:: OPT_READ_TIMEOUT, -1);
        $this->redis = $redis;

        $this->statsModel = $statsModel ?? new StatsModel($redis);
    }

    /**
     * @param string $msg
     *
     * @return int
     */
    public function publish(string $msg): int
    {
        return $this->redis->publish(self::CHANNEL, $msg);
    }

    public function run(): void
    {
        $this->redis->subscribe(
            [self::CHANNEL],
            function (\Redis $redis, string $channel, string $msg) {
                $this->statsModel->set($msg);
            }
        );
    }
}

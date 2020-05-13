<?php

namespace Tests\Unit;

use Api\Worker;
use PHPUnit\Framework\TestCase;

/**
 * Class WorkerTest
 *
 * @package Tests\Unit
 */
class WorkerTest extends TestCase
{
    /**
     * @covers \Api\Worker::__construct
     */
    public function test__construct()
    {
        $redis = $this->createMock(\Redis::class);

        $this->assertInstanceOf(
            Worker::class,
            new Worker($redis)
        );
    }

    /**
     * @covers \Api\Worker::publish
     */
    public function testPublish()
    {
        $redis = $this->createMock(\Redis::class);

        $redis->expects($this->once())
            ->method('publish')
            ->with('stats', 'en')
            ->willReturn(1);

        $worker = new Worker($redis);

        $this->assertSame(
            1,
            $worker->publish('en')
        );
    }

    /**
     * @covers \Api\Worker::run
     */
    public function testRun()
    {
        $redis = $this->createMock(\Redis::class);

        $redis->expects($this->once())
            ->method('subscribe');

        (new Worker($redis))->run();

    }
}

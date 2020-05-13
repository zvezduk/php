<?php

namespace Tests\Unit\Model;

use Api\Model\StatsModel;
use PHPUnit\Framework\TestCase;

/**
 * Class StatsModelTest
 *
 * @package Tests\Unit\Model
 */
class StatsModelTest extends TestCase
{
    /**
     * @covers \Api\Model\StatsModel::__construct
     */
    public function test__construct()
    {
        $redis = $this->createMock(\Redis::class);

        $this->assertInstanceOf(
            StatsModel::class,
            new StatsModel($redis)
        );
    }

    /**
     * @covers \Api\Model\StatsModel::get
     * @covers \Api\Model\StatsModel::getKeys
     */
    public function testGetEmpty()
    {
        $redis = $this->createMock(\Redis::class);

        $redis->expects($this->once())
            ->method('keys')
            ->with('*')
            ->willReturn([]);

        $redis->expects($this->never())
            ->method('get');

        $this->expectException(\Exception::class);

        (new StatsModel($redis))->get();
    }

    /**
     * @covers \Api\Model\StatsModel::get
     * @covers \Api\Model\StatsModel::getKeys
     */
    public function testGet()
    {
        $redis = $this->createMock(\Redis::class);

        $redis->expects($this->once())
            ->method('keys')
            ->with('*')
            ->willReturn(
                [
                    'en',
                    'ru',
                ]
            );

        $redis->expects($this->exactly(2))
            ->method('get')
            ->withConsecutive(
                ['en'],
                ['ru']
            )
            ->willReturn(1, 2);

        $this->assertSame(
            [
                'en' => 1,
                'ru' => 2,
            ],
            (new StatsModel($redis))->get()
        );
    }

    /**
     * @covers \Api\Model\StatsModel::set
     */
    public function testSet()
    {
        $redis = $this->createMock(\Redis::class);

        $redis->expects($this->once())
            ->method('incr')
            ->with('en')
            ->willReturn(1);

        $this->assertSame(
            1,
            (new StatsModel($redis))->set('en')
        );
    }
}

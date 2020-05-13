<?php

namespace Tests\Unit\Http;

use Api\Http\StatsController;
use Api\Model\StatsModel;
use Api\Worker;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class StatsControllerTest
 *
 * @package Tests\Unit\Http
 */
class StatsControllerTest extends TestCase
{
    /**
     * @covers \Api\Http\StatsController::__construct
     */
    public function test__construct()
    {
        $statsModel = $this->createMock(StatsModel::class);
        $worker = $this->createMock(Worker::class);

        $this->assertInstanceOf(
            StatsController::class,
            new StatsController($statsModel, $worker)
        );
    }

    /**
     * @covers \Api\Http\StatsController::get
     */
    public function testGet()
    {
        $request = $this->createMock(Request::class);
        $statsModel = $this->createMock(StatsModel::class);
        $worker = $this->createMock(Worker::class);

        $statsModel->expects($this->once())
            ->method('get')
            ->willReturn(
                [
                    'en' => 1,
                    'ru' => 2,
                ]
            );

        $statsController = new StatsController($statsModel, $worker);

        $response = $statsController->get($request, new Response());

        $this->assertSame(
            200,
            $response->getStatusCode()
        );

        $this->assertSame(
            [
                'en' => 1,
                'ru' => 2,
            ],
            json_decode($response->getBody(), true)
        );
    }

    /**
     * @covers \Api\Http\StatsController::set
     */
    public function testSet()
    {
        $request = $this->createMock(Request::class);
        $statsModel = $this->createMock(StatsModel::class);
        $worker = $this->createMock(Worker::class);

        $worker->expects($this->once())
            ->method('publish')
            ->with('en');

        $statsController = new StatsController($statsModel, $worker);

        $response = $statsController->set(
            $request,
            new Response(),
            ['code' => 'en']
        );

        $this->assertSame(
            200,
            $response->getStatusCode()
        );
    }
}

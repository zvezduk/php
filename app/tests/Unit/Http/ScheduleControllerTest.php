<?php

namespace Tests\Unit\Http;

use Api\Http\ScheduleController;
use Api\Model\ScheduleImportModel;
use PHPUnit\Framework\TestCase;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

/**
 * Class ScheduleControllerTest
 *
 * @package Tests\Unit\Http
 */
class ScheduleControllerTest extends TestCase
{
    /**
     * @covers \Api\Http\ScheduleController::__construct
     */
    public function test__construct()
    {
        $container = $this->createMock(Container::class);

        $this->assertInstanceOf(
            ScheduleController::class,
            new ScheduleController($container)
        );

        $this->assertInstanceOf(
            ScheduleController::class,
            new ScheduleController(
                $container,
                $this->createMock(ScheduleImportModel::class)
            )
        );
    }

    /**
     * @covers \Api\Http\ScheduleController::uploadFile
     */
    public function testUploadFile()
    {
        $container = $this->createMock(Container::class);

        $scheduleImportModel = $this->createMock(ScheduleImportModel::class);

        $scheduleImportModel->expects($this->once())
            ->method('import')
            ->with('xls');

        $scheduleController = new ScheduleController(
            $container,
            $scheduleImportModel
        );

        $request = $this->createMock(Request::class);

        $file = $this->createMock(UploadedFile::class);
        $file->file = 'xls';

        $request->expects($this->once())
            ->method('getUploadedFiles')
            ->willReturn(
                [
                    'file' => $file,
                ]
            );

        $this->assertSame(
            200,
            $scheduleController->uploadFile($request, new Response())
                ->getStatusCode()
        );
    }
}

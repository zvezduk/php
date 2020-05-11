<?php

namespace Api\Http;

use Api\Model\ScheduleImportModel;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use Slim\Http\UploadedFile;

/**
 * Class ScheduleController
 *
 * @package Api\Http
 */
class ScheduleController
{
    protected Container $container;
    protected ScheduleImportModel $scheduleImportModel;

    /**
     * ScheduleController constructor.
     *
     * @param Container           $container
     * @param ScheduleImportModel $scheduleImportModel
     */
    public function __construct(Container $container, ScheduleImportModel $scheduleImportModel = null)
    {
        $this->container = $container;
        $this->scheduleImportModel = $scheduleImportModel ?? new ScheduleImportModel();
    }

    /**
     * Импорт расписания
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function uploadFile(Request $request, Response $response): Response
    {
        if ($files = $request->getUploadedFiles()) {
            /** @var UploadedFile $file */
            $file = $files['file'];

            $this->scheduleImportModel->import($file->file);
        }

        return $response->withStatus(StatusCode::HTTP_OK);
    }
}

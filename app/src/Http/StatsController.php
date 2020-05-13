<?php

namespace Api\Http;

use Api\Model\StatsModel;
use Api\Worker;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class StatsController
 *
 * @package Api\Http
 */
class StatsController
{
    protected StatsModel $statsModel;
    protected Worker $worker;

    /**
     * StatsController constructor.
     *
     * @param StatsModel $statsModel
     * @param Worker     $worker
     */
    public function __construct(StatsModel $statsModel, Worker $worker)
    {
        $this->statsModel = $statsModel;
        $this->worker = $worker;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function set(Request $request, Response $response, array $args): Response
    {
        $this->worker->publish($args['code']);

        return $response->withStatus(StatusCode::HTTP_OK);
    }

    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function get(Request $request, Response $response): Response
    {
        return $response->withJson(
            $this->statsModel->get()
        );
    }
}

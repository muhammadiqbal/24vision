<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRouteAPIRequest;
use App\Http\Requests\API\UpdateRouteAPIRequest;
use App\Models\Route;
use App\Repositories\RouteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class RouteController
 * @package App\Http\Controllers\API
 */

class RouteAPIController extends AppBaseController
{
    /** @var  RouteRepository */
    private $routeRepository;

    public function __construct(RouteRepository $routeRepo)
    {
        $this->routeRepository = $routeRepo;
    }

    /**
     * Display a listing of the Route.
     * GET|HEAD /routes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->routeRepository->pushCriteria(new RequestCriteria($request));
        $this->routeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $routes = $this->routeRepository->all();

        return $this->sendResponse($routes->toArray(), 'Routes retrieved successfully');
    }

    /**
     * Store a newly created Route in storage.
     * POST /routes
     *
     * @param CreateRouteAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRouteAPIRequest $request)
    {
        $input = $request->all();

        $routes = $this->routeRepository->create($input);

        return $this->sendResponse($routes->toArray(), 'Route saved successfully');
    }

    /**
     * Display the specified Route.
     * GET|HEAD /routes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Route $route */
        $route = $this->routeRepository->findWithoutFail($id);

        if (empty($route)) {
            return $this->sendError('Route not found');
        }

        return $this->sendResponse($route->toArray(), 'Route retrieved successfully');
    }

    /**
     * Update the specified Route in storage.
     * PUT/PATCH /routes/{id}
     *
     * @param  int $id
     * @param UpdateRouteAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRouteAPIRequest $request)
    {
        $input = $request->all();

        /** @var Route $route */
        $route = $this->routeRepository->findWithoutFail($id);

        if (empty($route)) {
            return $this->sendError('Route not found');
        }

        $route = $this->routeRepository->update($input, $id);

        return $this->sendResponse($route->toArray(), 'Route updated successfully');
    }

    /**
     * Remove the specified Route from storage.
     * DELETE /routes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Route $route */
        $route = $this->routeRepository->findWithoutFail($id);

        if (empty($route)) {
            return $this->sendError('Route not found');
        }

        $route->delete();

        return $this->sendResponse($id, 'Route deleted successfully');
    }
}

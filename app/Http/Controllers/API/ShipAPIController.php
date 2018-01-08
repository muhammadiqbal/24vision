<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateShipAPIRequest;
use App\Http\Requests\API\UpdateShipAPIRequest;
use App\Models\Ship;
use App\Repositories\ShipRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ShipController
 * @package App\Http\Controllers\API
 */

class ShipAPIController extends AppBaseController
{
    /** @var  ShipRepository */
    private $shipRepository;

    public function __construct(ShipRepository $shipRepo)
    {
        $this->shipRepository = $shipRepo;
    }

    /**
     * Display a listing of the Ship.
     * GET|HEAD /ships
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shipRepository->pushCriteria(new RequestCriteria($request));
        $this->shipRepository->pushCriteria(new LimitOffsetCriteria($request));
        $ships = $this->shipRepository->all();

        return $this->sendResponse($ships->toArray(), 'Ships retrieved successfully');
    }

    /**
     * Store a newly created Ship in storage.
     * POST /ships
     *
     * @param CreateShipAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateShipAPIRequest $request)
    {
        $input = $request->all();

        $ships = $this->shipRepository->create($input);

        return $this->sendResponse($ships->toArray(), 'Ship saved successfully');
    }

    /**
     * Display the specified Ship.
     * GET|HEAD /ships/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Ship $ship */
        $ship = $this->shipRepository->findWithoutFail($id);

        if (empty($ship)) {
            return $this->sendError('Ship not found');
        }

        return $this->sendResponse($ship->toArray(), 'Ship retrieved successfully');
    }

    /**
     * Update the specified Ship in storage.
     * PUT/PATCH /ships/{id}
     *
     * @param  int $id
     * @param UpdateShipAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShipAPIRequest $request)
    {
        $input = $request->all();

        /** @var Ship $ship */
        $ship = $this->shipRepository->findWithoutFail($id);

        if (empty($ship)) {
            return $this->sendError('Ship not found');
        }

        $ship = $this->shipRepository->update($input, $id);

        return $this->sendResponse($ship->toArray(), 'Ship updated successfully');
    }

    /**
     * Remove the specified Ship from storage.
     * DELETE /ships/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Ship $ship */
        $ship = $this->shipRepository->findWithoutFail($id);

        if (empty($ship)) {
            return $this->sendError('Ship not found');
        }

        $ship->delete();

        return $this->sendResponse($id, 'Ship deleted successfully');
    }
}

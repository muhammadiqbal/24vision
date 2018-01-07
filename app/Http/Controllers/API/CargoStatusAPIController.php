<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCargoStatusAPIRequest;
use App\Http\Requests\API\UpdateCargoStatusAPIRequest;
use App\Models\CargoStatus;
use App\Repositories\CargoStatusRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CargoStatusController
 * @package App\Http\Controllers\API
 */

class CargoStatusAPIController extends AppBaseController
{
    /** @var  CargoStatusRepository */
    private $cargoStatusRepository;

    public function __construct(CargoStatusRepository $cargoStatusRepo)
    {
        $this->cargoStatusRepository = $cargoStatusRepo;
    }

    /**
     * Display a listing of the CargoStatus.
     * GET|HEAD /cargoStatuses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->cargoStatusRepository->pushCriteria(new RequestCriteria($request));
        $this->cargoStatusRepository->pushCriteria(new LimitOffsetCriteria($request));
        $cargoStatuses = $this->cargoStatusRepository->all();

        return $this->sendResponse($cargoStatuses->toArray(), 'Cargo Statuses retrieved successfully');
    }

    /**
     * Store a newly created CargoStatus in storage.
     * POST /cargoStatuses
     *
     * @param CreateCargoStatusAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCargoStatusAPIRequest $request)
    {
        $input = $request->all();

        $cargoStatuses = $this->cargoStatusRepository->create($input);

        return $this->sendResponse($cargoStatuses->toArray(), 'Cargo Status saved successfully');
    }

    /**
     * Display the specified CargoStatus.
     * GET|HEAD /cargoStatuses/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CargoStatus $cargoStatus */
        $cargoStatus = $this->cargoStatusRepository->findWithoutFail($id);

        if (empty($cargoStatus)) {
            return $this->sendError('Cargo Status not found');
        }

        return $this->sendResponse($cargoStatus->toArray(), 'Cargo Status retrieved successfully');
    }

    /**
     * Update the specified CargoStatus in storage.
     * PUT/PATCH /cargoStatuses/{id}
     *
     * @param  int $id
     * @param UpdateCargoStatusAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCargoStatusAPIRequest $request)
    {
        $input = $request->all();

        /** @var CargoStatus $cargoStatus */
        $cargoStatus = $this->cargoStatusRepository->findWithoutFail($id);

        if (empty($cargoStatus)) {
            return $this->sendError('Cargo Status not found');
        }

        $cargoStatus = $this->cargoStatusRepository->update($input, $id);

        return $this->sendResponse($cargoStatus->toArray(), 'CargoStatus updated successfully');
    }

    /**
     * Remove the specified CargoStatus from storage.
     * DELETE /cargoStatuses/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CargoStatus $cargoStatus */
        $cargoStatus = $this->cargoStatusRepository->findWithoutFail($id);

        if (empty($cargoStatus)) {
            return $this->sendError('Cargo Status not found');
        }

        $cargoStatus->delete();

        return $this->sendResponse($id, 'Cargo Status deleted successfully');
    }
}

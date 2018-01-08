<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCargoAPIRequest;
use App\Http\Requests\API\UpdateCargoAPIRequest;
use App\Models\Cargo;
use App\Repositories\CargoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CargoController
 * @package App\Http\Controllers\API
 */

class CargoAPIController extends AppBaseController
{
    /** @var  CargoRepository */
    private $cargoRepository;

    public function __construct(CargoRepository $cargoRepo)
    {
        $this->cargoRepository = $cargoRepo;
    }

    /**
     * Display a listing of the Cargo.
     * GET|HEAD /cargos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->cargoRepository->pushCriteria(new RequestCriteria($request));
        $this->cargoRepository->pushCriteria(new LimitOffsetCriteria($request));
        $cargos = $this->cargoRepository->all();

        return $this->sendResponse($cargos->toArray(), 'Cargos retrieved successfully');
    }

    /**
     * Store a newly created Cargo in storage.
     * POST /cargos
     *
     * @param CreateCargoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCargoAPIRequest $request)
    {
        $input = $request->all();

        $cargos = $this->cargoRepository->create($input);

        return $this->sendResponse($cargos->toArray(), 'Cargo saved successfully');
    }

    /**
     * Display the specified Cargo.
     * GET|HEAD /cargos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Cargo $cargo */
        $cargo = $this->cargoRepository->findWithoutFail($id);

        if (empty($cargo)) {
            return $this->sendError('Cargo not found');
        }

        return $this->sendResponse($cargo->toArray(), 'Cargo retrieved successfully');
    }

    /**
     * Update the specified Cargo in storage.
     * PUT/PATCH /cargos/{id}
     *
     * @param  int $id
     * @param UpdateCargoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCargoAPIRequest $request)
    {
        $input = $request->all();

        /** @var Cargo $cargo */
        $cargo = $this->cargoRepository->findWithoutFail($id);

        if (empty($cargo)) {
            return $this->sendError('Cargo not found');
        }

        $cargo = $this->cargoRepository->update($input, $id);

        return $this->sendResponse($cargo->toArray(), 'Cargo updated successfully');
    }

    /**
     * Remove the specified Cargo from storage.
     * DELETE /cargos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Cargo $cargo */
        $cargo = $this->cargoRepository->findWithoutFail($id);

        if (empty($cargo)) {
            return $this->sendError('Cargo not found');
        }

        $cargo->delete();

        return $this->sendResponse($id, 'Cargo deleted successfully');
    }
}

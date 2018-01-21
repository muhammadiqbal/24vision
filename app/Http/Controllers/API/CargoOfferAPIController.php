<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCargoOfferAPIRequest;
use App\Http\Requests\API\UpdateCargoOfferAPIRequest;
use App\Models\CargoOffer;
use App\Repositories\CargoOfferRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CargoOfferController
 * @package App\Http\Controllers\API
 */

class CargoOfferAPIController extends AppBaseController
{
    /** @var  CargoOfferRepository */
    private $cargoOfferRepository;

    public function __construct(CargoOfferRepository $cargoOfferRepo)
    {
        $this->cargoOfferRepository = $cargoOfferRepo;
    }

    /**
     * Display a listing of the CargoOffer.
     * GET|HEAD /cargoOfferes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->cargoOfferRepository->pushCriteria(new RequestCriteria($request));
        $this->cargoOfferRepository->pushCriteria(new LimitOffsetCriteria($request));
        $cargoOfferes = $this->cargoOfferRepository->all();

        return $this->sendResponse($cargoOfferes->toArray(), 'Cargo Offeres retrieved successfully');
    }

    /**
     * Store a newly created CargoOffer in storage.
     * POST /cargoOfferes
     *
     * @param CreateCargoOfferAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCargoOfferAPIRequest $request)
    {
        $input = $request->all();

        $cargoOfferes = $this->cargoOfferRepository->create($input);

        return $this->sendResponse($cargoOfferes->toArray(), 'Cargo Offer saved successfully');
    }

    /**
     * Display the specified CargoOffer.
     * GET|HEAD /cargoOfferes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CargoOffer $cargoOffer */
        $cargoOffer = $this->cargoOfferRepository->findWithoutFail($id);

        if (empty($cargoOffer)) {
            return $this->sendError('Cargo Offer not found');
        }

        return $this->sendResponse($cargoOffer->toArray(), 'Cargo Offer retrieved successfully');
    }

    /**
     * Update the specified CargoOffer in storage.
     * PUT/PATCH /cargoOfferes/{id}
     *
     * @param  int $id
     * @param UpdateCargoOfferAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCargoOfferAPIRequest $request)
    {
        $input = $request->all();

        /** @var CargoOffer $cargoOffer */
        $cargoOffer = $this->cargoOfferRepository->findWithoutFail($id);

        if (empty($cargoOffer)) {
            return $this->sendError('Cargo Offer not found');
        }

        $cargoOffer = $this->cargoOfferRepository->update($input, $id);

        return $this->sendResponse($cargoOffer->toArray(), 'CargoOffer updated successfully');
    }

    /**
     * Remove the specified CargoOffer from storage.
     * DELETE /cargoOfferes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CargoOffer $cargoOffer */
        $cargoOffer = $this->cargoOfferRepository->findWithoutFail($id);

        if (empty($cargoOffer)) {
            return $this->sendError('Cargo Offer not found');
        }

        $cargoOffer->delete();

        return $this->sendResponse($id, 'Cargo Offer deleted successfully');
    }
}

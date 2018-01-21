<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateShipOfferExtractedAPIRequest;
use App\Http\Requests\API\UpdateShipOfferExtractedAPIRequest;
use App\Models\ShipOfferExtrcted;
use App\Repositories\ShipOfferExtractedRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ShipOfferController
 * @package App\Http\Controllers\API
 */

class ShipOfferExtractedAPIController extends AppBaseController
{
    /** @var  ShipOfferRepository */
    private $shipOfferExtractedRepository;

    public function __construct(ShipOfferExtractedRepository $shipOfferExtractedRepo)
    {
        $this->shipOfferExtractedRepository = $shipOfferExtractedRepo;
    }

    /**
     * Display a listing of the ShipOffer.
     * GET|HEAD /shipOfferes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shipOfferExtractedRepository->pushCriteria(new RequestCriteria($request));
        $this->shipOfferExtractedRepository->pushCriteria(new LimitOffsetCriteria($request));
        $shipOffersExtracted = $this->shipOfferExtractedRepository->all();

        return $this->sendResponse($shipOffersExtracted->toArray(), 'Ship Offeres retrieved successfully');
    }

    /**
     * Store a newly created ShipOffer in storage.
     * POST /shipOfferes
     *
     * @param CreateShipOfferExtractedAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateShipOfferExtractedAPIRequest $request)
    {
        $input = $request->all();

        $shipOffersExtracted = $this->shipOfferExtractedRepository->create($input);

        return $this->sendResponse($shipOffersExtracted->toArray(), 'Ship Offer saved successfully');
    }

    /**
     * Display the specified ShipOffer.
     * GET|HEAD /shipOfferes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ShipOffer $shipOffer */
        $shipOfferExtracted = $this->shipOfferExtractedRepository->findWithoutFail($id);

        if (empty($shipOfferExtracted)) {
            return $this->sendError('Ship Offer not found');
        }

        return $this->sendResponse($shipOfferExtracted->toArray(), 'Ship Offer retrieved successfully');
    }

    /**
     * Update the specified ShipOffer in storage.
     * PUT/PATCH /shipOfferes/{id}
     *
     * @param  int $id
     * @param UpdateShipOfferAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShipOfferExtractedAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShipOffer $shipOffer */
        $shipOfferExtracted = $this->shipOfferExtractedRepository->findWithoutFail($id);

        if (empty($shipOfferExtracted)) {
            return $this->sendError('Ship Offer Extracted not found');
        }

        $shipOfferExtracted = $this->shipOfferExtractedRepository->update($input, $id);

        return $this->sendResponse($shipOfferExtracted->toArray(), 'ShipOffer updated successfully');
    }

    /**
     * Remove the specified ShipOffer from storage.
     * DELETE /shipOfferes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ShipOffer $shipOffer */
        $shipOfferExtracted = $this->shipOfferExtractedRepository->findWithoutFail($id);

        if (empty($shipOfferExtracted)) {
            return $this->sendError('Ship Offer Extracted not found');
        }

        $shipOfferExtracted->delete();

        return $this->sendResponse($id, 'Ship Offer Extracted deleted successfully');
    }
}

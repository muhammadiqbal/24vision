<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateShipOfferAPIRequest;
use App\Http\Requests\API\UpdateShipOfferAPIRequest;
use App\Models\ShipOffer;
use App\Repositories\ShipOfferRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ShipOfferController
 * @package App\Http\Controllers\API
 */

class ShipOfferAPIController extends AppBaseController
{
    /** @var  ShipOfferRepository */
    private $shipOfferRepository;

    public function __construct(ShipOfferRepository $shipOfferRepo)
    {
        $this->shipOfferRepository = $shipOfferRepo;
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
        $this->shipOfferRepository->pushCriteria(new RequestCriteria($request));
        $this->shipOfferRepository->pushCriteria(new LimitOffsetCriteria($request));
        $shipOffers = $this->shipOfferRepository->all();

        return $this->sendResponse($shipOffers->toArray(), 'Ship Offeres retrieved successfully');
    }

    /**
     * Store a newly created ShipOffer in storage.
     * POST /shipOfferes
     *
     * @param CreateShipOfferAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateShipOfferAPIRequest $request)
    {
        $input = $request->all();

        $shipOffer = $this->shipOfferRepository->create($input);

        return $this->sendResponse($shipOffer->toArray(), 'Ship Offer saved successfully');
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
        $shipOffer = $this->shipOfferRepository->findWithoutFail($id);

        if (empty($shipOffer)) {
            return $this->sendError('Ship Offer not found');
        }

        return $this->sendResponse($shipOffer->toArray(), 'Ship Offer retrieved successfully');
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
    public function update($id, UpdateShipOfferAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShipOffer $shipOffer */
        $shipOffer = $this->shipOfferRepository->findWithoutFail($id);

        if (empty($shipOffer)) {
            return $this->sendError('Ship Offer not found');
        }

        $shipOffer = $this->shipOfferRepository->update($input, $id);

        return $this->sendResponse($shipOffer->toArray(), 'ShipOffer updated successfully');
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
        $shipOffer = $this->shipOfferRepository->findWithoutFail($id);

        if (empty($shipOffer)) {
            return $this->sendError('Ship Offer not found');
        }

        $shipOffer->delete();

        return $this->sendResponse($id, 'Ship Offer deleted successfully');
    }
}

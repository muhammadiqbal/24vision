<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCargoOfferExtractedAPIRequest;
use App\Http\Requests\API\UpdateCargoOfferExtractedAPIRequest;
use App\Models\CargoOfferExtracted;
use App\Repositories\CargoOfferExtractedRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

/**
 * Class CargoOfferController
 * @package App\Http\Controllers\API
 */

class CargoOfferExtractedAPIController extends AppBaseController
{
    /** @var  CargoOfferRepository */
    private $cargoOfferExtractedRepository;

    public function __construct(CargoOfferExtractedRepository $cargoOfferExtractedRepo)
    {
        $this->cargoOfferExtractedRepository = $cargoOfferExtractedRepo;
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
        $this->cargoOfferExtractedRepository->pushCriteria(new RequestCriteria($request));
        $this->cargoOfferExtractedRepository->pushCriteria(new LimitOffsetCriteria($request));
        $cargoOffersExtracted = $this->cargoOfferExtractedRepository->all();

        return $this->sendResponse($cargoOffersExtracted->toArray(), 'Cargo Offers retrieved successfully');
    }

    /**
     * Store a newly created CargoOffer in storage.
     * POST /cargoOfferes
     *
     * @param CreateCargoOfferExtractedAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCargoOfferExtractedAPIRequest $request)
    {
        $input = $request->all();

        //$cargoOffersExtracted = $this->cargoOfferExtractedRepository->create($input);

        $cargoOfferExtracted = new CargoOfferExtracted;
        $cargoOfferExtracted->fill($input);
        $cargoOfferExtracted->cargo_offer_extracted_ID = $request->input("cargo_offer_extracted_ID");
        $cargoOfferExtracted->emailID = $request->input("emailID");
        $cargoOfferExtracted->cargo_offerID = $request->input("cargo_offerID");
        $cargoOfferExtracted->cargo = $request->input("cargo");
        $cargoOfferExtracted->load_place = $request->input("load_place");
        $cargoOfferExtracted->disch_place = $request->input("disch_place");
        $cargoOfferExtracted->laycan = $request->input("laycan");
        $cargoOfferExtracted->terms = $request->input("terms");
        $cargoOfferExtracted->commission = $request->input("commission");
        $cargoOfferExtracted->kibana_extracted = $request->input("kibana_extracted");
        $cargoOfferExtracted->load_place_lat = $request->input("load_place_lat");
        $cargoOfferExtracted->load_place_lon = $request->input("load_place_lon");
        $cargoOfferExtracted->disch_place_lat = $request->input("disch_place_lat");
        $cargoOfferExtracted->disch_place_lon = $request->input("disch_place_lon");
        $cargoOfferExtracted->_created_on = $request->input("_created_on");
        $cargoOfferExtracted->save(); 
        return $this->sendResponse($cargoOfferExtracted->toArray(), 'Cargo Offer saved successfully');
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
        $cargoOfferExtracted = $this->cargoOfferExtractedRepository->findWithoutFail($id);

        if (empty($cargoOfferExtracted)) {
            return $this->sendError('Cargo Offer not found');
        }

        return $this->sendResponse($cargoOfferExtracted->toArray(), 'Cargo Offer retrieved successfully');
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
    public function update($id, UpdateCargoOfferExtractedAPIRequest $request)
    {
        $input = $request->all();

        /** @var CargoOffer $cargoOffer */
        $cargoOfferExtracted = $this->cargoOfferExtractedRepository->findWithoutFail($id);

        if (empty($cargoOfferExtracted)) {
            return $this->sendError('Cargo Offer Extracted not found');
        }

        $cargoOfferExtracted = $this->cargoOfferExtractedRepository->update($input, $id);

        return $this->sendResponse($cargoOfferExtracted->toArray(), 'CargoOffer updated successfully');
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
        $cargoOfferExtracted = $this->cargoOfferExtractedRepository->findWithoutFail($id);

        if (empty($cargoOfferExtracted)) {
            return $this->sendError('Cargo Offer Extracted not found');
        }

        $cargoOfferExtracted->delete();

        return $this->sendResponse($id, 'Cargo Offer Extracted deleted successfully');
    }
}

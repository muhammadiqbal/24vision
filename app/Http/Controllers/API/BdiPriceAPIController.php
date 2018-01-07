<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBdiPriceAPIRequest;
use App\Http\Requests\API\UpdateBdiPriceAPIRequest;
use App\Models\BdiPrice;
use App\Repositories\BdiPriceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BdiPriceController
 * @package App\Http\Controllers\API
 */

class BdiPriceAPIController extends AppBaseController
{
    /** @var  BdiPriceRepository */
    private $bdiPriceRepository;

    public function __construct(BdiPriceRepository $bdiPriceRepo)
    {
        $this->bdiPriceRepository = $bdiPriceRepo;
    }

    /**
     * Display a listing of the BdiPrice.
     * GET|HEAD /bdiPrices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->bdiPriceRepository->pushCriteria(new RequestCriteria($request));
        $this->bdiPriceRepository->pushCriteria(new LimitOffsetCriteria($request));
        $bdiPrices = $this->bdiPriceRepository->all();

        return $this->sendResponse($bdiPrices->toArray(), 'Bdi Prices retrieved successfully');
    }

    /**
     * Store a newly created BdiPrice in storage.
     * POST /bdiPrices
     *
     * @param CreateBdiPriceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBdiPriceAPIRequest $request)
    {
        $input = $request->all();

        $bdiPrices = $this->bdiPriceRepository->create($input);

        return $this->sendResponse($bdiPrices->toArray(), 'Bdi Price saved successfully');
    }

    /**
     * Display the specified BdiPrice.
     * GET|HEAD /bdiPrices/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var BdiPrice $bdiPrice */
        $bdiPrice = $this->bdiPriceRepository->findWithoutFail($id);

        if (empty($bdiPrice)) {
            return $this->sendError('Bdi Price not found');
        }

        return $this->sendResponse($bdiPrice->toArray(), 'Bdi Price retrieved successfully');
    }

    /**
     * Update the specified BdiPrice in storage.
     * PUT/PATCH /bdiPrices/{id}
     *
     * @param  int $id
     * @param UpdateBdiPriceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBdiPriceAPIRequest $request)
    {
        $input = $request->all();

        /** @var BdiPrice $bdiPrice */
        $bdiPrice = $this->bdiPriceRepository->findWithoutFail($id);

        if (empty($bdiPrice)) {
            return $this->sendError('Bdi Price not found');
        }

        $bdiPrice = $this->bdiPriceRepository->update($input, $id);

        return $this->sendResponse($bdiPrice->toArray(), 'BdiPrice updated successfully');
    }

    /**
     * Remove the specified BdiPrice from storage.
     * DELETE /bdiPrices/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var BdiPrice $bdiPrice */
        $bdiPrice = $this->bdiPriceRepository->findWithoutFail($id);

        if (empty($bdiPrice)) {
            return $this->sendError('Bdi Price not found');
        }

        $bdiPrice->delete();

        return $this->sendResponse($id, 'Bdi Price deleted successfully');
    }
}

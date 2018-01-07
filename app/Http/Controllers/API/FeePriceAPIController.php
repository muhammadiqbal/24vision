<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFeePriceAPIRequest;
use App\Http\Requests\API\UpdateFeePriceAPIRequest;
use App\Models\FeePrice;
use App\Repositories\FeePriceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class FeePriceController
 * @package App\Http\Controllers\API
 */

class FeePriceAPIController extends AppBaseController
{
    /** @var  FeePriceRepository */
    private $feePriceRepository;

    public function __construct(FeePriceRepository $feePriceRepo)
    {
        $this->feePriceRepository = $feePriceRepo;
    }

    /**
     * Display a listing of the FeePrice.
     * GET|HEAD /feePrices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->feePriceRepository->pushCriteria(new RequestCriteria($request));
        $this->feePriceRepository->pushCriteria(new LimitOffsetCriteria($request));
        $feePrices = $this->feePriceRepository->all();

        return $this->sendResponse($feePrices->toArray(), 'Fee Prices retrieved successfully');
    }

    /**
     * Store a newly created FeePrice in storage.
     * POST /feePrices
     *
     * @param CreateFeePriceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFeePriceAPIRequest $request)
    {
        $input = $request->all();

        $feePrices = $this->feePriceRepository->create($input);

        return $this->sendResponse($feePrices->toArray(), 'Fee Price saved successfully');
    }

    /**
     * Display the specified FeePrice.
     * GET|HEAD /feePrices/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FeePrice $feePrice */
        $feePrice = $this->feePriceRepository->findWithoutFail($id);

        if (empty($feePrice)) {
            return $this->sendError('Fee Price not found');
        }

        return $this->sendResponse($feePrice->toArray(), 'Fee Price retrieved successfully');
    }

    /**
     * Update the specified FeePrice in storage.
     * PUT/PATCH /feePrices/{id}
     *
     * @param  int $id
     * @param UpdateFeePriceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFeePriceAPIRequest $request)
    {
        $input = $request->all();

        /** @var FeePrice $feePrice */
        $feePrice = $this->feePriceRepository->findWithoutFail($id);

        if (empty($feePrice)) {
            return $this->sendError('Fee Price not found');
        }

        $feePrice = $this->feePriceRepository->update($input, $id);

        return $this->sendResponse($feePrice->toArray(), 'FeePrice updated successfully');
    }

    /**
     * Remove the specified FeePrice from storage.
     * DELETE /feePrices/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FeePrice $feePrice */
        $feePrice = $this->feePriceRepository->findWithoutFail($id);

        if (empty($feePrice)) {
            return $this->sendError('Fee Price not found');
        }

        $feePrice->delete();

        return $this->sendResponse($id, 'Fee Price deleted successfully');
    }
}

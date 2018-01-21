<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateShipOrderExtractedAPIRequest;
use App\Http\Requests\API\UpdateShipOrderExtractedAPIRequest;
use App\Models\ShipOrderExtrcted;
use App\Repositories\ShipOrderExtractedRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ShipOrderController
 * @package App\Http\Controllers\API
 */

class ShipOrderExtractedAPIController extends AppBaseController
{
    /** @var  ShipOrderRepository */
    private $shipOrderExtractedRepository;

    public function __construct(ShipOrderExtractedRepository $shipOrderRepo)
    {
        $this->shipOrderExtractedRepository = $shipOrderExtractedRepo;
    }

    /**
     * Display a listing of the ShipOrder.
     * GET|HEAD /shipOrderes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shipOrderExtractedRepository->pushCriteria(new RequestCriteria($request));
        $this->shipOrderExtractedRepository->pushCriteria(new LimitOffsetCriteria($request));
        $shipOrdersExtracted = $this->shipOrderExtractedRepository->all();

        return $this->sendResponse($shipOrdersExtracted->toArray(), 'Ship Orderes retrieved successfully');
    }

    /**
     * Store a newly created ShipOrder in storage.
     * POST /shipOrderes
     *
     * @param CreateShipOrderExtractedAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateShipOrderExtractedAPIRequest $request)
    {
        $input = $request->all();

        $shipOrdersExtracted = $this->shipOrderExtractedRepository->create($input);

        return $this->sendResponse($shipOrdersExtracted->toArray(), 'Ship Order saved successfully');
    }

    /**
     * Display the specified ShipOrder.
     * GET|HEAD /shipOrderes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ShipOrder $shipOrder */
        $shipOrderExtracted = $this->shipOrderExtractedRepository->findWithoutFail($id);

        if (empty($shipOrderExtracted)) {
            return $this->sendError('Ship Order not found');
        }

        return $this->sendResponse($shipOrderExtracted->toArray(), 'Ship Order retrieved successfully');
    }

    /**
     * Update the specified ShipOrder in storage.
     * PUT/PATCH /shipOrderes/{id}
     *
     * @param  int $id
     * @param UpdateShipOrderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShipOrderExtractedAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShipOrder $shipOrder */
        $shipOrderExtracted = $this->shipOrderExtractedRepository->findWithoutFail($id);

        if (empty($shipOrderExtracted)) {
            return $this->sendError('Ship Order Extracted not found');
        }

        $shipOrderExtracted = $this->shipOrderExtractedRepository->update($input, $id);

        return $this->sendResponse($shipOrderExtracted->toArray(), 'ShipOrder updated successfully');
    }

    /**
     * Remove the specified ShipOrder from storage.
     * DELETE /shipOrderes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ShipOrder $shipOrder */
        $shipOrderExtracted = $this->shipOrderExtractedRepository->findWithoutFail($id);

        if (empty($shipOrderExtracted)) {
            return $this->sendError('Ship Order Extracted not found');
        }

        $shipOrderExtracted->delete();

        return $this->sendResponse($id, 'Ship Order Extracted deleted successfully');
    }
}

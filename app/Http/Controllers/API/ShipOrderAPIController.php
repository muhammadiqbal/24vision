<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateShipOrderAPIRequest;
use App\Http\Requests\API\UpdateShipOrderAPIRequest;
use App\Models\ShipOrder;
use App\Repositories\ShipOrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ShipOrderController
 * @package App\Http\Controllers\API
 */

class ShipOrderAPIController extends AppBaseController
{
    /** @var  ShipOrderRepository */
    private $shipOrderRepository;

    public function __construct(ShipOrderRepository $shipOrderRepo)
    {
        $this->shipOrderRepository = $shipOrderRepo;
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
        $this->shipOrderRepository->pushCriteria(new RequestCriteria($request));
        $this->shipOrderRepository->pushCriteria(new LimitOffsetCriteria($request));
        $shipOrders = $this->shipOrderRepository->all();

        return $this->sendResponse($shipOrders->toArray(), 'Ship Orderes retrieved successfully');
    }

    /**
     * Store a newly created ShipOrder in storage.
     * POST /shipOrderes
     *
     * @param CreateShipOrderAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateShipOrderAPIRequest $request)
    {
        $input = $request->all();

        $shipOrders = $this->shipOrderRepository->create($input);

        return $this->sendResponse($shipOrders->toArray(), 'Ship Order saved successfully');
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
        $shipOrder = $this->shipOrderRepository->findWithoutFail($id);

        if (empty($shipOrder)) {
            return $this->sendError('Ship Order not found');
        }

        return $this->sendResponse($shipOrder->toArray(), 'Ship Order retrieved successfully');
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
    public function update($id, UpdateShipOrderAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShipOrder $shipOrder */
        $shipOrder = $this->shipOrderRepository->findWithoutFail($id);

        if (empty($shipOrder)) {
            return $this->sendError('Ship Order not found');
        }

        $shipOrder = $this->shipOrderRepository->update($input, $id);

        return $this->sendResponse($shipOrder->toArray(), 'ShipOrder updated successfully');
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
        $shipOrder = $this->shipOrderRepository->findWithoutFail($id);

        if (empty($shipOrder)) {
            return $this->sendError('Ship Order not found');
        }

        $shipOrder->delete();

        return $this->sendResponse($id, 'Ship Order deleted successfully');
    }
}

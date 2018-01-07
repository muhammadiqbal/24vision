<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateZonePointAPIRequest;
use App\Http\Requests\API\UpdateZonePointAPIRequest;
use App\Models\ZonePoint;
use App\Repositories\ZonePointRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ZonePointController
 * @package App\Http\Controllers\API
 */

class ZonePointAPIController extends AppBaseController
{
    /** @var  ZonePointRepository */
    private $zonePointRepository;

    public function __construct(ZonePointRepository $zonePointRepo)
    {
        $this->zonePointRepository = $zonePointRepo;
    }

    /**
     * Display a listing of the ZonePoint.
     * GET|HEAD /zonePoints
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->zonePointRepository->pushCriteria(new RequestCriteria($request));
        $this->zonePointRepository->pushCriteria(new LimitOffsetCriteria($request));
        $zonePoints = $this->zonePointRepository->all();

        return $this->sendResponse($zonePoints->toArray(), 'Zone Points retrieved successfully');
    }

    /**
     * Store a newly created ZonePoint in storage.
     * POST /zonePoints
     *
     * @param CreateZonePointAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateZonePointAPIRequest $request)
    {
        $input = $request->all();

        $zonePoints = $this->zonePointRepository->create($input);

        return $this->sendResponse($zonePoints->toArray(), 'Zone Point saved successfully');
    }

    /**
     * Display the specified ZonePoint.
     * GET|HEAD /zonePoints/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ZonePoint $zonePoint */
        $zonePoint = $this->zonePointRepository->findWithoutFail($id);

        if (empty($zonePoint)) {
            return $this->sendError('Zone Point not found');
        }

        return $this->sendResponse($zonePoint->toArray(), 'Zone Point retrieved successfully');
    }

    /**
     * Update the specified ZonePoint in storage.
     * PUT/PATCH /zonePoints/{id}
     *
     * @param  int $id
     * @param UpdateZonePointAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateZonePointAPIRequest $request)
    {
        $input = $request->all();

        /** @var ZonePoint $zonePoint */
        $zonePoint = $this->zonePointRepository->findWithoutFail($id);

        if (empty($zonePoint)) {
            return $this->sendError('Zone Point not found');
        }

        $zonePoint = $this->zonePointRepository->update($input, $id);

        return $this->sendResponse($zonePoint->toArray(), 'ZonePoint updated successfully');
    }

    /**
     * Remove the specified ZonePoint from storage.
     * DELETE /zonePoints/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ZonePoint $zonePoint */
        $zonePoint = $this->zonePointRepository->findWithoutFail($id);

        if (empty($zonePoint)) {
            return $this->sendError('Zone Point not found');
        }

        $zonePoint->delete();

        return $this->sendResponse($id, 'Zone Point deleted successfully');
    }
}

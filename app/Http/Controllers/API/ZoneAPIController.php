<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateZoneAPIRequest;
use App\Http\Requests\API\UpdateZoneAPIRequest;
use App\Models\Zone;
use App\Repositories\ZoneRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ZoneController
 * @package App\Http\Controllers\API
 */

class ZoneAPIController extends AppBaseController
{
    /** @var  ZoneRepository */
    private $zoneRepository;

    public function __construct(ZoneRepository $zoneRepo)
    {
        $this->zoneRepository = $zoneRepo;
    }

    /**
     * Display a listing of the Zone.
     * GET|HEAD /zones
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->zoneRepository->pushCriteria(new RequestCriteria($request));
        $this->zoneRepository->pushCriteria(new LimitOffsetCriteria($request));
        $zones = $this->zoneRepository->all();

        return $this->sendResponse($zones->toArray(), 'Zones retrieved successfully');
    }

    /**
     * Store a newly created Zone in storage.
     * POST /zones
     *
     * @param CreateZoneAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateZoneAPIRequest $request)
    {
        $input = $request->all();

        $zones = $this->zoneRepository->create($input);

        return $this->sendResponse($zones->toArray(), 'Zone saved successfully');
    }

    /**
     * Display the specified Zone.
     * GET|HEAD /zones/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Zone $zone */
        $zone = $this->zoneRepository->findWithoutFail($id);

        if (empty($zone)) {
            return $this->sendError('Zone not found');
        }

        return $this->sendResponse($zone->toArray(), 'Zone retrieved successfully');
    }

    /**
     * Update the specified Zone in storage.
     * PUT/PATCH /zones/{id}
     *
     * @param  int $id
     * @param UpdateZoneAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateZoneAPIRequest $request)
    {
        $input = $request->all();

        /** @var Zone $zone */
        $zone = $this->zoneRepository->findWithoutFail($id);

        if (empty($zone)) {
            return $this->sendError('Zone not found');
        }

        $zone = $this->zoneRepository->update($input, $id);

        return $this->sendResponse($zone->toArray(), 'Zone updated successfully');
    }

    /**
     * Remove the specified Zone from storage.
     * DELETE /zones/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Zone $zone */
        $zone = $this->zoneRepository->findWithoutFail($id);

        if (empty($zone)) {
            return $this->sendError('Zone not found');
        }

        $zone->delete();

        return $this->sendResponse($id, 'Zone deleted successfully');
    }
}

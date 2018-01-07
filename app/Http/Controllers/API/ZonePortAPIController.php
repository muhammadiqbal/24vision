<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateZonePortAPIRequest;
use App\Http\Requests\API\UpdateZonePortAPIRequest;
use App\Models\ZonePort;
use App\Repositories\ZonePortRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ZonePortController
 * @package App\Http\Controllers\API
 */

class ZonePortAPIController extends AppBaseController
{
    /** @var  ZonePortRepository */
    private $zonePortRepository;

    public function __construct(ZonePortRepository $zonePortRepo)
    {
        $this->zonePortRepository = $zonePortRepo;
    }

    /**
     * Display a listing of the ZonePort.
     * GET|HEAD /zonePorts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->zonePortRepository->pushCriteria(new RequestCriteria($request));
        $this->zonePortRepository->pushCriteria(new LimitOffsetCriteria($request));
        $zonePorts = $this->zonePortRepository->all();

        return $this->sendResponse($zonePorts->toArray(), 'Zone Ports retrieved successfully');
    }

    /**
     * Store a newly created ZonePort in storage.
     * POST /zonePorts
     *
     * @param CreateZonePortAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateZonePortAPIRequest $request)
    {
        $input = $request->all();

        $zonePorts = $this->zonePortRepository->create($input);

        return $this->sendResponse($zonePorts->toArray(), 'Zone Port saved successfully');
    }

    /**
     * Display the specified ZonePort.
     * GET|HEAD /zonePorts/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ZonePort $zonePort */
        $zonePort = $this->zonePortRepository->findWithoutFail($id);

        if (empty($zonePort)) {
            return $this->sendError('Zone Port not found');
        }

        return $this->sendResponse($zonePort->toArray(), 'Zone Port retrieved successfully');
    }

    /**
     * Update the specified ZonePort in storage.
     * PUT/PATCH /zonePorts/{id}
     *
     * @param  int $id
     * @param UpdateZonePortAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateZonePortAPIRequest $request)
    {
        $input = $request->all();

        /** @var ZonePort $zonePort */
        $zonePort = $this->zonePortRepository->findWithoutFail($id);

        if (empty($zonePort)) {
            return $this->sendError('Zone Port not found');
        }

        $zonePort = $this->zonePortRepository->update($input, $id);

        return $this->sendResponse($zonePort->toArray(), 'ZonePort updated successfully');
    }

    /**
     * Remove the specified ZonePort from storage.
     * DELETE /zonePorts/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ZonePort $zonePort */
        $zonePort = $this->zonePortRepository->findWithoutFail($id);

        if (empty($zonePort)) {
            return $this->sendError('Zone Port not found');
        }

        $zonePort->delete();

        return $this->sendResponse($id, 'Zone Port deleted successfully');
    }
}

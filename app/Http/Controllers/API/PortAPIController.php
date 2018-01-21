<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePortAPIRequest;
use App\Http\Requests\API\UpdatePortAPIRequest;
use App\Models\Port;
use App\Repositories\PortRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PortController
 * @package App\Http\Controllers\API
 */

class PortAPIController extends AppBaseController
{
    /** @var  PortRepository */
    private $portRepository;

    public function __construct(portRepository $portRepo)
    {
        $this->portRepository = $portRepo;
    }

    /**
     * Display a listing of the Port.
     * GET|HEAD /Ports
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->portRepository->pushCriteria(new RequestCriteria($request));
        $this->portRepository->pushCriteria(new LimitOffsetCriteria($request));
        $ports = $this->portRepository->all();

        return $this->sendResponse($ports->toArray(), 'Ports retrieved successfully');
    }

    /**
     * Store a newly created Port in storage.
     * POST /Ports
     *
     * @param CreatePortAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePortAPIRequest $request)
    {
        $input = $request->all();

        $ports = $this->portRepository->create($input);

        return $this->sendResponse($ports->toArray(), 'Port saved successfully');
    }

    /**
     * Display the specified Port.
     * GET|HEAD /Ports/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Port $Port */
        $port = $this->portRepository->findWithoutFail($id);

        if (empty($Port)) {
            return $this->sendError('Port not found');
        }

        return $this->sendResponse($port->toArray(), 'Port retrieved successfully');
    }

    /**
     * Update the specified Port in storage.
     * PUT/PATCH /Ports/{id}
     *
     * @param  int $id
     * @param UpdatePortAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePortAPIRequest $request)
    {
        $input = $request->all();

        /** @var Port $Port */
        $port = $this->portRepository->findWithoutFail($id);

        if (empty($port)) {
            return $this->sendError('Port not found');
        }

        $port = $this->portRepository->update($input, $id);

        return $this->sendResponse($port->toArray(), 'Port updated successfully');
    }

    /**
     * Remove the specified Port from storage.
     * DELETE /Ports/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Port $Port */
        $port = $this->portRepository->findWithoutFail($id);

        if (empty($Port)) {
            return $this->sendError('Port not found');
        }

        $port->delete();

        return $this->sendResponse($id, 'Port deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDistanceAPIRequest;
use App\Http\Requests\API\UpdateDistanceAPIRequest;
use App\Models\Distance;
use App\Repositories\DistanceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DistanceController
 * @package App\Http\Controllers\API
 */

class DistanceAPIController extends AppBaseController
{
    /** @var  DistanceRepository */
    private $distanceRepository;

    public function __construct(DistanceRepository $distanceRepo)
    {
        $this->distanceRepository = $distanceRepo;
    }

    /**
     * Display a listing of the Distance.
     * GET|HEAD /distances
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->distanceRepository->pushCriteria(new RequestCriteria($request));
        $this->distanceRepository->pushCriteria(new LimitOffsetCriteria($request));
        $distances = $this->distanceRepository->all();

        return $this->sendResponse($distances->toArray(), 'Distances retrieved successfully');
    }

    /**
     * Store a newly created Distance in storage.
     * POST /distances
     *
     * @param CreateDistanceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDistanceAPIRequest $request)
    {
        $input = $request->all();

        $distances = $this->distanceRepository->create($input);

        return $this->sendResponse($distances->toArray(), 'Distance saved successfully');
    }

    /**
     * Display the specified Distance.
     * GET|HEAD /distances/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Distance $distance */
        $distance = $this->distanceRepository->findWithoutFail($id);

        if (empty($distance)) {
            return $this->sendError('Distance not found');
        }

        return $this->sendResponse($distance->toArray(), 'Distance retrieved successfully');
    }

    /**
     * Update the specified Distance in storage.
     * PUT/PATCH /distances/{id}
     *
     * @param  int $id
     * @param UpdateDistanceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDistanceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Distance $distance */
        $distance = $this->distanceRepository->findWithoutFail($id);

        if (empty($distance)) {
            return $this->sendError('Distance not found');
        }

        $distance = $this->distanceRepository->update($input, $id);

        return $this->sendResponse($distance->toArray(), 'Distance updated successfully');
    }

    /**
     * Remove the specified Distance from storage.
     * DELETE /distances/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Distance $distance */
        $distance = $this->distanceRepository->findWithoutFail($id);

        if (empty($distance)) {
            return $this->sendError('Distance not found');
        }

        $distance->delete();

        return $this->sendResponse($id, 'Distance deleted successfully');
    }
}

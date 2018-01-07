<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBdiAPIRequest;
use App\Http\Requests\API\UpdateBdiAPIRequest;
use App\Models\Bdi;
use App\Repositories\BdiRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BdiController
 * @package App\Http\Controllers\API
 */

class BdiAPIController extends AppBaseController
{
    /** @var  BdiRepository */
    private $bdiRepository;

    public function __construct(BdiRepository $bdiRepo)
    {
        $this->bdiRepository = $bdiRepo;
    }

    /**
     * Display a listing of the Bdi.
     * GET|HEAD /bdis
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->bdiRepository->pushCriteria(new RequestCriteria($request));
        $this->bdiRepository->pushCriteria(new LimitOffsetCriteria($request));
        $bdis = $this->bdiRepository->all();

        return $this->sendResponse($bdis->toArray(), 'Bdis retrieved successfully');
    }

    /**
     * Store a newly created Bdi in storage.
     * POST /bdis
     *
     * @param CreateBdiAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBdiAPIRequest $request)
    {
        $input = $request->all();

        $bdis = $this->bdiRepository->create($input);

        return $this->sendResponse($bdis->toArray(), 'Bdi saved successfully');
    }

    /**
     * Display the specified Bdi.
     * GET|HEAD /bdis/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Bdi $bdi */
        $bdi = $this->bdiRepository->findWithoutFail($id);

        if (empty($bdi)) {
            return $this->sendError('Bdi not found');
        }

        return $this->sendResponse($bdi->toArray(), 'Bdi retrieved successfully');
    }

    /**
     * Update the specified Bdi in storage.
     * PUT/PATCH /bdis/{id}
     *
     * @param  int $id
     * @param UpdateBdiAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBdiAPIRequest $request)
    {
        $input = $request->all();

        /** @var Bdi $bdi */
        $bdi = $this->bdiRepository->findWithoutFail($id);

        if (empty($bdi)) {
            return $this->sendError('Bdi not found');
        }

        $bdi = $this->bdiRepository->update($input, $id);

        return $this->sendResponse($bdi->toArray(), 'Bdi updated successfully');
    }

    /**
     * Remove the specified Bdi from storage.
     * DELETE /bdis/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Bdi $bdi */
        $bdi = $this->bdiRepository->findWithoutFail($id);

        if (empty($bdi)) {
            return $this->sendError('Bdi not found');
        }

        $bdi->delete();

        return $this->sendResponse($id, 'Bdi deleted successfully');
    }
}

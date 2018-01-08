<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLdRateTypeAPIRequest;
use App\Http\Requests\API\UpdateLdRateTypeAPIRequest;
use App\Models\LdRateType;
use App\Repositories\LdRateTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class LdRateTypeController
 * @package App\Http\Controllers\API
 */

class LdRateTypeAPIController extends AppBaseController
{
    /** @var  LdRateTypeRepository */
    private $ldRateTypeRepository;

    public function __construct(LdRateTypeRepository $ldRateTypeRepo)
    {
        $this->ldRateTypeRepository = $ldRateTypeRepo;
    }

    /**
     * Display a listing of the LdRateType.
     * GET|HEAD /ldRateTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->ldRateTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->ldRateTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $ldRateTypes = $this->ldRateTypeRepository->all();

        return $this->sendResponse($ldRateTypes->toArray(), 'Ld Rate Types retrieved successfully');
    }

    /**
     * Store a newly created LdRateType in storage.
     * POST /ldRateTypes
     *
     * @param CreateLdRateTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLdRateTypeAPIRequest $request)
    {
        $input = $request->all();

        $ldRateTypes = $this->ldRateTypeRepository->create($input);

        return $this->sendResponse($ldRateTypes->toArray(), 'Ld Rate Type saved successfully');
    }

    /**
     * Display the specified LdRateType.
     * GET|HEAD /ldRateTypes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LdRateType $ldRateType */
        $ldRateType = $this->ldRateTypeRepository->findWithoutFail($id);

        if (empty($ldRateType)) {
            return $this->sendError('Ld Rate Type not found');
        }

        return $this->sendResponse($ldRateType->toArray(), 'Ld Rate Type retrieved successfully');
    }

    /**
     * Update the specified LdRateType in storage.
     * PUT/PATCH /ldRateTypes/{id}
     *
     * @param  int $id
     * @param UpdateLdRateTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLdRateTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var LdRateType $ldRateType */
        $ldRateType = $this->ldRateTypeRepository->findWithoutFail($id);

        if (empty($ldRateType)) {
            return $this->sendError('Ld Rate Type not found');
        }

        $ldRateType = $this->ldRateTypeRepository->update($input, $id);

        return $this->sendResponse($ldRateType->toArray(), 'LdRateType updated successfully');
    }

    /**
     * Remove the specified LdRateType from storage.
     * DELETE /ldRateTypes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LdRateType $ldRateType */
        $ldRateType = $this->ldRateTypeRepository->findWithoutFail($id);

        if (empty($ldRateType)) {
            return $this->sendError('Ld Rate Type not found');
        }

        $ldRateType->delete();

        return $this->sendResponse($id, 'Ld Rate Type deleted successfully');
    }
}

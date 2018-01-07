<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePathAPIRequest;
use App\Http\Requests\API\UpdatePathAPIRequest;
use App\Models\Path;
use App\Repositories\PathRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PathController
 * @package App\Http\Controllers\API
 */

class PathAPIController extends AppBaseController
{
    /** @var  PathRepository */
    private $pathRepository;

    public function __construct(PathRepository $pathRepo)
    {
        $this->pathRepository = $pathRepo;
    }

    /**
     * Display a listing of the Path.
     * GET|HEAD /paths
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pathRepository->pushCriteria(new RequestCriteria($request));
        $this->pathRepository->pushCriteria(new LimitOffsetCriteria($request));
        $paths = $this->pathRepository->all();

        return $this->sendResponse($paths->toArray(), 'Paths retrieved successfully');
    }

    /**
     * Store a newly created Path in storage.
     * POST /paths
     *
     * @param CreatePathAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePathAPIRequest $request)
    {
        $input = $request->all();

        $paths = $this->pathRepository->create($input);

        return $this->sendResponse($paths->toArray(), 'Path saved successfully');
    }

    /**
     * Display the specified Path.
     * GET|HEAD /paths/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Path $path */
        $path = $this->pathRepository->findWithoutFail($id);

        if (empty($path)) {
            return $this->sendError('Path not found');
        }

        return $this->sendResponse($path->toArray(), 'Path retrieved successfully');
    }

    /**
     * Update the specified Path in storage.
     * PUT/PATCH /paths/{id}
     *
     * @param  int $id
     * @param UpdatePathAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePathAPIRequest $request)
    {
        $input = $request->all();

        /** @var Path $path */
        $path = $this->pathRepository->findWithoutFail($id);

        if (empty($path)) {
            return $this->sendError('Path not found');
        }

        $path = $this->pathRepository->update($input, $id);

        return $this->sendResponse($path->toArray(), 'Path updated successfully');
    }

    /**
     * Remove the specified Path from storage.
     * DELETE /paths/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Path $path */
        $path = $this->pathRepository->findWithoutFail($id);

        if (empty($path)) {
            return $this->sendError('Path not found');
        }

        $path->delete();

        return $this->sendResponse($id, 'Path deleted successfully');
    }
}

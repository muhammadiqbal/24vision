<?php

namespace App\Http\Controllers;

use App\DataTables\PathDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePathRequest;
use App\Http\Requests\UpdatePathRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Zone;
use App\Models\Route;
use App\Repositories\PathRepository;
use Flash;
use Response;

class PathController extends AppBaseController
{
    /** @var  PathRepository */
    private $pathRepository;

    public function __construct(PathRepository $pathRepo)
    {
        $this->pathRepository = $pathRepo;
    }

    /**
     * Display a listing of the Path.
     *
     * @param PathDataTable $pathDataTable
     * @return Response
     */
    public function index(PathDataTable $pathDataTable)
    {
        return $pathDataTable->render('paths.index');
    }

    /**
     * Show the form for creating a new Path.
     *
     * @return Response
     */
    public function create()
    {
        $routes = Route::all();
        $zones = Zone::all();
        return view('paths.create')->with('routes',$routes)
                                   ->with('zones',$zones);
    }

    /**
     * Store a newly created Path in storage.
     *
     * @param CreatePathRequest $request
     *
     * @return Response
     */
    public function store(CreatePathRequest $request)
    {
        $input = $request->all();

        $path = $this->pathRepository->create($input);

        Flash::success('Path saved successfully.');

        return redirect(route('paths.index'));
    }

    /**
     * Display the specified Path.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $path = $this->pathRepository->findWithoutFail($id);

        if (empty($path)) {
            Flash::error('Path not found');

            return redirect(route('paths.index'));
        }

        return view('paths.show')->with('path', $path);
    }

    /**
     * Show the form for editing the specified Path.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $path = $this->pathRepository->findWithoutFail($id);

        if (empty($path)) {
            Flash::error('Path not found');

            return redirect(route('paths.index'));
        }

        $routes = Route::all();
        $zones = Zone::all();
        return view('paths.edit')->with('path', $path)
                                 ->with('routes',$routes)
                                 ->with('zones',$zones);
    }

    /**
     * Update the specified Path in storage.
     *
     * @param  int              $id
     * @param UpdatePathRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePathRequest $request)
    {
        $path = $this->pathRepository->findWithoutFail($id);

        if (empty($path)) {
            Flash::error('Path not found');

            return redirect(route('paths.index'));
        }

        $path = $this->pathRepository->update($request->all(), $id);

        Flash::success('Path updated successfully.');

        return redirect(route('paths.index'));
    }

    /**
     * Remove the specified Path from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $path = $this->pathRepository->findWithoutFail($id);

        if (empty($path)) {
            Flash::error('Path not found');

            return redirect(route('paths.index'));
        }

        $this->pathRepository->delete($id);

        Flash::success('Path deleted successfully.');

        return redirect(route('paths.index'));
    }
}

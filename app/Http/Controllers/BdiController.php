<?php

namespace App\Http\Controllers;

use App\DataTables\BdiDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateBdiRequest;
use App\Http\Requests\UpdateBdiRequest;
use App\Repositories\BdiRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Route;
use App\Models\Ship;

class BdiController extends AppBaseController
{
    /** @var  BdiRepository */
    private $bdiRepository;

    public function __construct(BdiRepository $bdiRepo)
    {
        $this->bdiRepository = $bdiRepo;
    }

    /**
     * Display a listing of the Bdi.
     *
     * @param BdiDataTable $bdiDataTable
     * @return Response
     */
    public function index(BdiDataTable $bdiDataTable)
    {
        return $bdiDataTable->render('bdis.index');
    }

    /**
     * Show the form for creating a new Bdi.
     *
     * @return Response
     */
    public function create()
    {
        $routes = Route::all();
        $ships  = Ship::all();
        return view('bdis.create')->with('routes',$routes)->with('ships',$ships);
    }

    /**
     * Store a newly created Bdi in storage.
     *
     * @param CreateBdiRequest $request
     *
     * @return Response
     */
    public function store(CreateBdiRequest $request)
    {
        $input = $request->all();

        $bdi = $this->bdiRepository->create($input);

        Flash::success('Bdi saved successfully.');

        return redirect(route('bdis.index'));
    }

    /**
     * Display the specified Bdi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bdi = $this->bdiRepository->findWithoutFail($id);

        if (empty($bdi)) {
            Flash::error('Bdi not found');

            return redirect(route('bdis.index'));
        }

        return view('bdis.show')->with('bdi', $bdi);
    }

    /**
     * Show the form for editing the specified Bdi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bdi = $this->bdiRepository->findWithoutFail($id);

        if (empty($bdi)) {
            Flash::error('Bdi not found');

            return redirect(route('bdis.index'));
        }

        $routes = Route::all();
        $ships  = Ship::all();

        return view('bdis.edit')->with('bdi', $bdi)->with('routes',$routes)->with('ships',$ships);
    }

    /**
     * Update the specified Bdi in storage.
     *
     * @param  int              $id
     * @param UpdateBdiRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBdiRequest $request)
    {
        $bdi = $this->bdiRepository->findWithoutFail($id);

        if (empty($bdi)) {
            Flash::error('Bdi not found');

            return redirect(route('bdis.index'));
        }

        $bdi = $this->bdiRepository->update($request->all(), $id);

        Flash::success('Bdi updated successfully.');

        return redirect(route('bdis.index'));
    }

    /**
     * Remove the specified Bdi from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bdi = $this->bdiRepository->findWithoutFail($id);

        if (empty($bdi)) {
            Flash::error('Bdi not found');

            return redirect(route('bdis.index'));
        }

        $this->bdiRepository->delete($id);

        Flash::success('Bdi deleted successfully.');

        return redirect(route('bdis.index'));
    }
}

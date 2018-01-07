<?php

namespace App\Http\Controllers;

use App\DataTables\CargoStatusDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCargoStatusRequest;
use App\Http\Requests\UpdateCargoStatusRequest;
use App\Repositories\CargoStatusRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CargoStatusController extends AppBaseController
{
    /** @var  CargoStatusRepository */
    private $cargoStatusRepository;

    public function __construct(CargoStatusRepository $cargoStatusRepo)
    {
        $this->cargoStatusRepository = $cargoStatusRepo;
    }

    /**
     * Display a listing of the CargoStatus.
     *
     * @param CargoStatusDataTable $cargoStatusDataTable
     * @return Response
     */
    public function index(CargoStatusDataTable $cargoStatusDataTable)
    {
        return $cargoStatusDataTable->render('cargo_statuses.index');
    }

    /**
     * Show the form for creating a new CargoStatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('cargo_statuses.create');
    }

    /**
     * Store a newly created CargoStatus in storage.
     *
     * @param CreateCargoStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateCargoStatusRequest $request)
    {
        $input = $request->all();

        $cargoStatus = $this->cargoStatusRepository->create($input);

        Flash::success('Cargo Status saved successfully.');

        return redirect(route('cargoStatuses.index'));
    }

    /**
     * Display the specified CargoStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cargoStatus = $this->cargoStatusRepository->findWithoutFail($id);

        if (empty($cargoStatus)) {
            Flash::error('Cargo Status not found');

            return redirect(route('cargoStatuses.index'));
        }

        return view('cargo_statuses.show')->with('cargoStatus', $cargoStatus);
    }

    /**
     * Show the form for editing the specified CargoStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cargoStatus = $this->cargoStatusRepository->findWithoutFail($id);

        if (empty($cargoStatus)) {
            Flash::error('Cargo Status not found');

            return redirect(route('cargoStatuses.index'));
        }

        return view('cargo_statuses.edit')->with('cargoStatus', $cargoStatus);
    }

    /**
     * Update the specified CargoStatus in storage.
     *
     * @param  int              $id
     * @param UpdateCargoStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCargoStatusRequest $request)
    {
        $cargoStatus = $this->cargoStatusRepository->findWithoutFail($id);

        if (empty($cargoStatus)) {
            Flash::error('Cargo Status not found');

            return redirect(route('cargoStatuses.index'));
        }

        $cargoStatus = $this->cargoStatusRepository->update($request->all(), $id);

        Flash::success('Cargo Status updated successfully.');

        return redirect(route('cargoStatuses.index'));
    }

    /**
     * Remove the specified CargoStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cargoStatus = $this->cargoStatusRepository->findWithoutFail($id);

        if (empty($cargoStatus)) {
            Flash::error('Cargo Status not found');

            return redirect(route('cargoStatuses.index'));
        }

        $this->cargoStatusRepository->delete($id);

        Flash::success('Cargo Status deleted successfully.');

        return redirect(route('cargoStatuses.index'));
    }
}

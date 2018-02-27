<?php

namespace App\Http\Controllers;

use App\DataTables\CargoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCargoRequest;
use App\Http\Requests\UpdateCargoRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\CargoStatus;
use App\Models\CargoType;
use App\Models\LdRateType;
use App\Models\Port;
use App\Models\ShipSpecialization;
use App\Models\StowageFactorUnit;
use App\Models\QuantityMeasurement;
use App\Repositories\CargoRepository;
use Flash;
use Response;

class CargoController extends AppBaseController
{
    /** @var  CargoRepository */
    private $cargoRepository;

    public function __construct(CargoRepository $cargoRepo)
    {
        $this->cargoRepository = $cargoRepo;
    }

    /**
     * Display a listing of the Cargo.
     *
     * @param CargoDataTable $cargoDataTable
     * @return Response
     */
    public function index(CargoDataTable $cargoDataTable)
    {
        return $cargoDataTable->render('cargos.index');
    }

    /**
     * Show the form for creating a new Cargo.
     *
     * @return Response
     */
    public function create()
    {
        $cargo_statuses = CargoStatus::all();
        $cargo_types = CargoType::all();
        $ld_rate_types = LdRateType::all();
        $ports = Port::all();
        $ship_specializations = ShipSpecialization::all();
        $sf_units = StowageFactorUnit::all();
        $quantity_measurements = QuantityMeasurement::all();
        return view('cargos.create')->with('cargo_statuses',$cargo_statuses)
                                    ->with('cargo_types',$cargo_types)
                                    ->with('ld_rate_types',$ld_rate_types)
                                    ->with('ports',$ports)
                                    ->with('ship_specializaions', $ship_specializations)
                                    ->with('sf_units', $sf_units);
    }

    /**
     * Store a newly created Cargo in storage.
     *
     * @param CreateCargoRequest $request
     *
     * @return Response
     */
    public function store(CreateCargoRequest $request)
    {
        $input = $request->all();

        $cargo = $this->cargoRepository->create($input);

        Flash::success('Cargo saved successfully.');

        return redirect(route('cargos.index'));
    }

    /**
     * Display the specified Cargo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cargo = $this->cargoRepository->findWithoutFail($id);

        if (empty($cargo)) {
            Flash::error('Cargo not found');

            return redirect(route('cargos.index'));
        }

        return view('cargos.show')->with('cargo', $cargo);
    }

    /**
     * Show the form for editing the specified Cargo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cargo = $this->cargoRepository->findWithoutFail($id);

        if (empty($cargo)) {
            Flash::error('Cargo not found');

            return redirect(route('cargos.index'));
        }

        $cargo_statuses = CargoStatus::all();
        $cargo_types = CargoType::all();
        $ld_rate_types = LdRateType::all();
        $ports = Port::all();
        $ship_specializations = ShipSpecialization::all();
        $sf_units = StowageFactorUnit::all();
        $quantity_measurements = QuantityMeasurement::all();

        return view('cargos.edit')->with('cargo',$cargo)
                                    ->with('cargo_statuses',$cargo_statuses)
                                    ->with('cargo_types',$cargo_types)
                                    ->with('ld_rate_types',$ld_rate_types)
                                    ->with('ports',$ports)
                                    ->with('ship_specializations', $ship_specializations)
                                    ->with('sf_units', $sf_units);
    }

    /**
     * Update the specified Cargo in storage.
     *
     * @param  int              $id
     * @param UpdateCargoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCargoRequest $request)
    {
        $cargo = $this->cargoRepository->findWithoutFail($id);

        if (empty($cargo)) {
            Flash::error('Cargo not found');

            return redirect(route('cargos.index'));
        }

        $cargo = $this->cargoRepository->update($request->all(), $id);

        Flash::success('Cargo updated successfully.');

        return redirect(route('cargos.index'));
    }

    /**
     * Remove the specified Cargo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cargo = $this->cargoRepository->findWithoutFail($id);

        if (empty($cargo)) {
            Flash::error('Cargo not found');

            return redirect(route('cargos.index'));
        }

        $this->cargoRepository->delete($id);

        Flash::success('Cargo deleted successfully.');

        return redirect(route('cargos.index'));
    }
}

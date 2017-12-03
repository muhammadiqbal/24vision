<?php

namespace App\Http\Controllers;

use App\DataTables\FuelTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFuelTypeRequest;
use App\Http\Requests\UpdateFuelTypeRequest;
use App\Repositories\FuelTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class FuelTypeController extends AppBaseController
{
    /** @var  FuelTypeRepository */
    private $fuelTypeRepository;

    public function __construct(FuelTypeRepository $fuelTypeRepo)
    {
        $this->fuelTypeRepository = $fuelTypeRepo;
    }

    /**
     * Display a listing of the FuelType.
     *
     * @param FuelTypeDataTable $fuelTypeDataTable
     * @return Response
     */
    public function index(FuelTypeDataTable $fuelTypeDataTable)
    {
        return $fuelTypeDataTable->render('fuel_types.index');
    }

    /**
     * Show the form for creating a new FuelType.
     *
     * @return Response
     */
    public function create()
    {
        return view('fuel_types.create');
    }

    /**
     * Store a newly created FuelType in storage.
     *
     * @param CreateFuelTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateFuelTypeRequest $request)
    {
        $input = $request->all();

        $fuelType = $this->fuelTypeRepository->create($input);

        Flash::success('Fuel Type saved successfully.');

        return redirect(route('fuelTypes.index'));
    }

    /**
     * Display the specified FuelType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fuelType = $this->fuelTypeRepository->findWithoutFail($id);

        if (empty($fuelType)) {
            Flash::error('Fuel Type not found');

            return redirect(route('fuelTypes.index'));
        }

        return view('fuel_types.show')->with('fuelType', $fuelType);
    }

    /**
     * Show the form for editing the specified FuelType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fuelType = $this->fuelTypeRepository->findWithoutFail($id);

        if (empty($fuelType)) {
            Flash::error('Fuel Type not found');

            return redirect(route('fuelTypes.index'));
        }

        return view('fuel_types.edit')->with('fuelType', $fuelType);
    }

    /**
     * Update the specified FuelType in storage.
     *
     * @param  int              $id
     * @param UpdateFuelTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFuelTypeRequest $request)
    {
        $fuelType = $this->fuelTypeRepository->findWithoutFail($id);

        if (empty($fuelType)) {
            Flash::error('Fuel Type not found');

            return redirect(route('fuelTypes.index'));
        }

        $fuelType = $this->fuelTypeRepository->update($request->all(), $id);

        Flash::success('Fuel Type updated successfully.');

        return redirect(route('fuelTypes.index'));
    }

    /**
     * Remove the specified FuelType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $fuelType = $this->fuelTypeRepository->findWithoutFail($id);

        if (empty($fuelType)) {
            Flash::error('Fuel Type not found');

            return redirect(route('fuelTypes.index'));
        }

        $this->fuelTypeRepository->delete($id);

        Flash::success('Fuel Type deleted successfully.');

        return redirect(route('fuelTypes.index'));
    }
}

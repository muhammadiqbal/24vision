<?php

namespace App\Http\Controllers;

use App\DataTables\FuelPriceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFuelPriceRequest;
use App\Http\Requests\UpdateFuelPriceRequest;
use App\Repositories\FuelPriceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class FuelPriceController extends AppBaseController
{
    /** @var  FuelPriceRepository */
    private $fuelPriceRepository;

    public function __construct(FuelPriceRepository $fuelPriceRepo)
    {
        $this->fuelPriceRepository = $fuelPriceRepo;
    }

    /**
     * Display a listing of the FuelPrice.
     *
     * @param FuelPriceDataTable $fuelPriceDataTable
     * @return Response
     */
    public function index(FuelPriceDataTable $fuelPriceDataTable)
    {
        return $fuelPriceDataTable->render('fuel_prices.index');
    }

    /**
     * Show the form for creating a new FuelPrice.
     *
     * @return Response
     */
    public function create()
    {
        return view('fuel_prices.create');
    }

    /**
     * Store a newly created FuelPrice in storage.
     *
     * @param CreateFuelPriceRequest $request
     *
     * @return Response
     */
    public function store(CreateFuelPriceRequest $request)
    {
        $input = $request->all();

        $fuelPrice = $this->fuelPriceRepository->create($input);

        Flash::success('Fuel Price saved successfully.');

        return redirect(route('fuelPrices.index'));
    }

    /**
     * Display the specified FuelPrice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fuelPrice = $this->fuelPriceRepository->findWithoutFail($id);

        if (empty($fuelPrice)) {
            Flash::error('Fuel Price not found');

            return redirect(route('fuelPrices.index'));
        }

        return view('fuel_prices.show')->with('fuelPrice', $fuelPrice);
    }

    /**
     * Show the form for editing the specified FuelPrice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fuelPrice = $this->fuelPriceRepository->findWithoutFail($id);

        if (empty($fuelPrice)) {
            Flash::error('Fuel Price not found');

            return redirect(route('fuelPrices.index'));
        }

        return view('fuel_prices.edit')->with('fuelPrice', $fuelPrice);
    }

    /**
     * Update the specified FuelPrice in storage.
     *
     * @param  int              $id
     * @param UpdateFuelPriceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFuelPriceRequest $request)
    {
        $fuelPrice = $this->fuelPriceRepository->findWithoutFail($id);

        if (empty($fuelPrice)) {
            Flash::error('Fuel Price not found');

            return redirect(route('fuelPrices.index'));
        }

        $fuelPrice = $this->fuelPriceRepository->update($request->all(), $id);

        Flash::success('Fuel Price updated successfully.');

        return redirect(route('fuelPrices.index'));
    }

    /**
     * Remove the specified FuelPrice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $fuelPrice = $this->fuelPriceRepository->findWithoutFail($id);

        if (empty($fuelPrice)) {
            Flash::error('Fuel Price not found');

            return redirect(route('fuelPrices.index'));
        }

        $this->fuelPriceRepository->delete($id);

        Flash::success('Fuel Price deleted successfully.');

        return redirect(route('fuelPrices.index'));
    }
}

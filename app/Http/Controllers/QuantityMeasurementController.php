<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuantityMeasurementRequest;
use App\Http\Requests\UpdateQuantityMeasurementRequest;
use App\Repositories\QuantityMeasurementRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class QuantityMeasurementController extends AppBaseController
{
    /** @var  QuantityMeasurementRepository */
    private $quantityMeasurementRepository;

    public function __construct(QuantityMeasurementRepository $quantityMeasurementRepo)
    {
        $this->quantityMeasurementRepository = $quantityMeasurementRepo;
    }

    /**
     * Display a listing of the QuantityMeasurement.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->quantityMeasurementRepository->pushCriteria(new RequestCriteria($request));
        $quantityMeasurements = $this->quantityMeasurementRepository->all();

        return view('quantity_measurements.index')
            ->with('quantityMeasurements', $quantityMeasurements);
    }

    /**
     * Show the form for creating a new QuantityMeasurement.
     *
     * @return Response
     */
    public function create()
    {
        return view('quantity_measurements.create');
    }

    /**
     * Store a newly created QuantityMeasurement in storage.
     *
     * @param CreateQuantityMeasurementRequest $request
     *
     * @return Response
     */
    public function store(CreateQuantityMeasurementRequest $request)
    {
        $input = $request->all();

        $quantityMeasurement = $this->quantityMeasurementRepository->create($input);

        Flash::success('Quantity Measurement saved successfully.');

        return redirect(route('quantityMeasurements.index'));
    }

    /**
     * Display the specified QuantityMeasurement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $quantityMeasurement = $this->quantityMeasurementRepository->findWithoutFail($id);

        if (empty($quantityMeasurement)) {
            Flash::error('Quantity Measurement not found');

            return redirect(route('quantityMeasurements.index'));
        }

        return view('quantity_measurements.show')->with('quantityMeasurement', $quantityMeasurement);
    }

    /**
     * Show the form for editing the specified QuantityMeasurement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $quantityMeasurement = $this->quantityMeasurementRepository->findWithoutFail($id);

        if (empty($quantityMeasurement)) {
            Flash::error('Quantity Measurement not found');

            return redirect(route('quantityMeasurements.index'));
        }

        return view('quantity_measurements.edit')->with('quantityMeasurement', $quantityMeasurement);
    }

    /**
     * Update the specified QuantityMeasurement in storage.
     *
     * @param  int              $id
     * @param UpdateQuantityMeasurementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuantityMeasurementRequest $request)
    {
        $quantityMeasurement = $this->quantityMeasurementRepository->findWithoutFail($id);

        if (empty($quantityMeasurement)) {
            Flash::error('Quantity Measurement not found');

            return redirect(route('quantityMeasurements.index'));
        }

        $quantityMeasurement = $this->quantityMeasurementRepository->update($request->all(), $id);

        Flash::success('Quantity Measurement updated successfully.');

        return redirect(route('quantityMeasurements.index'));
    }

    /**
     * Remove the specified QuantityMeasurement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $quantityMeasurement = $this->quantityMeasurementRepository->findWithoutFail($id);

        if (empty($quantityMeasurement)) {
            Flash::error('Quantity Measurement not found');

            return redirect(route('quantityMeasurements.index'));
        }

        $this->quantityMeasurementRepository->delete($id);

        Flash::success('Quantity Measurement deleted successfully.');

        return redirect(route('quantityMeasurements.index'));
    }
}

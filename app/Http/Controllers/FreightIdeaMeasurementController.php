<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFreightIdeaMeasurementRequest;
use App\Http\Requests\UpdateFreightIdeaMeasurementRequest;
use App\Repositories\FreightIdeaMeasurementRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class FreightIdeaMeasurementController extends AppBaseController
{
    /** @var  FreightIdeaMeasurementRepository */
    private $freightIdeaMeasurementRepository;

    public function __construct(FreightIdeaMeasurementRepository $freightIdeaMeasurementRepo)
    {
        $this->freightIdeaMeasurementRepository = $freightIdeaMeasurementRepo;
    }

    /**
     * Display a listing of the FreightIdeaMeasurement.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->freightIdeaMeasurementRepository->pushCriteria(new RequestCriteria($request));
        $freightIdeaMeasurements = $this->freightIdeaMeasurementRepository->all();

        return view('freight_idea_measurements.index')
            ->with('freightIdeaMeasurements', $freightIdeaMeasurements);
    }

    /**
     * Show the form for creating a new FreightIdeaMeasurement.
     *
     * @return Response
     */
    public function create()
    {
        return view('freight_idea_measurements.create');
    }

    /**
     * Store a newly created FreightIdeaMeasurement in storage.
     *
     * @param CreateFreightIdeaMeasurementRequest $request
     *
     * @return Response
     */
    public function store(CreateFreightIdeaMeasurementRequest $request)
    {
        $input = $request->all();

        $freightIdeaMeasurement = $this->freightIdeaMeasurementRepository->create($input);

        Flash::success('Freight Idea Measurement saved successfully.');

        return redirect(route('freightIdeaMeasurements.index'));
    }

    /**
     * Display the specified FreightIdeaMeasurement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $freightIdeaMeasurement = $this->freightIdeaMeasurementRepository->findWithoutFail($id);

        if (empty($freightIdeaMeasurement)) {
            Flash::error('Freight Idea Measurement not found');

            return redirect(route('freightIdeaMeasurements.index'));
        }

        return view('freight_idea_measurements.show')->with('freightIdeaMeasurement', $freightIdeaMeasurement);
    }

    /**
     * Show the form for editing the specified FreightIdeaMeasurement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $freightIdeaMeasurement = $this->freightIdeaMeasurementRepository->findWithoutFail($id);

        if (empty($freightIdeaMeasurement)) {
            Flash::error('Freight Idea Measurement not found');

            return redirect(route('freightIdeaMeasurements.index'));
        }

        return view('freight_idea_measurements.edit')->with('freightIdeaMeasurement', $freightIdeaMeasurement);
    }

    /**
     * Update the specified FreightIdeaMeasurement in storage.
     *
     * @param  int              $id
     * @param UpdateFreightIdeaMeasurementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFreightIdeaMeasurementRequest $request)
    {
        $freightIdeaMeasurement = $this->freightIdeaMeasurementRepository->findWithoutFail($id);

        if (empty($freightIdeaMeasurement)) {
            Flash::error('Freight Idea Measurement not found');

            return redirect(route('freightIdeaMeasurements.index'));
        }

        $freightIdeaMeasurement = $this->freightIdeaMeasurementRepository->update($request->all(), $id);

        Flash::success('Freight Idea Measurement updated successfully.');

        return redirect(route('freightIdeaMeasurements.index'));
    }

    /**
     * Remove the specified FreightIdeaMeasurement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $freightIdeaMeasurement = $this->freightIdeaMeasurementRepository->findWithoutFail($id);

        if (empty($freightIdeaMeasurement)) {
            Flash::error('Freight Idea Measurement not found');

            return redirect(route('freightIdeaMeasurements.index'));
        }

        $this->freightIdeaMeasurementRepository->delete($id);

        Flash::success('Freight Idea Measurement deleted successfully.');

        return redirect(route('freightIdeaMeasurements.index'));
    }
}

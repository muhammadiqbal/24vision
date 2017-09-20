<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShipSpecializationRequest;
use App\Http\Requests\UpdateShipSpecializationRequest;
use App\Repositories\ShipSpecializationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ShipSpecializationController extends AppBaseController
{
    /** @var  ShipSpecializationRepository */
    private $shipSpecializationRepository;

    public function __construct(ShipSpecializationRepository $shipSpecializationRepo)
    {
        $this->shipSpecializationRepository = $shipSpecializationRepo;
    }

    /**
     * Display a listing of the ShipSpecialization.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shipSpecializationRepository->pushCriteria(new RequestCriteria($request));
        $shipSpecializations = $this->shipSpecializationRepository->all();

        return view('ship_specializations.index')
            ->with('shipSpecializations', $shipSpecializations);
    }

    /**
     * Show the form for creating a new ShipSpecialization.
     *
     * @return Response
     */
    public function create()
    {
        return view('ship_specializations.create');
    }

    /**
     * Store a newly created ShipSpecialization in storage.
     *
     * @param CreateShipSpecializationRequest $request
     *
     * @return Response
     */
    public function store(CreateShipSpecializationRequest $request)
    {
        $input = $request->all();

        $shipSpecialization = $this->shipSpecializationRepository->create($input);

        Flash::success('Ship Specialization saved successfully.');

        return redirect(route('shipSpecializations.index'));
    }

    /**
     * Display the specified ShipSpecialization.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shipSpecialization = $this->shipSpecializationRepository->findWithoutFail($id);

        if (empty($shipSpecialization)) {
            Flash::error('Ship Specialization not found');

            return redirect(route('shipSpecializations.index'));
        }

        return view('ship_specializations.show')->with('shipSpecialization', $shipSpecialization);
    }

    /**
     * Show the form for editing the specified ShipSpecialization.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shipSpecialization = $this->shipSpecializationRepository->findWithoutFail($id);

        if (empty($shipSpecialization)) {
            Flash::error('Ship Specialization not found');

            return redirect(route('shipSpecializations.index'));
        }

        return view('ship_specializations.edit')->with('shipSpecialization', $shipSpecialization);
    }

    /**
     * Update the specified ShipSpecialization in storage.
     *
     * @param  int              $id
     * @param UpdateShipSpecializationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShipSpecializationRequest $request)
    {
        $shipSpecialization = $this->shipSpecializationRepository->findWithoutFail($id);

        if (empty($shipSpecialization)) {
            Flash::error('Ship Specialization not found');

            return redirect(route('shipSpecializations.index'));
        }

        $shipSpecialization = $this->shipSpecializationRepository->update($request->all(), $id);

        Flash::success('Ship Specialization updated successfully.');

        return redirect(route('shipSpecializations.index'));
    }

    /**
     * Remove the specified ShipSpecialization from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shipSpecialization = $this->shipSpecializationRepository->findWithoutFail($id);

        if (empty($shipSpecialization)) {
            Flash::error('Ship Specialization not found');

            return redirect(route('shipSpecializations.index'));
        }

        $this->shipSpecializationRepository->delete($id);

        Flash::success('Ship Specialization deleted successfully.');

        return redirect(route('shipSpecializations.index'));
    }
}

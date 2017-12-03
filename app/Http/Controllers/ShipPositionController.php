<?php

namespace App\Http\Controllers;

use App\DataTables\ShipPositionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateShipPositionRequest;
use App\Http\Requests\UpdateShipPositionRequest;
use App\Repositories\ShipPositionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Ship;
use App\Models\Port;
use App\Models\Region;

class ShipPositionController extends AppBaseController
{
    /** @var  ShipPositionRepository */
    private $shipPositionRepository;

    public function __construct(ShipPositionRepository $shipPositionRepo)
    {
        $this->shipPositionRepository = $shipPositionRepo;
    }

    /**
     * Display a listing of the ShipPosition.
     *
     * @param ShipPositionDataTable $shipPositionDataTable
     * @return Response
     */
    public function index(ShipPositionDataTable $shipPositionDataTable)
    {
        return $shipPositionDataTable->render('ship_positions.index');
    }

    /**
     * Show the form for creating a new ShipPosition.
     *
     * @return Response
     */
    public function create()
    {
        $ships = Ship::all();
        $regions = Region::all();
        $ports = Port::all();
        return view('ship_positions.create')->with('ships',$ships)
                                            ->with('regions',$regions)
                                            ->with('ports', $ports);
    }

    /**
     * Store a newly created ShipPosition in storage.
     *
     * @param CreateShipPositionRequest $request
     *
     * @return Response
     */
    public function store(CreateShipPositionRequest $request)
    {
        $input = $request->all();

        $shipPosition = $this->shipPositionRepository->create($input);

        Flash::success('Ship Position saved successfully.');

        return redirect(route('shipPositions.index'));
    }

    /**
     * Display the specified ShipPosition.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shipPosition = $this->shipPositionRepository->findWithoutFail($id);

        if (empty($shipPosition)) {
            Flash::error('Ship Position not found');

            return redirect(route('shipPositions.index'));
        }

        return view('ship_positions.show')->with('shipPosition', $shipPosition)
                                          ->with('ships',$ships)
                                          ->with('regions',$regions)
                                          ->with('ports', $ports);
    }

    /**
     * Show the form for editing the specified ShipPosition.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shipPosition = $this->shipPositionRepository->findWithoutFail($id);

        if (empty($shipPosition)) {
            Flash::error('Ship Position not found');

            return redirect(route('shipPositions.index'));
        }

        $ships = Ship::all();
        $regions = Region::all();
        $ports = Port::all();

        return view('ship_positions.edit')->with('shipPosition', $shipPosition);
    }

    /**
     * Update the specified ShipPosition in storage.
     *
     * @param  int              $id
     * @param UpdateShipPositionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShipPositionRequest $request)
    {
        $shipPosition = $this->shipPositionRepository->findWithoutFail($id);

        if (empty($shipPosition)) {
            Flash::error('Ship Position not found');

            return redirect(route('shipPositions.index'));
        }

        $shipPosition = $this->shipPositionRepository->update($request->all(), $id);

        Flash::success('Ship Position updated successfully.');

        return redirect(route('shipPositions.index'));
    }

    /**
     * Remove the specified ShipPosition from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shipPosition = $this->shipPositionRepository->findWithoutFail($id);

        if (empty($shipPosition)) {
            Flash::error('Ship Position not found');

            return redirect(route('shipPositions.index'));
        }

        $this->shipPositionRepository->delete($id);

        Flash::success('Ship Position deleted successfully.');

        return redirect(route('shipPositions.index'));
    }
}

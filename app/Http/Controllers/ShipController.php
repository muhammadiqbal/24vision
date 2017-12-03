<?php

namespace App\Http\Controllers;

use App\DataTables\ShipDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateShipRequest;
use App\Http\Requests\UpdateShipRequest;
use App\Repositories\ShipRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\FuelType;
use App\Models\ShipType;
use App\Models\ShipSpecialization;


class ShipController extends AppBaseController
{
    /** @var  ShipRepository */
    private $shipRepository;

    public function __construct(ShipRepository $shipRepo)
    {
        $this->shipRepository = $shipRepo;
    }

    /**
     * Display a listing of the Ship.
     *
     * @param ShipDataTable $shipDataTable
     * @return Response
     */
    public function index(ShipDataTable $shipDataTable)
    {
        return $shipDataTable->render('ships.index');
    }

    /**
     * Show the form for creating a new Ship.
     *
     * @return Response
     */
    public function create()
    {
        $fuelTypes = FuelType::all();
        $shipTypes = ShipType::all();
        $shipSpecializations = ShipSpecialization::all();
        return view('ships.create')->with('fuelTypes',$fuelTypes)
                                   ->with('shipTypes',$shipTypes)
                                   ->with('shipSpecializations',$shipSpecializations);
    }

    /**
     * Store a newly created Ship in storage.
     *
     * @param CreateShipRequest $request
     *
     * @return Response
     */
    public function store(CreateShipRequest $request)
    {
        $input = $request->all();

        $ship = $this->shipRepository->create($input);

        Flash::success('Ship saved successfully.');

        return redirect(route('ships.index'));
    }

    /**
     * Display the specified Ship.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ship = $this->shipRepository->findWithoutFail($id);

        if (empty($ship)) {
            Flash::error('Ship not found');

            return redirect(route('ships.index'));
        }

        return view('ships.show')->with('ship', $ship);
    }

    /**
     * Show the form for editing the specified Ship.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ship = $this->shipRepository->findWithoutFail($id);

        if (empty($ship)) {
            Flash::error('Ship not found');

            return redirect(route('ships.index'));
        }

        $fuelTypes = FuelType::all();
        $shipTypes = ShipType::all();
        $shipSpecializations = ShipSpecialization::all();

        return view('ships.edit')->with('ship', $ship)
                                 ->with('fuelTypes',$fuelTypes)
                                 ->with('shipTypes',$shipTypes)
                                 ->with('shipSpecializations',$shipSpecializations);;
    }

    /**
     * Update the specified Ship in storage.
     *
     * @param  int              $id
     * @param UpdateShipRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShipRequest $request)
    {
        $ship = $this->shipRepository->findWithoutFail($id);

        if (empty($ship)) {
            Flash::error('Ship not found');

            return redirect(route('ships.index'));
        }

        $ship = $this->shipRepository->update($request->all(), $id);

        Flash::success('Ship updated successfully.');

        return redirect(route('ships.index'));
    }

    /**
     * Remove the specified Ship from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ship = $this->shipRepository->findWithoutFail($id);

        if (empty($ship)) {
            Flash::error('Ship not found');

            return redirect(route('ships.index'));
        }

        $this->shipRepository->delete($id);

        Flash::success('Ship deleted successfully.');

        return redirect(route('ships.index'));
    }
}

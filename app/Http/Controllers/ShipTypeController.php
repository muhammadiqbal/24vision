<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShipTypeRequest;
use App\Http\Requests\UpdateShipTypeRequest;
use App\Repositories\ShipTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ShipTypeController extends AppBaseController
{
    /** @var  ShipTypeRepository */
    private $shipTypeRepository;

    public function __construct(ShipTypeRepository $shipTypeRepo)
    {
        $this->shipTypeRepository = $shipTypeRepo;
    }

    /**
     * Display a listing of the ShipType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shipTypeRepository->pushCriteria(new RequestCriteria($request));
        $shipTypes = $this->shipTypeRepository->all();

        return view('ship_types.index')
            ->with('shipTypes', $shipTypes);
    }

    /**
     * Show the form for creating a new ShipType.
     *
     * @return Response
     */
    public function create()
    {
        return view('ship_types.create');
    }

    /**
     * Store a newly created ShipType in storage.
     *
     * @param CreateShipTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateShipTypeRequest $request)
    {
        $input = $request->all();

        $shipType = $this->shipTypeRepository->create($input);

        Flash::success('Ship Type saved successfully.');

        return redirect(route('shipTypes.index'));
    }

    /**
     * Display the specified ShipType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shipType = $this->shipTypeRepository->findWithoutFail($id);

        if (empty($shipType)) {
            Flash::error('Ship Type not found');

            return redirect(route('shipTypes.index'));
        }

        return view('ship_types.show')->with('shipType', $shipType);
    }

    /**
     * Show the form for editing the specified ShipType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shipType = $this->shipTypeRepository->findWithoutFail($id);

        if (empty($shipType)) {
            Flash::error('Ship Type not found');

            return redirect(route('shipTypes.index'));
        }

        return view('ship_types.edit')->with('shipType', $shipType);
    }

    /**
     * Update the specified ShipType in storage.
     *
     * @param  int              $id
     * @param UpdateShipTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShipTypeRequest $request)
    {
        $shipType = $this->shipTypeRepository->findWithoutFail($id);

        if (empty($shipType)) {
            Flash::error('Ship Type not found');

            return redirect(route('shipTypes.index'));
        }

        $shipType = $this->shipTypeRepository->update($request->all(), $id);

        Flash::success('Ship Type updated successfully.');

        return redirect(route('shipTypes.index'));
    }

    /**
     * Remove the specified ShipType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shipType = $this->shipTypeRepository->findWithoutFail($id);

        if (empty($shipType)) {
            Flash::error('Ship Type not found');

            return redirect(route('shipTypes.index'));
        }

        $this->shipTypeRepository->delete($id);

        Flash::success('Ship Type deleted successfully.');

        return redirect(route('shipTypes.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\ZonePortDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateZonePortRequest;
use App\Http\Requests\UpdateZonePortRequest;
use App\Repositories\ZonePortRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ZonePortController extends AppBaseController
{
    /** @var  ZonePortRepository */
    private $zonePortRepository;

    public function __construct(ZonePortRepository $zonePortRepo)
    {
        $this->zonePortRepository = $zonePortRepo;
    }

    /**
     * Display a listing of the ZonePort.
     *
     * @param ZonePortDataTable $zonePortDataTable
     * @return Response
     */
    public function index(ZonePortDataTable $zonePortDataTable)
    {
        return $zonePortDataTable->render('zone_ports.index');
    }

    /**
     * Show the form for creating a new ZonePort.
     *
     * @return Response
     */
    public function create()
    {
        return view('zone_ports.create');
    }

    /**
     * Store a newly created ZonePort in storage.
     *
     * @param CreateZonePortRequest $request
     *
     * @return Response
     */
    public function store(CreateZonePortRequest $request)
    {
        $input = $request->all();

        $zonePort = $this->zonePortRepository->create($input);

        Flash::success('Zone Port saved successfully.');

        return redirect(route('zonePorts.index'));
    }

    /**
     * Display the specified ZonePort.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $zonePort = $this->zonePortRepository->findWithoutFail($id);

        if (empty($zonePort)) {
            Flash::error('Zone Port not found');

            return redirect(route('zonePorts.index'));
        }

        return view('zone_ports.show')->with('zonePort', $zonePort);
    }

    /**
     * Show the form for editing the specified ZonePort.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $zonePort = $this->zonePortRepository->findWithoutFail($id);

        if (empty($zonePort)) {
            Flash::error('Zone Port not found');

            return redirect(route('zonePorts.index'));
        }

        return view('zone_ports.edit')->with('zonePort', $zonePort);
    }

    /**
     * Update the specified ZonePort in storage.
     *
     * @param  int              $id
     * @param UpdateZonePortRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateZonePortRequest $request)
    {
        $zonePort = $this->zonePortRepository->findWithoutFail($id);

        if (empty($zonePort)) {
            Flash::error('Zone Port not found');

            return redirect(route('zonePorts.index'));
        }

        $zonePort = $this->zonePortRepository->update($request->all(), $id);

        Flash::success('Zone Port updated successfully.');

        return redirect(route('zonePorts.index'));
    }

    /**
     * Remove the specified ZonePort from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $zonePort = $this->zonePortRepository->findWithoutFail($id);

        if (empty($zonePort)) {
            Flash::error('Zone Port not found');

            return redirect(route('zonePorts.index'));
        }

        $this->zonePortRepository->delete($id);

        Flash::success('Zone Port deleted successfully.');

        return redirect(route('zonePorts.index'));
    }
}

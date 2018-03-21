<?php

namespace App\Http\Controllers;

use App\DataTables\ZonePointDataTable;
use App\Http\Requests;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateZonePointRequest;
use App\Http\Requests\UpdateZonePointRequest;
use App\Models\Zone;
use App\Repositories\ZonePointRepository;
use Flash;
use Response;

class ZonePointController extends AppBaseController
{
    /** @var  ZonePointRepository */
    private $zonePointRepository;

    public function __construct(ZonePointRepository $zonePointRepo)
    {
        $this->zonePointRepository = $zonePointRepo;
    }

    /**
     * Display a listing of the ZonePoint.
     *
     * @param ZonePointDataTable $zonePointDataTable
     * @return Response
     */
    public function index(ZonePointDataTable $zonePointDataTable)
    {
        return $zonePointDataTable->render('zone_points.index');
    }

    /**
     * Show the form for creating a new ZonePoint.
     *
     * @return Response
     */
    public function create()
    {
        $zones = Zone::all();
        return view('zone_points.create')->with('zones', $zones);
    }

    /**
     * Store a newly created ZonePoint in storage.
     *
     * @param CreateZonePointRequest $request
     *
     * @return Response
     */
    public function store(CreateZonePointRequest $request)
    {
        $input = $request->all();

        $zonePoint = $this->zonePointRepository->create($input);

        Flash::success('Zone Point saved successfully.');

        return redirect(route('zones.index'));
    }

    /**
     * Display the specified ZonePoint.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $zonePoint = $this->zonePointRepository->findWithoutFail($id);

        if (empty($zonePoint)) {
            Flash::error('Zone Point not found');

            return redirect(route('zonePoints.index'));
        }

        return view('zone_points.show')->with('zonePoint', $zonePoint);
    }

    /**
     * Show the form for editing the specified ZonePoint.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $zonePoint = $this->zonePointRepository->findWithoutFail($id);

        if (empty($zonePoint)) {
            Flash::error('Zone Point not found');

            return redirect(route('zonePoints.index'));
        }

        $zones = Zone::all();

        return view('zone_points.edit')->with('zonePoint', $zonePoint)
                                       ->with('zones', $zones);
    }

    /**
     * Update the specified ZonePoint in storage.
     *
     * @param  int              $id
     * @param UpdateZonePointRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateZonePointRequest $request)
    {
        $zonePoint = $this->zonePointRepository->findWithoutFail($id);

        if (empty($zonePoint)) {
            Flash::error('Zone Point not found');

            return redirect(route('zonePoints.index'));
        }

        $zonePoint = $this->zonePointRepository->update($request->all(), $id);

        Flash::success('Zone Point updated successfully.');

        return redirect(route('zonePoints.index'));
    }

    /**
     * Remove the specified ZonePoint from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $zonePoint = $this->zonePointRepository->findWithoutFail($id);

        if (empty($zonePoint)) {
            Flash::error('Zone Point not found');

            return redirect(route('zonePoints.index'));
        }

        $this->zonePointRepository->delete($id);

        Flash::success('Zone Point deleted successfully.');

        return redirect(route('zonePoints.index'));
    }
}

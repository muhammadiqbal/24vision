<?php

namespace App\Http\Controllers;

use App\DataTables\PortDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePortRequest;
use App\Http\Requests\UpdatePortRequest;
use App\Repositories\PortRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Zone;
use \League\Geotools\Polygon\Polygon;
use \League\Geotools\Coordinate\Coordinate;


class PortController extends AppBaseController
{
    /** @var  PortRepository */
    private $portRepository;

    public function __construct(PortRepository $portRepo)
    {
        $this->portRepository = $portRepo;
    }

    /**
     * Display a listing of the Port.
     *
     * @param PortDataTable $portDataTable
     * @return Response
     */
    public function index(PortDataTable $portDataTable)
    {
        return $portDataTable->render('ports.index');
    }

    /**
     * Show the form for creating a new Port.
     *
     * @return Response
     */
    public function create()
    {
        $zones = Zone::all();
        return view('ports.create')->with('zones', $zones);
    }

    /**
     * Store a newly created Port in storage.
     *
     * @param CreatePortRequest $request
     *
     * @return Response
     */
    public function store(CreatePortRequest $request)
    {
        $input = $request->all();

        $zone = Zone::find($request->get('zone_id'));
        $zonePoints = $zone->zonePoints();
        $polygon = new Polygon($zonePoints);

        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        
        if (!$polygon->pointInPolygon(new Coordinate([$latitude, $longitude]))) {
           Flash::success('ERROR: Port location is not in the zone!');
           return redirect(route('/ports/create'));
        }

        $zonePort = $this->zonePortRepository->create($input);


        $port = $this->portRepository->create($input);

        Flash::success('Port saved successfully.');

        return redirect(route('ports.index'));
    }

    /**
     * Display the specified Port.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $port = $this->portRepository->findWithoutFail($id);

        if (empty($port)) {
            Flash::error('Port not found');

            return redirect(route('ports.index'));
        }

        return view('ports.show')->with('port', $port);
    }

    /**
     * Show the form for editing the specified Port.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $port = $this->portRepository->findWithoutFail($id);

        if (empty($port)) {
            Flash::error('Port not found');

            return redirect(route('ports.index'));
        }
        $zones = Zone::all();
        
        return view('ports.edit')->with('port', $port)
                                 ->with('zones', $zones);
    }

    /**
     * Update the specified Port in storage.
     *
     * @param  int              $id
     * @param UpdatePortRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePortRequest $request)
    {
        $port = $this->portRepository->findWithoutFail($id);

        $zone = Zone::find($request->get('zone_id'));
        $zonePoints = $zone->zonePoints();
        $polygon = new Polygon($zonePoints);

        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        
        if (!$polygon->pointInPolygon(new Coordinate([$latitude, $longitude]))) {
           Flash::success('ERROR: Port location is not in the zone!');
           return redirect(route('/ports/create'));
        }


        if (empty($port)) {
            Flash::error('Port not found');

            return redirect(route('ports.index'));
        }

        $port = $this->portRepository->update($request->all(), $id);

        Flash::success('Port updated successfully.');

        return redirect(route('ports.index'));
    }

    /**
     * Remove the specified Port from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $port = $this->portRepository->findWithoutFail($id);

        if (empty($port)) {
            Flash::error('Port not found');

            return redirect(route('ports.index'));
        }

        $this->portRepository->delete($id);

        Flash::success('Port deleted successfully.');

        return redirect(route('ports.index'));
    }
}

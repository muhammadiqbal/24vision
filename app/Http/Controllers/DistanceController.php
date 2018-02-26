<?php

namespace App\Http\Controllers;

use App\DataTables\DistanceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateDistanceRequest;
use App\Http\Requests\UpdateDistanceRequest;
use App\Repositories\DistanceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Port;

class DistanceController extends AppBaseController
{
    /** @var  DistanceRepository */
    private $distanceRepository;

    public function __construct(DistanceRepository $distanceRepo)
    {
        $this->distanceRepository = $distanceRepo;
    }

    /**
     * Display a listing of the Distance.
     *
     * @param DistanceDataTable $distanceDataTable
     * @return Response
     */
    public function index(DistanceDataTable $distanceDataTable)
    {
        return $distanceDataTable->render('distances.index');
    }

    /**
     * Show the form for creating a new Distance.
     *
     * @return Response
     */
    public function create()
    {
        $ports = Port::all();

        return view('distances.create')->with('ports',$ports);
    }

    /**
     * Store a newly created Distance in storage.
     *
     * @param CreateDistanceRequest $request
     *
     * @return Response
     */
    public function store(CreateDistanceRequest $request)
    {

        $startPort = Port::find($request->get('start_port'));
        $endPort = Port::find($request->get('end_port'));

        $script = 'python3 /PyTools/DistanceCalculator.py '.$startPort->id.' '.$endPort->id.' '.$startPort->latitude.' '.$startPort->longitude.' '.$endPort->latitude.' '.$endPort->longitude;
        $command = escapeshellcmd($script);
        $output = shell_exec($command); 

        Flash::success($output);

        return redirect(route('distances.index'));
    }

    /**
     * Display the specified Distance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $distance = $this->distanceRepository->findWithoutFail($id);

        if (empty($distance)) {
            Flash::error('Distance not found');

            return redirect(route('distances.index'));
        }

        return view('distances.show')->with('distance', $distance);
    }

    /**
     * Show the form for editing the specified Distance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $distance = $this->distanceRepository->findWithoutFail($id);

        if (empty($distance)) {
            Flash::error('Distance not found');

            return redirect(route('distances.index'));
        }

        return view('distances.edit')->with('distance', $distance);
    }

    /**
     * Update the specified Distance in storage.
     *
     * @param  int              $id
     * @param UpdateDistanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDistanceRequest $request)
    {
        $distance = $this->distanceRepository->findWithoutFail($id);

        if (empty($distance)) {
            Flash::error('Distance not found');

            return redirect(route('distances.index'));
        }

        $distance = $this->distanceRepository->update($request->all(), $id);

        Flash::success('Distance updated successfully.');

        return redirect(route('distances.index'));
    }

    /**
     * Remove the specified Distance from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $distance = $this->distanceRepository->findWithoutFail($id);

        if (empty($distance)) {
            Flash::error('Distance not found');

            return redirect(route('distances.index'));
        }

        $this->distanceRepository->delete($id);

        Flash::success('Distance deleted successfully.');

        return redirect(route('distances.index'));
    }
}

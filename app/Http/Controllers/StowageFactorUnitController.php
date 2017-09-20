<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStowageFactorUnitRequest;
use App\Http\Requests\UpdateStowageFactorUnitRequest;
use App\Repositories\StowageFactorUnitRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StowageFactorUnitController extends AppBaseController
{
    /** @var  StowageFactorUnitRepository */
    private $stowageFactorUnitRepository;

    public function __construct(StowageFactorUnitRepository $stowageFactorUnitRepo)
    {
        $this->stowageFactorUnitRepository = $stowageFactorUnitRepo;
    }

    /**
     * Display a listing of the StowageFactorUnit.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->stowageFactorUnitRepository->pushCriteria(new RequestCriteria($request));
        $stowageFactorUnits = $this->stowageFactorUnitRepository->all();

        return view('stowage_factor_units.index')
            ->with('stowageFactorUnits', $stowageFactorUnits);
    }

    /**
     * Show the form for creating a new StowageFactorUnit.
     *
     * @return Response
     */
    public function create()
    {
        return view('stowage_factor_units.create');
    }

    /**
     * Store a newly created StowageFactorUnit in storage.
     *
     * @param CreateStowageFactorUnitRequest $request
     *
     * @return Response
     */
    public function store(CreateStowageFactorUnitRequest $request)
    {
        $input = $request->all();

        $stowageFactorUnit = $this->stowageFactorUnitRepository->create($input);

        Flash::success('Stowage Factor Unit saved successfully.');

        return redirect(route('stowageFactorUnits.index'));
    }

    /**
     * Display the specified StowageFactorUnit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $stowageFactorUnit = $this->stowageFactorUnitRepository->findWithoutFail($id);

        if (empty($stowageFactorUnit)) {
            Flash::error('Stowage Factor Unit not found');

            return redirect(route('stowageFactorUnits.index'));
        }

        return view('stowage_factor_units.show')->with('stowageFactorUnit', $stowageFactorUnit);
    }

    /**
     * Show the form for editing the specified StowageFactorUnit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $stowageFactorUnit = $this->stowageFactorUnitRepository->findWithoutFail($id);

        if (empty($stowageFactorUnit)) {
            Flash::error('Stowage Factor Unit not found');

            return redirect(route('stowageFactorUnits.index'));
        }

        return view('stowage_factor_units.edit')->with('stowageFactorUnit', $stowageFactorUnit);
    }

    /**
     * Update the specified StowageFactorUnit in storage.
     *
     * @param  int              $id
     * @param UpdateStowageFactorUnitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStowageFactorUnitRequest $request)
    {
        $stowageFactorUnit = $this->stowageFactorUnitRepository->findWithoutFail($id);

        if (empty($stowageFactorUnit)) {
            Flash::error('Stowage Factor Unit not found');

            return redirect(route('stowageFactorUnits.index'));
        }

        $stowageFactorUnit = $this->stowageFactorUnitRepository->update($request->all(), $id);

        Flash::success('Stowage Factor Unit updated successfully.');

        return redirect(route('stowageFactorUnits.index'));
    }

    /**
     * Remove the specified StowageFactorUnit from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $stowageFactorUnit = $this->stowageFactorUnitRepository->findWithoutFail($id);

        if (empty($stowageFactorUnit)) {
            Flash::error('Stowage Factor Unit not found');

            return redirect(route('stowageFactorUnits.index'));
        }

        $this->stowageFactorUnitRepository->delete($id);

        Flash::success('Stowage Factor Unit deleted successfully.');

        return redirect(route('stowageFactorUnits.index'));
    }
}

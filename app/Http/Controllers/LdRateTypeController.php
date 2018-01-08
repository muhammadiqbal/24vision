<?php

namespace App\Http\Controllers;

use App\DataTables\LdRateTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLdRateTypeRequest;
use App\Http\Requests\UpdateLdRateTypeRequest;
use App\Repositories\LdRateTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LdRateTypeController extends AppBaseController
{
    /** @var  LdRateTypeRepository */
    private $ldRateTypeRepository;

    public function __construct(LdRateTypeRepository $ldRateTypeRepo)
    {
        $this->ldRateTypeRepository = $ldRateTypeRepo;
    }

    /**
     * Display a listing of the LdRateType.
     *
     * @param LdRateTypeDataTable $ldRateTypeDataTable
     * @return Response
     */
    public function index(LdRateTypeDataTable $ldRateTypeDataTable)
    {
        return $ldRateTypeDataTable->render('ld_rate_types.index');
    }

    /**
     * Show the form for creating a new LdRateType.
     *
     * @return Response
     */
    public function create()
    {
        return view('ld_rate_types.create');
    }

    /**
     * Store a newly created LdRateType in storage.
     *
     * @param CreateLdRateTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateLdRateTypeRequest $request)
    {
        $input = $request->all();

        $ldRateType = $this->ldRateTypeRepository->create($input);

        Flash::success('Ld Rate Type saved successfully.');

        return redirect(route('ldRateTypes.index'));
    }

    /**
     * Display the specified LdRateType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ldRateType = $this->ldRateTypeRepository->findWithoutFail($id);

        if (empty($ldRateType)) {
            Flash::error('Ld Rate Type not found');

            return redirect(route('ldRateTypes.index'));
        }

        return view('ld_rate_types.show')->with('ldRateType', $ldRateType);
    }

    /**
     * Show the form for editing the specified LdRateType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ldRateType = $this->ldRateTypeRepository->findWithoutFail($id);

        if (empty($ldRateType)) {
            Flash::error('Ld Rate Type not found');

            return redirect(route('ldRateTypes.index'));
        }

        return view('ld_rate_types.edit')->with('ldRateType', $ldRateType);
    }

    /**
     * Update the specified LdRateType in storage.
     *
     * @param  int              $id
     * @param UpdateLdRateTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLdRateTypeRequest $request)
    {
        $ldRateType = $this->ldRateTypeRepository->findWithoutFail($id);

        if (empty($ldRateType)) {
            Flash::error('Ld Rate Type not found');

            return redirect(route('ldRateTypes.index'));
        }

        $ldRateType = $this->ldRateTypeRepository->update($request->all(), $id);

        Flash::success('Ld Rate Type updated successfully.');

        return redirect(route('ldRateTypes.index'));
    }

    /**
     * Remove the specified LdRateType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ldRateType = $this->ldRateTypeRepository->findWithoutFail($id);

        if (empty($ldRateType)) {
            Flash::error('Ld Rate Type not found');

            return redirect(route('ldRateTypes.index'));
        }

        $this->ldRateTypeRepository->delete($id);

        Flash::success('Ld Rate Type deleted successfully.');

        return redirect(route('ldRateTypes.index'));
    }
}

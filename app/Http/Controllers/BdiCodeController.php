<?php

namespace App\Http\Controllers;

use App\DataTables\BdiCodeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateBdiCodeRequest;
use App\Http\Requests\UpdateBdiCodeRequest;
use App\Repositories\BdiCodeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class BdiCodeController extends AppBaseController
{
    /** @var  BdiCodeRepository */
    private $bdiCodeRepository;

    public function __construct(BdiCodeRepository $bdiCodeRepo)
    {
        $this->bdiCodeRepository = $bdiCodeRepo;
    }

    /**
     * Display a listing of the BdiCode.
     *
     * @param BdiCodeDataTable $bdiCodeDataTable
     * @return Response
     */
    public function index(BdiCodeDataTable $bdiCodeDataTable)
    {
        return $bdiCodeDataTable->render('bdi_codes.index');
    }

    /**
     * Show the form for creating a new BdiCode.
     *
     * @return Response
     */
    public function create()
    {
        return view('bdi_codes.create');
    }

    /**
     * Store a newly created BdiCode in storage.
     *
     * @param CreateBdiCodeRequest $request
     *
     * @return Response
     */
    public function store(CreateBdiCodeRequest $request)
    {
        $input = $request->all();

        $bdiCode = $this->bdiCodeRepository->create($input);

        Flash::success('Bdi Code saved successfully.');

        return redirect(route('bdiCodes.index'));
    }

    /**
     * Display the specified BdiCode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bdiCode = $this->bdiCodeRepository->findWithoutFail($id);

        if (empty($bdiCode)) {
            Flash::error('Bdi Code not found');

            return redirect(route('bdiCodes.index'));
        }

        return view('bdi_codes.show')->with('bdiCode', $bdiCode);
    }

    /**
     * Show the form for editing the specified BdiCode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bdiCode = $this->bdiCodeRepository->findWithoutFail($id);

        if (empty($bdiCode)) {
            Flash::error('Bdi Code not found');

            return redirect(route('bdiCodes.index'));
        }

        return view('bdi_codes.edit')->with('bdiCode', $bdiCode);
    }

    /**
     * Update the specified BdiCode in storage.
     *
     * @param  int              $id
     * @param UpdateBdiCodeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBdiCodeRequest $request)
    {
        $bdiCode = $this->bdiCodeRepository->findWithoutFail($id);

        if (empty($bdiCode)) {
            Flash::error('Bdi Code not found');

            return redirect(route('bdiCodes.index'));
        }

        $bdiCode = $this->bdiCodeRepository->update($request->all(), $id);

        Flash::success('Bdi Code updated successfully.');

        return redirect(route('bdiCodes.index'));
    }

    /**
     * Remove the specified BdiCode from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bdiCode = $this->bdiCodeRepository->findWithoutFail($id);

        if (empty($bdiCode)) {
            Flash::error('Bdi Code not found');

            return redirect(route('bdiCodes.index'));
        }

        $this->bdiCodeRepository->delete($id);

        Flash::success('Bdi Code deleted successfully.');

        return redirect(route('bdiCodes.index'));
    }
}

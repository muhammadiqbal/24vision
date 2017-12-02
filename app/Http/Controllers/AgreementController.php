<?php

namespace App\Http\Controllers;

use App\DataTables\AgreementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAgreementRequest;
use App\Http\Requests\UpdateAgreementRequest;
use App\Repositories\AgreementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AgreementController extends AppBaseController
{
    /** @var  AgreementRepository */
    private $agreementRepository;

    public function __construct(AgreementRepository $agreementRepo)
    {
        $this->agreementRepository = $agreementRepo;
    }

    /**
     * Display a listing of the Agreement.
     *
     * @param AgreementDataTable $agreementDataTable
     * @return Response
     */
    public function index(AgreementDataTable $agreementDataTable)
    {
        return $agreementDataTable->render('agreements.index');
    }

    /**
     * Show the form for creating a new Agreement.
     *
     * @return Response
     */
    public function create()
    {
        return view('agreements.create');
    }

    /**
     * Store a newly created Agreement in storage.
     *
     * @param CreateAgreementRequest $request
     *
     * @return Response
     */
    public function store(CreateAgreementRequest $request)
    {
        $input = $request->all();

        $agreement = $this->agreementRepository->create($input);

        Flash::success('Agreement saved successfully.');

        return redirect(route('agreements.index'));
    }

    /**
     * Display the specified Agreement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agreement = $this->agreementRepository->findWithoutFail($id);

        if (empty($agreement)) {
            Flash::error('Agreement not found');

            return redirect(route('agreements.index'));
        }

        return view('agreements.show')->with('agreement', $agreement);
    }

    /**
     * Show the form for editing the specified Agreement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agreement = $this->agreementRepository->findWithoutFail($id);

        if (empty($agreement)) {
            Flash::error('Agreement not found');

            return redirect(route('agreements.index'));
        }

        return view('agreements.edit')->with('agreement', $agreement);
    }

    /**
     * Update the specified Agreement in storage.
     *
     * @param  int              $id
     * @param UpdateAgreementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgreementRequest $request)
    {
        $agreement = $this->agreementRepository->findWithoutFail($id);

        if (empty($agreement)) {
            Flash::error('Agreement not found');

            return redirect(route('agreements.index'));
        }

        $agreement = $this->agreementRepository->update($request->all(), $id);

        Flash::success('Agreement updated successfully.');

        return redirect(route('agreements.index'));
    }

    /**
     * Remove the specified Agreement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agreement = $this->agreementRepository->findWithoutFail($id);

        if (empty($agreement)) {
            Flash::error('Agreement not found');

            return redirect(route('agreements.index'));
        }

        $this->agreementRepository->delete($id);

        Flash::success('Agreement deleted successfully.');

        return redirect(route('agreements.index'));
    }
}

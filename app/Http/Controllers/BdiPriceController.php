<?php

namespace App\Http\Controllers;

use App\DataTables\BdiPriceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateBdiPriceRequest;
use App\Http\Requests\UpdateBdiPriceRequest;
use App\Repositories\BdiPriceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class BdiPriceController extends AppBaseController
{
    /** @var  BdiPriceRepository */
    private $bdiPriceRepository;

    public function __construct(BdiPriceRepository $bdiPriceRepo)
    {
        $this->bdiPriceRepository = $bdiPriceRepo;
    }

    /**
     * Display a listing of the BdiPrice.
     *
     * @param BdiPriceDataTable $bdiPriceDataTable
     * @return Response
     */
    public function index(BdiPriceDataTable $bdiPriceDataTable)
    {
        return $bdiPriceDataTable->render('bdi_prices.index');
    }

    /**
     * Show the form for creating a new BdiPrice.
     *
     * @return Response
     */
    public function create()
    {
        return view('bdi_prices.create');
    }

    /**
     * Store a newly created BdiPrice in storage.
     *
     * @param CreateBdiPriceRequest $request
     *
     * @return Response
     */
    public function store(CreateBdiPriceRequest $request)
    {
        $input = $request->all();

        $bdiPrice = $this->bdiPriceRepository->create($input);

        Flash::success('Bdi Price saved successfully.');

        return redirect(route('bdiPrices.index'));
    }

    /**
     * Display the specified BdiPrice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bdiPrice = $this->bdiPriceRepository->findWithoutFail($id);

        if (empty($bdiPrice)) {
            Flash::error('Bdi Price not found');

            return redirect(route('bdiPrices.index'));
        }

        return view('bdi_prices.show')->with('bdiPrice', $bdiPrice);
    }

    /**
     * Show the form for editing the specified BdiPrice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bdiPrice = $this->bdiPriceRepository->findWithoutFail($id);

        if (empty($bdiPrice)) {
            Flash::error('Bdi Price not found');

            return redirect(route('bdiPrices.index'));
        }

        return view('bdi_prices.edit')->with('bdiPrice', $bdiPrice);
    }

    /**
     * Update the specified BdiPrice in storage.
     *
     * @param  int              $id
     * @param UpdateBdiPriceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBdiPriceRequest $request)
    {
        $bdiPrice = $this->bdiPriceRepository->findWithoutFail($id);

        if (empty($bdiPrice)) {
            Flash::error('Bdi Price not found');

            return redirect(route('bdiPrices.index'));
        }

        $bdiPrice = $this->bdiPriceRepository->update($request->all(), $id);

        Flash::success('Bdi Price updated successfully.');

        return redirect(route('bdiPrices.index'));
    }

    /**
     * Remove the specified BdiPrice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bdiPrice = $this->bdiPriceRepository->findWithoutFail($id);

        if (empty($bdiPrice)) {
            Flash::error('Bdi Price not found');

            return redirect(route('bdiPrices.index'));
        }

        $this->bdiPriceRepository->delete($id);

        Flash::success('Bdi Price deleted successfully.');

        return redirect(route('bdiPrices.index'));
    }
}

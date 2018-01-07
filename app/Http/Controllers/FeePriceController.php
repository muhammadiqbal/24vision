<?php

namespace App\Http\Controllers;

use App\DataTables\FeePriceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFeePriceRequest;
use App\Http\Requests\UpdateFeePriceRequest;
use App\Repositories\FeePriceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class FeePriceController extends AppBaseController
{
    /** @var  FeePriceRepository */
    private $feePriceRepository;

    public function __construct(FeePriceRepository $feePriceRepo)
    {
        $this->feePriceRepository = $feePriceRepo;
    }

    /**
     * Display a listing of the FeePrice.
     *
     * @param FeePriceDataTable $feePriceDataTable
     * @return Response
     */
    public function index(FeePriceDataTable $feePriceDataTable)
    {
        return $feePriceDataTable->render('fee_prices.index');
    }

    /**
     * Show the form for creating a new FeePrice.
     *
     * @return Response
     */
    public function create()
    {
        return view('fee_prices.create');
    }

    /**
     * Store a newly created FeePrice in storage.
     *
     * @param CreateFeePriceRequest $request
     *
     * @return Response
     */
    public function store(CreateFeePriceRequest $request)
    {
        $input = $request->all();

        $feePrice = $this->feePriceRepository->create($input);

        Flash::success('Fee Price saved successfully.');

        return redirect(route('feePrices.index'));
    }

    /**
     * Display the specified FeePrice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $feePrice = $this->feePriceRepository->findWithoutFail($id);

        if (empty($feePrice)) {
            Flash::error('Fee Price not found');

            return redirect(route('feePrices.index'));
        }

        return view('fee_prices.show')->with('feePrice', $feePrice);
    }

    /**
     * Show the form for editing the specified FeePrice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $feePrice = $this->feePriceRepository->findWithoutFail($id);

        if (empty($feePrice)) {
            Flash::error('Fee Price not found');

            return redirect(route('feePrices.index'));
        }

        return view('fee_prices.edit')->with('feePrice', $feePrice);
    }

    /**
     * Update the specified FeePrice in storage.
     *
     * @param  int              $id
     * @param UpdateFeePriceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFeePriceRequest $request)
    {
        $feePrice = $this->feePriceRepository->findWithoutFail($id);

        if (empty($feePrice)) {
            Flash::error('Fee Price not found');

            return redirect(route('feePrices.index'));
        }

        $feePrice = $this->feePriceRepository->update($request->all(), $id);

        Flash::success('Fee Price updated successfully.');

        return redirect(route('feePrices.index'));
    }

    /**
     * Remove the specified FeePrice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $feePrice = $this->feePriceRepository->findWithoutFail($id);

        if (empty($feePrice)) {
            Flash::error('Fee Price not found');

            return redirect(route('feePrices.index'));
        }

        $this->feePriceRepository->delete($id);

        Flash::success('Fee Price deleted successfully.');

        return redirect(route('feePrices.index'));
    }
}

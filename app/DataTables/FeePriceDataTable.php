<?php

namespace App\DataTables;

use App\Models\FeePrice;
use Form;
use Yajra\DataTables\Services\DataTable;

class FeePriceDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'fee_prices.datatables_actions')
            ->editColumn('start_date', function(FeePrice $feePrices){
               return date_format(date_create($feePrices->start_date),'d-m-Y');
            })
            ->editColumn('end_date', function(FeePrice $feePrices){
               return date_format(date_create($feePrices->end_date),'d-m-Y');
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $feePrices = FeePrice::leftjoin('ports', 'fee_prices.port_id','ports.id')
                               ->select('fee_prices.*', 'ports.name as port');

        return $this->applyScopes($feePrices);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             'csv',
                             'excel',
                             'pdf',
                         ],
                    ],
                    'colvis'
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'port_id' => ['name' => 'port', 'data' => 'port', 'searchable'=>false],
            'start_date' => ['name' => 'start_date', 'data' => 'start_date'],
            'end_date' => ['name' => 'end_date', 'data' => 'end_date'],
            'price' => ['name' => 'price', 'data' => 'price']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'feePrices';
    }
}

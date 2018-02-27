<?php

namespace App\DataTables;

use App\Models\Ship;
use Yajra\DataTables\Services\DataTable;

class ShipDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'ships.datatables_actions')
            ->editColumn('year_of_build', function(Ship $ship){
               return date_format(date_create($ship->year_of_build),'Y');
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
        $ships = Ship::leftjoin('ship_types','ship_type_id','=','ship_types.id')
                      // ->leftjoin('ship_specializations','ship_specialization_id','=','ship_specializations.id')
                      // ->leftjoin('fuel_types','fuel_type_id','=','fuel_types.id')
                       ->select('ships.*','ship_types.name as type','ship_specializations.name as specialization', 'fuel_types.name as fuel');
        $ships = Ship::query();

        return $this->applyScopes($ships);
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
            'name' => ['name' => 'name', 'data' => 'name'],
            'imo' => ['name' => 'imo', 'data' => 'imo'],
            'year_of_build' => ['name' => 'year_of_build', 'data' => 'year_of_build'],
            'dwcc' => ['name' => 'dwcc', 'data' => 'dwcc'],
            'max_holds_capacity' => ['name' => 'max_holds_capacity', 'data' => 'max_holds_capacity'],
            //'ballast_draft' => ['name' => 'ballast_draft', 'data' => 'ballast_draft'],
            //'max_laden_draft' => ['name' => 'max_laden_draft', 'data' => 'max_laden_draft'],
            //'draft_per_tonnage' => ['name' => 'draft_per_tonnage', 'data' => 'draft_per_tonnage'],
            //'speed_laden' => ['name' => 'speed_laden', 'data' => 'speed_laden'],
            //'speed_ballast' => ['name' => 'speed_ballast', 'data' => 'speed_ballast'],
            //'fuel_type_id' => ['name' => 'fuel', 'data' => 'fuel'],
            //'fuel_consumption_at_sea' => ['name' => 'fuel_consumption_at_sea', 'data' => 'fuel_consumption_at_sea'],
            //'fuel_consumption_in_port' => ['name' => 'fuel_consumption_in_port', 'data' => 'fuel_consumption_in_port'],
            'flag' => ['name' => 'flag', 'data' => 'flag'],
            'ship_type_id' => ['name' => 'type', 'data' => 'type'],
            //'ship_specialization_id' => ['name' => 'specialization', 'data' => 'specialization'],
            //'gear_onboard' => ['name' => 'gear_onboard', 'data' => 'gear_onboard'],
            //'additional_information' => ['name' => 'additional_information', 'data' => 'additional_information']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ships';
    }
}

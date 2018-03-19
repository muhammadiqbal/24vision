<?php

namespace App\DataTables;

use App\Models\Cargo;
use Form;
use Yajra\DataTables\Services\DataTable;


class CargoDataTable extends DataTable
{
    protected $null = '<b style=\'color:blue;\'>NULL</b>';

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->of($this->query())
            ->addColumn('action', 'cargos.datatables_actions')
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw("status like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('type', function($query, $keyword) {
                $query->whereRaw("type like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw("p1.name like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw("p1.name like ?", ["%{$keyword}%"]);
            })
            ->editColumn('cargo_type_id', function(Cargo $cargo){
                if ($cargo->cargo_type_id_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->type.'</b>';
                } else {                
                    return $cargo->type;
                }               
            })
            ->editColumn('quantity', function(Cargo $cargo){
                if ($cargo->quantity_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->quantity.'</b>';
                }elseif ($cargo->quantity_constructed) {
                    return '<b style=\'color:green;\'>'.$cargo->quantity.'</b>';
                } else {                
                    return $cargo->quantity;
                }               
            })
            ->editColumn('laycan_first_day', function(Cargo $cargo){
                if ($cargo->laycan_first_day == null){
                    return null;
                }elseif($cargo->laycan_first_day_manual) {
                    return '<b style=\'color:red;\'>'.date('d-m-Y',strtotime($cargo->laycan_first_day)).'</b>';
                }elseif ($cargo->laycan_first_day_constructed) {
                    return '<b style=\'color:green;\'>'.date('d-m-Y',strtotime($cargo->laycan_first_day)).'</b>';
                }else {                
                    return date('d-m-Y',strtotime($cargo->laycan_first_day));
                }               
            })
            ->editColumn('laycan_last_day', function(Cargo $cargo){
                if ($cargo->laycan_last_day == null){
                    return null;
                }elseif($cargo->laycan_last_day_manual) {
                    return '<b style=\'color:red;\'>'.date('d-m-Y',strtotime($cargo->laycan_last_day)).'</b>';
                } elseif ($cargo->laycan_last_day_constructed) {
                    return '<b style=\'color:green;\'>'.date('d-m-Y',strtotime($cargo->laycan_last_day)).'</b>';
                } else {                
                    return date('d-m-Y',strtotime($cargo->laycan_last_day));
                }
            })
            ->editColumn('loading_port',function(Cargo $cargo){
                if ($cargo->loading_port_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->load_port.'</b>';
                }else{
                    return $cargo->load_port;
                }
            })
            ->editColumn('discharging_port',function(Cargo $cargo){
                if ($cargo->discharging_port_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->disch_port.'</b>';
                }else{
                    return $cargo->disch_port;
                }
            })
            ->rawColumns(['action','cargo_type_id', 'quantity','laycan_first_day','laycan_last_day','loading_port','discharging_port'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

        $cargos = Cargo::leftjoin('cargo_status', 'cargo_status.id','cargos.status_id')
                        ->leftjoin('cargo_types', 'cargos.cargo_type_id','cargo_types.id')
                        ->leftjoin('loading_discharging_rate_type as load_type', 'cargos.loading_rate_type','load_type.id')
                        ->leftjoin('loading_discharging_rate_type as disch_type', 'cargos.discharging_rate_type','disch_type.id')
                        ->leftjoin('ports as p1', 'p1.id','loading_port')
                        ->leftjoin('ports as p2', 'p2.id','discharging_port')
                        ->select('cargos.*','cargo_status.name as status','cargo_types.name as type', 'p1.name as load_port', 'p2.name as disch_port', 'load_type.name as l_type', 'disch_type.name as d_type');
                        ->orderBy('email_id','desc');

        if($this->request()->get('laycan_first_day')){
            $cargos->where('laycan_first_day','<=',$this->request()->get('laycan_first_day' ));
        }

        if($this->request()->get('laycan_last_day')){
            $cargos->where('laycan_last_day','>=',$this->request()->get('laycan_last_day' ));
        }

        if($this->request()->get('statusoption')){
            $cargos->whereIn('status_id',$this->request()->get('statusoption' ));
        }


        return $this->applyScopes($cargos);
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
            ->addAction(['width' => '20%'])
            ->ajax(''," 
                data: function (d) {
                d.laycan_first_day = $('input[name=laycan_first_day]').val();
                d.laycan_last_day = $('input[name=laycan_last_day]').val();
                d.statusoption = $('input[name=statusoption]').val();
                
            }")
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => true,
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
            
            'cargo_type_id' => ['defaultContent' => $this->null,'name' => 'type', 'data' => 'type', 'searchable'=> false],
            'quantity' => ['defaultContent' => $this->null,'name' => 'quantity', 'data' => 'quantity'],
            'loading_port' => ['defaultContent' => $this->null, 'name' => 'load_port', 'data' => 'load_port', 'searchable'=> false],
            'discharging_port' => ['defaultContent' => $this->null,'name' => 'disch_port', 'data' => 'disch_port', 'searchable'=> false],
            'laycan_first_day' => ['defaultContent' => $this->null,'name' => 'laycan_first_day', 'data' => 'laycan_first_day'],
            'laycan_last_day' => ['defaultContent' => $this->null,'name' => 'laycan_last_day', 'data' => 'laycan_last_day'],
            'loading_rate' => ['defaultContent' => $this->null,'name' => 'loading_rate', 'data' => 'loading_rate'],
            'loading_rate_type' => ['defaultContent' => $this->null,'name' => 'l_type', 'data' => 'l_type', 'searchable'=> false],
            'discharging_rate'=>['defaultContent' => $this->null,'name' => 'discharging_rate', 'data' => 'discharging_rate'],
            'discharging_rate_type'=>['defaultContent' => $this->null,'name' => 'd_type', 'data' => 'd_type', 'searchable'=> false],
            'stowage_factor' => ['defaultContent' => $this->null,'name' => 'stowage_factor', 'data' => 'stowage_factor' ],
            'commission' => ['defaultContent' => $this->null,'name' => 'commission', 'data' => 'commission'],
            'email_id' => ['defaultContent' => $this->null,'name' => 'email_id', 'data' => 'email_id'],
            'status_id' => ['defaultContent' => $this->null,'name' => 'status', 'data' => 'status','searchable'=> false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'cargos';
    }
}

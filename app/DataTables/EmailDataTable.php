<?php

namespace App\DataTables;

use App\Models\Email;
use Form;
use Yajra\DataTables\Services\DataTable;

class EmailDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'emails.datatables_actions')
            ->editColumn('date', function(Email $email){
                    return date_format(date_create($email->date),'d-m-Y');
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
        $emails = Email::orderBy('date','desc')->select('email.*');
        if ($this->request()->get('type')) {
            $emails->where('classification_automated',$this->request()->get('type'));
        }

        return $this->applyScopes($emails);
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
                ]
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
            'subject' => ['defaultContent' => 'NULL','name' => 'subject', 'data' => 'subject'],
            //'body' => ['name' => 'body', 'data' => 'body'],
            'sender' => ['defaultContent' => 'NULL','name' => 'sender', 'data' => 'sender'],
            //'receiver' => ['name' => 'receiver', 'data' => 'receiver'],
            //'cc' => ['name' => 'cc', 'data' => 'cc'],
            //'classification_manual' => ['name' => 'classification_manual', 'data' => 'classification_manual'],
            'date' => ['defaultContent' => 'NULL','name' => 'date', 'data' => 'date'],
            //'classification_automated' => ['name' => 'classification_automated', 'data' => 'classification_automated'],
            //'IMAPUID' => ['name' => 'IMAPUID', 'data' => 'IMAPUID'],
            //'IMAPFolderID' => ['name' => 'IMAPFolderID', 'data' => 'IMAPFolderID'],
            //'_created_on' => ['name' => '_created_on', 'data' => '_created_on'],
            //'classification_automated_certainty' => ['name' => 'classification_automated_certainty', 'data' => 'classification_automated_certainty'],
            //'kibana_extracted' => ['name' => 'kibana_extracted', 'data' => 'kibana_extracted']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'emails';
    }
}

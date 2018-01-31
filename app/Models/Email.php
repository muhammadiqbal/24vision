<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //
    protected $connection = 'mysql2';

    public $table = 'email';

    protected $primaryKey = 'emailID';

    public $fillable = [
        'subject',
        'body',
        'sender',
        'cc',
        'receiver',
        'classification_manual',
        'classification_automated',
        'IMAPUID',
        'IMAPFolderID',
        '_created_on',
        'classification_automated_certainty',
        'kibana_extracted'
    ];

        /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}

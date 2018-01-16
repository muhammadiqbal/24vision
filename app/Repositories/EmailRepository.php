<?php

namespace App\Repositories;

use App\Models\Email;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DistanceRepository
 * @package App\Repositories
 * @version January 8, 2018, 10:03 am UTC
 *
 * @method Email findWithoutFail($id, $columns = ['*'])
 * @method Email find($id, $columns = ['*'])
 * @method Email first($columns = ['*'])
*/
class EmailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return Email::class;
    }
}

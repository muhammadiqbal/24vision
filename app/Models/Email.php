<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Email
 * @package App\Models
 * @version February 3, 2018, 10:15 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection cargoOfferExtracted
 * @property \Illuminate\Database\Eloquent\Collection shipOffer
 * @property \Illuminate\Database\Eloquent\Collection shipOfferExtracted
 * @property \Illuminate\Database\Eloquent\Collection shipOrderExtracted
 * @property string subject
 * @property string body
 * @property string sender
 * @property string receiver
 * @property string cc
 * @property string classification_manual
 * @property string|\Carbon\Carbon date
 * @property string classification_automated
 * @property string IMAPUID
 * @property integer IMAPFolderID
 * @property string|\Carbon\Carbon _created_on
 * @property decimal classification_automated_certainty
 * @property boolean kibana_extracted
 */
class Email extends Model
{
    //use SoftDeletes;

    public $table = 'email';

    protected $primaryKey = 'emailID';

    public $timestamps = false;

    protected $dates = ['deleted_at'];


    public $fillable = [
        'subject',
        'body',
        'sender',
        'receiver',
        'cc',
        'classification_manual',
        'date',
        'classification_automated',
        'IMAPUID',
        'IMAPFolderID',
        '_created_on',
        'classification_automated_certainty',
        'kibana_extracted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'emailID' => 'integer',
        'subject' => 'string',
        'body' => 'string',
        'sender' => 'string',
        'receiver' => 'string',
        'cc' => 'string',
        'classification_manual' => 'string',
        'classification_automated' => 'string',
        'IMAPUID' => 'string',
        'IMAPFolderID' => 'integer',
        'kibana_extracted' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function cargoOffers()
    {
        return $this->belongsToMany(\App\Models\CargoOffer::class, 'cargo_offer_extracted');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function shipOffers()
    {
        return $this->belongsToMany(\App\Models\ShipOffer::class, 'ship_offer_extracted');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function shipOrders()
    {
        return $this->belongsToMany(\App\Models\ShipOrder::class, 'ship_order_extracted');
    }
}

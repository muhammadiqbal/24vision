<?php

namespace App\Http\Requests\API;

use App\Models\Bdi;
use InfyOm\Generator\Request\APIRequest;

class UpdateBdiAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Bdi::$rules;
    }
}

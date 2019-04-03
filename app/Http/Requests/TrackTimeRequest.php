<?php

namespace App\Http\Requests;

use App\Ship\Abstraction\Request;

class TrackTimeRequest extends Request
{
    protected $urlParameters = [

    ];

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
        return [
            'what' => 'required|string|in:project,issue',
            'id' => 'required|integer',
            'hours' => 'required|integer'
        ];
    }
}

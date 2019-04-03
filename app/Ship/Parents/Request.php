<?php

namespace App\Ship\Abstraction;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request (with з Apiato)
 * @package App\Ship\Abstraction
 */
abstract class Request extends FormRequest
{
    protected $urlParameters = [];

    /**
     * Overriding this function to modify the any user input before
     * applying the validation rules.
     *
     * @param null $keys
     *
     * @return  array
     */
    public function all($keys = null)
    {
        $requestData = parent::all($keys);

        $requestData = $this->mergeUrlParametersWithRequestData($requestData);

        return $requestData;
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function mergeUrlParametersWithRequestData(Array $requestData)
    {
        if (isset($this->urlParameters) && !empty($this->urlParameters)) {
            foreach ($this->urlParameters as $param) {
                $requestData[$param] = $this->route($param);
            }
        }
        return $requestData;
    }
}

<?php

namespace Core\Resource\Validation;

use Illuminate\Support\Facades\Validator;
use Core\System\Contracts\ValidationContract;

class ResourceValidation implements ValidationContract
{
    /**
     * The validation function, returns new validator.
     *
     * @param $data
     * @param bool $resourceID
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data, $resourceID = false)
    {
        if ($resourceID) {
            return Validator::make($data, $this->rules($resourceID), $this->messages());
        }

        return Validator::make($data, $this->rules(), $this->messages());
    }

    /**
     * Get the validation rules that apply to a resource.
     *
     * @param bool $resourceID
     * @return array
     */
    public function rules($resourceID = false)
    {
        $rules = [
            'name' => 'required|unique:resources,name',
            'friendly_name' => 'required',
            'slug' => 'unique:resources,slug',
            'theme' => 'required',
        ];

        if ($resourceID) {
            $rules['name'] = 'required|unique:resources,name,' . $resourceID;
            $rules['slug'] = 'unique:resources,slug,' . $resourceID;
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to a resource.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'A :attribute name must be defined.',
            'name.unique' => 'The name \':input\' has already been defined.',
            'slug.unique' => 'The slug \':input\' has already been defined.',
        ];
    }
}

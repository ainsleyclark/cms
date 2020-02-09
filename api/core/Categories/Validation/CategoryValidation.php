<?php

namespace Core\Categories\Validation;

use Illuminate\Support\Facades\Validator;
use Core\System\Contracts\ValidationContract;

class CategoryValidation implements ValidationContract
{
    /**
     * The validation function, returns new validator.
     *
     * @param $data
     * @param bool $resourceID
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data, $categoryID = false)
    {
        if ($categoryID) {
            return Validator::make($data, $this->rules($categoryID), $this->messages());
        }

        return Validator::make($data, $this->rules(), $this->messages());
    }

    /**
     * Get the validation rules that apply to a resource.
     *
     * @param bool $resourceID
     * @return array
     */
    public function rules($categoryID = false)
    {
        $rules = [
            'name' => 'required|unique:resources,name',
            'friendly_name' => 'required',
            'slug' => 'unique:resources,slug',
            'theme' => 'required',
        ];

        if ($categoryID) {
            $rules['name'] = 'required|unique:resources,name,' . $categoryID;
            $rules['slug'] = 'unique:resources,slug,' . $categoryID;
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

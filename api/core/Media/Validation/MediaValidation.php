<?php

namespace Core\Resource\Validation;

use Illuminate\Support\Facades\Validator;
use Core\System\Contracts\ValidationContract;

class MediaValidation implements ValidationContract
{
    /**
     * The validation function, returns new validator.
     *
     * @param $data
     * @param bool $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data, $id = false)
    {
        if ($id) {
            return Validator::make($data, $this->rules($id), $this->messages());
        }

        return Validator::make($data, $this->rules(), $this->messages());
    }

    /**
     * Get the validation rules that apply to a resource.
     *
     * @param bool $id
     * @return array
     */
    public function rules($id = false)
    {
        $rules = [
            'name' => 'required|unique:resources,name',
            'friendly_name' => 'required',
            'slug' => 'unique:resources,slug',
            'theme' => 'required',
        ];

        if ($id) {
            $rules['name'] = 'required|unique:resources,name,' . $id;
            $rules['slug'] = 'unique:resources,slug,' . $id;
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

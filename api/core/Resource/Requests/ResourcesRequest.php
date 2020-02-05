<?php

namespace Core\Resource\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResourcesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to a resource.
     *
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

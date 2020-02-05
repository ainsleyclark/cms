<?php

namespace Core\Resource;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Core\Util\Slugify\Slugify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Core\Theme\Exceptions\ThemeConfigException;

class Resource
{
    /**
     *  The array of validator messages for resource.
     *
     * @var
     */
    private $validatorMessages;

    /**
     * Resource constructor.
     */
    public function __construct()
    {
        $this->validatorMessages = [
            'required' => 'A :attribute name must be defined.',
            'name.unique' => 'The name \':input\' has already been defined.',
            'slug.unique' => 'The slug \':input\' has already been defined.',
        ];
    }

    /**
     * Get resource by ID or get all resources, no param.
     *
     * @param $resource_id
     * @return bool|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function get($resource_id = false)
    {
        $query = DB::table('resources');

        if ($resource_id) {
            $resource = $query->where('resource_id', $resource_id)->first();
        } else {
            $resource = $query->get();
        }

        if (!$resource) {
            return false;
        }

        return $resource;
    }

    /**
     * Get resource by name.
     *
     * @param $name
     * @param $theme
     * @return bool|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getByName($name, $theme)
    {
        $resource = DB::table('resources')
            ->where('name', $name)
            ->where('theme', $theme)
            ->first();

        if (!$resource) {
            return false;
        }

        return $resource;
    }

    /**
     * Validation Rules for Resource.
     *
     * @param bool $resourceId
     * @return array
     */
    public function validate($resourceId = false) {
        $rules = [
            'name' => 'required|unique:resources,name',
            'friendly_name' => 'required',
            'slug' => 'unique:resources,slug',
            'theme' => 'required',
        ];

        if ($resourceId) {
            $rules['name'] = 'required|unique:resources,name,' . $resourceId;
            $rules['slug'] = 'unique:resources,slug,' . $resourceId;
        }

        return $rules;
    }

    /**
     * Convert data into Resource for storing in DB.
     *
     * @param $resource
     * @return array
     */
    public function processData($resource) {
        dump($resource);
        $slug = $resource->slug != '' ? $resource->slug : Slugify::slugify($resource->name);

        return [
            'name' => $resource->name,
            'friendly_name' => $resource->friendly_name,
            'singular_name' => $resource->singular_name,
            'slug' => $slug,
            //'resource_categories' => $data['categories'],
            'theme' => $resource->theme,
            'icon' => $resource->options->icon,
            'menu_position' => $resource->options->menu_position,
            'single_template' => $resource->templates->single_template,
            'index_template' => $resource->templates->index_template,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }

    /**
     * Creates a resource.
     *
     * @param $data
     * @return bool
     * @throws ThemeConfigException
     */
    public function store($data) {
        $insert = $this->processData($data);
        $insert['created_at'] = Carbon::now()->toDateTimeString();

        $validator = Validator::make($insert, $this->validate(), $this->validatorMessages);

        if ($validator->fails()) {
            throw new ThemeConfigException($validator->errors()->first(), $insert['theme']);
        }

        if (DB::table('resources')->where('name', $insert['name'])->insert($insert)) {
            return true;
        }

        return false;
    }

    /**
     * Updates a resource.
     *
     * @param $data
     * @param bool $resource
     * @return bool
     * @throws ThemeConfigException
     */
    public function update($data, $resource)
    {
        $update = $this->processData($data);
        $resourceId = $this->getByName($resource, $update['theme'])->id;

        $validator = Validator::make($update, $this->validate($resourceId), $this->validatorMessages);

        if ($validator->fails()) {
            throw new ThemeConfigException($validator->errors()->first(), $update['theme']);
        }

        if (DB::table('resources')->where('name', $update['name'])->update($update)) {
            return true;
        }

        return false;
    }

    /**
     * @param $resource
     */
    public function delete($resource) {

    }
}
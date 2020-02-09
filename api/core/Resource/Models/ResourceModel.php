<?php

namespace Core\Resource\Models;

use Carbon\Carbon;
use Core\Util\Slugify\Slugify;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Core\Resource\Validation\ResourceValidation;
use Core\Theme\Exceptions\ThemeConfigException;

class ResourceModel
{
    /**
     *  The instance of validator messages & rules for resource.
     *
     * @var
     */
    private $validator;

    /**
     * Resource constructor.
     */
    public function __construct()
    {
        $this->validator = new ResourceValidation();
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
     * Convert data into Resource for storing in DB.
     *
     * @param $resource
     * @return array
     */
    public function processData($resource) {
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

        $validator = $this->validator->validate($insert);

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
        $resourceID = $this->getByName($resource, $update['theme'])->id;

        $validator = $this->validator->validate($update, $resourceID);

        if ($validator->fails()) {
            throw new ThemeConfigException($validator->errors()->first(), $update['theme']);
        }

        if (DB::table('resources')->where('name', $update['name'])->update($update)) {
            return true;
        }

        return false;
    }
}
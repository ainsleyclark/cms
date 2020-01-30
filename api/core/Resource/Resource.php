<?php

namespace Core\Resource;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Core\Theme\Exceptions\ThemeConfigException;

class Resource extends Model
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
        parent::__construct();

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
     * @param $data
     * @param bool $resource
     * @return bool
     * @throws ThemeConfigException
     */
    public function store($data, $resource = false)
    {

        //If names are duplicates throw error getting logic error with it being comapred currently.

        $rules = [
            'name' => 'required|unique:resources,name',
            'friendly_name' => 'required',
            'slug' => 'unique:resources,slug',
            'theme' => 'required',
        ];

        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $data['slug'] = $data['slug'] != '' ? $data['slug'] : $this->slugify($data['name']);

        //Update
        if ($resource) {

            $resourceId = $this->getByName($resource, $data['theme'])->id;

            $rules['name'] = 'required|unique:resources,name,' . $resourceId;
            $rules['slug'] = 'unique:resources,slug,' . $resourceId;

            $validator = Validator::make($data, $rules, $this->validatorMessages);

            if ($validator->fails()) {
                throw new ThemeConfigException($validator->errors()->first(), $data['theme']);
            }

            if (DB::table('resources')->where('name', $data['name'])->update($data)) {
                return true;
            }

            return false;

        //Create
        } else {

            $validator = Validator::make($data, $rules, $this->validatorMessages);

            if ($validator->fails()) {
                throw new ThemeConfigException($validator->errors()->first(), $data['theme']);
            }

            $insertUpdate['created_at'] = Carbon::now()->toDateTimeString();

            if (DB::table('resources')->where('name', $data['name'])->insert($data)) {
                return true;
            }

            return false;
        }
    }
}
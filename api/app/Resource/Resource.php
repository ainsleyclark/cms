<?php

namespace App\Resource;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class Resource extends Model
{

    /**
     * The array of validation rules.
     *
     * @var
     */
    private $validator;

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

        $this->validator = [
            'name' => 'required',
            'friendly_name' => 'required',
            'theme' => 'required',
        ];

        $this->validatorMessages = [
            'name.required' => 'We need to know your e-mail address!',
            'friendly_name.required' => 'We need to know your e-mail address!'
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
     * @param $data
     * @param $page
     * @return bool|int
     */
    public function store($data, $page)
    {
        $validator = Validator::make($data, $this->validator, $this->validatorMessages);

        if ($validator->fails()) {
            dd($validator->errors()->messages());
        }


        $insertUpdate = [
            'name' => $data['name'],
            'friendly_name' => $data['friendly_name'],
            'slug' => $data['slug'],
            //'resource_categories' => $data['categories'],
            'theme' => $data['theme'],
            'icon' => $data['icon'],
            'menu_position' => $data['menu_position'],
            'single_template' => $data['single_template'],
            'index_template' => $data['index_template'],
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        dd($insertUpdate);

        if ($page == 'new') {
            $insertUpdate['created_at'] = Carbon::now()->toDateTimeString();
            $id = DB::table('pages')->insertGetId($insertUpdate);

            if (!$id) {
                return false;
            }
            return $id;

        } else {
            DB::table('pages')->where('page_id', $page)->update($insertUpdate);

            return $page;
        }
    }

}
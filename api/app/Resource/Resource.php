<?php

namespace App\Resource;

use Illuminate\Support\Facades\DB;

class Resource
{

    /**
     * Resource constructor.
     */
    public function __construct()
    {
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


    public function store($data, $page)
    {

        $insertUpdate = [
            'resource_name' => $data['name'],
            'resource_friendly_name' => $data['friendly_name'],
            //!Come back
            //'resource_categories' => $data['categories'],
            'resource_single_template' => $data['single_template'],
            'resource_index_template' => $data['index_template'],
            'resource_slug' => $data['slug'],
            'resource_updated_at' => Carbon::now()->toDateTimeString(),
        ];

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
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PagesModel extends Model
{

    /**
     * Get pages or page from database.
     *
     * @param $page
     * @param int $offset
     * @param int $limit
     * @return Model|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection|object|null
     */
    public function getPages($page, $offset = 0, $limit = 999999)
    {
        if (page == 'all') {
            return DB::table('pages')->where('resources', null)->limit($limit)->offset($offset)->get();
        } else {
            return DB::table('pages')->where('resources', null)->first();
        }
    }

    /**
     * Creates/edit new page into database.
     *
     * @param $data
     * @param $page
     * @return bool|int
     */
    public function createEditPage($data, $page)
    {
        $insertUpdate = [
            'slug' => $data['slug'],
            'status' => $data['status'],
            'author' => $data['author'],
            'template' => $data['template'],
            'cacheable' => $data['cacheable'],
            'updated_at' => Carbon::now()->toDateTimeString(),
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

    /**
     * Deletes a page from the database.
     *
     * @param $page
     * @return bool
     */
    public function deletePage($page)
    {
        if (DB::table('pages')->where('id', $page)) {
            DB::table('pages')->where('id', $page)->delete();
            return true;
        } else {
            return false;
        }
    }

}

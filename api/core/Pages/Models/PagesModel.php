<?php

namespace Core\Pages\Models;

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
    public function get($id = false, $offset = 0, $limit = 999999)
    {
        if ($id) {
            return DB::table('pages')->where('resources', null)->limit($limit)->offset($offset)->get();
        } else {
            return DB::table('pages')->where('resources', null)->first();
        }
    }

    /**
     * Creates a page.
     *
     * @param $data
     * @return bool|Model|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection|object|null
     */
    public function store($data)
    {
        $insert = $this->process($data);
        $insert['created_at'] = Carbon::now()->toDateTimeString();
        $id = DB::table('pages')->insertGetId($insert);

        if (!$id) {
            return false;
        }

        return $this->get($id);
    }

    /**
     * Updates a page.
     *
     * @param array $id
     * @param array $data
     * @return bool|Model|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection|object|null
     */
    public function update($id, $data)
    {
        $update = $this->process($data);

        if (DB::table('pages')->where('id', $id)->update($data)) {
            return $this->get($id);
        }

        return false;
    }

    /**
     * Deletes a page.
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

    /**
     * Process JSON data.
     *
     * @param $data
     * @return array
     */
    private function process($data)
    {
         return [
            'slug' => $data['slug'],
            'status' => $data['status'],
            'author' => $data['author'],
            'template' => $data['template'],
            'cacheable' => $data['cacheable'],
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }

}

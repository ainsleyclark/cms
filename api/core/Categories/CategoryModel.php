<?php

namespace Core\Categories;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    /**
     * @param $obj
     */
    public function create($obj)
    {
        DB::table('categories')->insert($obj);

    }
}

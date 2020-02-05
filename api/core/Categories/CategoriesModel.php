<?php

namespace Core\Categories;

class CategoriesModel
{
    /**
     * @param $obj
     */
    public function store($obj)
    {
        DB::table('categories')->insert($obj);

    }

    public function update()
    {

    }
}

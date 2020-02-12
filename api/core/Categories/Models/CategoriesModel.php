<?php

namespace Core\Categories\Models;

use Carbon\Carbon;
use Core\Categories\Validation\CategoryValidation;
use Illuminate\Support\Facades\DB;

class CategoriesModel
{
    /**
     * The instance of validator messages & rules for category.
     *
     * @var
     */
    protected $validator;

    /**
     * CategoriesModel constructor.
     *
     * @param CategoryValidation $validation
     */
    public function __construct(CategoryValidation $validation)
    {
        $this->validator = $validation;
    }

    /**
     * Get category by ID or get all resources, no param.
     *
     * @param bool $categoryID
     * @return bool|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection|object|null
     */
    public function get($categoryID = false)
    {
        $query = DB::table('$ca');

        if ($categoryID) {
            $resource = $query->where('id', $categoryID)->first();
        } else {
            $resource = $query->get();
        }

        if (!$resource) {
            return false;
        }

        return $resource;
    }

    /**
     * Get category by name.
     *
     * @param $name
     * @param $theme
     * @return bool|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getByName($name, $theme)
    {
        $category = DB::table('categories')
            ->where('name', $name)
            ->where('theme', $theme)
            ->first();

        if (!$category) {
            return false;
        }

        return $category;
    }

    /**
     * @param $obj
     */
    public function store($data)
    {
        $insert = $this->processData($data);
        DB::table('categories')->insert($obj);

    }

    /**
     *
     */
    public function update()
    {

    }

    /**
     * @param $category
     * @return array
     */
    private function processData($category)
    {
        return [
            'name' => $category->name,
            'slug' => 'slug',
            'theme' => $category->theme,
            'page_id' => 'page_id',
            'resource_id' => 'resource_id',
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }
}

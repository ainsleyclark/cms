<?php

namespace Core\Media;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager as Image;
use Core\Resource\Validation\MediaValidation;

class Media {


    // Someone uploads

    /**
     * The path where media files should be stored.
     *
     * @var
     */
    protected $mediaPath;

    /**
     * Media constructor.
     *
     * @param MediaValidation $validator
     */
    public function __construct(MediaValidation $validator)
    {
        $this->mediaPath = dirname(base_path()) . '/public/uploads';
    }

    /**
     * Get media by ID or get all resources, no param.
     *
     * @param bool $id
     * @return bool|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function get($id = false, $size = false)
    {
        $query = DB::table('media');

        if ($id) {
            $media = $query->where('id', $id)->first();
        } else {
            $media = $query->get();
        }

        if (!$media) {
            return false;
        }

        return $media;
    }

    /**
     *
     */
    public function getFullPath($path)
    {
        return $this->mediaPath . $path;
    }


    /**
     * This does something.
     *
     * @return array
     */
    public function getImageSizes()
    {
        return [
            'thumbnail' => '150x150',
        ];
    }


    public function store($data, $file)
    {
        $name = $file->getClientOriginalName();
        $insert = $this->processData($data);
        $insert['created_at'] = Carbon::now()->toDateTimeString();

    }


    /**
     * Deletes a media object from database
     * and deletes from disk.
     *
     * @param $path
     * @return bool
     */
    public function delete($path)
    {
        $paths = is_array($path) ? $path : func_get_args();

        foreach ($paths as $path) {
            if (unlink($this->mediaPath($path))) {
                DB::table('media')->where('path', $path)->delete();
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks media folder to see if folder has been created.
     * If it hasn't it will create a directory with the
     * current year and month.
     *
     * @return string
     */
    public function checkDir()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->format('m');
        $dir = $this->mediaPath . '/' . $year . '/' . $month;

        if (!file_exists($dir) && !is_dir($dir) ) {
            mkdir($dir);
        }

        return $dir;
    }


    /**
     * Get the file size based on path.
     *
     * @param $file
     * @return string
     */
    public function getFileSize($file)
    {
        $bytes = filesize($this->getFullPath($file));

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Convert data into Resource for storing in DB.
     *
     * @param $resource
     * @return array
     */
    private function processData($resource) {

        return [
            'url' => 'hello',
            'type' => 'hello',
            'caption' => 'hello',
            'description' => 'hello',
            'user_id' => 'hello',
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }
}

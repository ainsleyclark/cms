<?php

namespace Core\Media;

use Carbon\Carbon;
use WebPConvert\WebPConvert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager as Image;
use Core\Resource\Validation\MediaValidation;

class Media {

    /**
     * The path where media files should be stored.
     *
     * @var
     */
    protected $mediaPath;

    /**
     * The images sizes array from media/config.
     *
     * @var
     */
    protected $imageSizes;

    /**
     * The Image Manager.
     *
     * @var
     */
    protected $imageHelper;

    /**
     * Media constructor.
     *
     */
    public function __construct()
    {
        $this->mediaPath = public_path() . '/uploads';
        $this->imageSizes = config('media.image_sizes');
        $this->imageHelper = new Image();
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
        $media = $id ? $query->where('id', $id)->first() : $query->get();

        if (!$media) {
            return false;
        }

        return $media;
    }

    public function getImageBySize($path)
    {

    }

    /**
     * Stores an image and updates database.
     *
     * @param bool $data
     * @param bool $file
     * @return bool
     * @throws \WebPConvert\Convert\Exceptions\ConversionFailedException
     */
    public function store($data = false, $file = false)
    {
        $path = $this->saveFile($file);

        if (!$path) {
            return false;
        }
        $insert = $this->processData($data);
        $insert['created_at'] = Carbon::now()->toDateTimeString();
    }

    /**
     * Save the file to the public path.
     *
     * @param $file
     * @return bool|string
     * @throws \WebPConvert\Convert\Exceptions\ConversionFailedException
     */
    private function saveFile($file)
    {
        //$this->resizeImages('https://i.imgur.com/xDWsY5u.jpg');

        //Test

        $file = File::get('http://cms.local/test.jpg');
        dd($file);
        $path = $this->checkDir();
        $name = $file->getClientOriginalName();
        $fullPath = $path . $name;

        if (!$file->move($path, $name)) {
            return false;
        }

        if (config('media.webp.convert')) {
            $this->convertToWebP($fullPath);
        }

        if (getimagesize($fullPath)) {
            $this->convertImages($fullPath);
        }

        return $path;
    }

    /**
     * @param $path
     * @return bool
     */
    private function resizeImages($path)
    {
        foreach ($this->imageSizes as $name => $size) {
            $width = array_key_exists('width', $size) ? $size['width'] : null;
            $height = array_key_exists('height', $size) ? $size['height'] : null;

            try {
                $this->imageHelper->make($path)->resize($width, $height)->save($path . '-' . $name);
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
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
            if (unlink($path)) {
                DB::table('media')->where('path', $path)->delete();

            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets the mime type of a file based on path.
     *
     * @param $path
     * @return string
     */
    public function getMimeType($path)
    {
        return mime_content_type($path);
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
            mkdir($dir, 0755, true);
        }

        return $dir;
    }

    /**
     * Converts an image to WebP format using WebPConvert
     * and image options defined in media config.
     *
     * @param $source
     * @param $destination
     * @throws \WebPConvert\Convert\Exceptions\ConversionFailedException
     */
    private function convertToWebP($source, $destination = false)
    {
        $destination = $destination ? $destination : $source;
        WebPConvert::convert($source, $destination, config('media.webp.options'));
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

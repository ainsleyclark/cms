<?php

namespace Core\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Core\System\Assets;
use App\Http\Controllers\Controller;

class AssetsController extends Controller
{
    /**
     * The assets helper class.
     *
     * @var Assets
     */
    protected $assets;

    /**
     * AssetsController constructor.
     *
     * @param Assets $assets
     */
    public function __construct(Assets $assets)
    {
        parent::__construct();

        $this->assets = $assets;
    }

    /**
     * @param $asset
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function serveAssets($asset)
    {
        $file = $this->assets->resolve($asset)['file'];
        $contentType = $this->assets->resolve($asset)['contentType'];

        if (!$file) {
            abort(404);
        }

        return response($file)->withHeaders([
            'Content-type' => $contentType
        ]);
    }
}

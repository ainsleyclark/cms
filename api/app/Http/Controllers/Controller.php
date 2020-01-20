<?php

namespace App\Http\Controllers;

use App\Contracts\ThemeContract;
use App\Models\CoreModel;
use App\Models\Theme;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $coreModel;
    protected $theme;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->coreModel = new CoreModel();
    }

    /**
     * Ajax Responder
     *
     * @param $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $status = 200)
    {
        $response = (object) [
            'status' => ($status == 200) ? 'ok' : 'error',
            'status_code' => $status,
            'data' => $data,
            'request_time' => Carbon::now()->toDateTimeString()
        ];

        return response()->json($response, $status);
    }

    public function test(ThemeContract $theme) {

        dd($theme);
    }
}

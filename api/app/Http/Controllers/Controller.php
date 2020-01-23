<?php

namespace App\Http\Controllers;

use App\Models\CoreModel;
use App\Theme\Theme;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
        $this->theme = new Theme();
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

    public function test() {
        dd($this->theme);
    }
}

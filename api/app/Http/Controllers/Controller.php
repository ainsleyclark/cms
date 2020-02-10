<?php

namespace App\Http\Controllers;

use Core\Support\Facades\Theme;
use App\Models\CoreModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

        //$this->coreModel = new CoreModel();
        //$this->theme = new Theme();
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
        dd(Theme::get());
    }
}

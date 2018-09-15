<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller.
 */
class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return mixed
     */
    public function user(\Request $request)
    {
        return $request->user();
    }

    /**
     * @return mixed
     */
    public function privateGlide($path)
    {
        $server = \League\Glide\ServerFactory::create([
            'response' => new \League\Glide\Responses\LaravelResponseFactory(app('request')),
            'source' => app('filesystem')->disk('private')->getDriver(),
            'cache' => storage_path('glide'),
        ]);
        return $server->getImageResponse($path, \Illuminate\Support\Facades\Input::query());
    }

    /**
     * @return mixed
     */
    public function publicGlide($path)
    {
        $server = \League\Glide\ServerFactory::create([
            'response' => new \League\Glide\Responses\LaravelResponseFactory(app('request')),
            'source' => app('filesystem')->disk('public')->getDriver(),
            'cache' => storage_path('glide'),
        ]);
        return "XXXX";
    }
}

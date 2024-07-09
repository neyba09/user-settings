<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      title="API Documentation",
 *      version="3.0",
 *      @OA\Contact(
 *          email="zubankovaanastasia26@gmail.com"
 *      )
 * )
 * @OA\Server(
 *      url="http://localhost:8084",
 *      description="API Server"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

}

<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *   title="Hendry API",
     *   version="1.0",
     *   @OA\Contact(
     *     email="support@example.com",
     *     name="Support Team"
     *   )
     * )
     */

     protected $apiHelper;

     public function __construct()
     {
         $this->apiHelper = new ApiHelper();
     }
}

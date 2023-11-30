<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\HandleResponseApi;

class BaseApiController extends BaseController
{
    use HandleResponseApi;
}

<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const FAIL_STATUS = 'fail';
    const SUCCESS_STATUS = 'success';

    const RETVAL = [
        'status' => self::FAIL_STATUS,
        'result' => [],
        'message' => ''
    ];
}

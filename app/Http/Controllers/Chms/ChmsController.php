<?php namespace App\Http\Controllers\Chms;

use App\Http\Controllers\Controller as BaseController;
use App\Services\ChmsService;

abstract class ChmsController extends BaseController {

    protected $chms;

    public function __construct(ChmsService $chms) {
        $this->chms = $chms;
    }

}

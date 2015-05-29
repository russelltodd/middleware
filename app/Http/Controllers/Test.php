<?php namespace App\Http\Controllers;

class Test extends Controller {

    public function doTest() {
        \Log::debug(__METHOD__.'()');
        return "Hello!";
    }
}

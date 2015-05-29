<?php namespace App\Http\Controllers\Chms;

class People extends ChmsController {

    public function getPerson($id) {
        \Log::debug(__METHOD__.'('.$id.')');
        $person = $this->chms->getPerson($id);
        return response($person); // json returned
        //return response()->json($person);
    }
}
<?php namespace App\Services;

/*
 * encapsulates calls to the underlying Chms instance
 */
class Chms {

    private $chms;

    // TODO: configure the API Client
    public function __construct(ChmsWebService $chmsWebService) {
        $this->chms = $chmsWebService;
    }

    public function getPerson($id) {
        \Log::debug(__METHOD__.'('.$id.')');

        $p = new \StdClass;
        $p->id = $id;
        $p->name = 'John Locke';

        return $p;

/*
        $rsObj = $this->get('http://api.northpointministries.net/media/channel/npm/series-and-standalone/start_date/2015-05-01');
        return $rsObj;
        */
    }
}
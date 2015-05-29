<?php namespace App\Services;

interface WebServiceClient {

    public function get($uri, $params = array());

}
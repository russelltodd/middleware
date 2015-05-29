<?php namespace App\Services;

//use Psr\Http\Message\RequestInterface as HttpRequest;
//use Psr\Http\Message\ResponseInterface as HttpResponse;
//use App;

use GuzzleHttp\Client as HttpClient;

/*
 * encapsulates calls to the underlying Chms instance
 */
abstract class AbstractWebServiceClient implements WebServiceClient {


    /* do any prep work, i.e. authentication */
    protected abstract function prepareCall($uri, $params);

    public function get($uri, $params = array()) {
        \Log::debug(__METHOD__.'('.$uri.')');

        $url = $this->prepareCall($uri,$params);
        \Log::debug(__METHOD__.':: URL is '.$url);
        //$rq = App::make('Psr\Http\Message\RequestInterface',['GET',$url]);
        $httpClient = new HttpClient();
        $rs = $httpClient->get($url);

        \Log::debug(__METHOD__.':: RS Body is '.$rs->getBody());

        return $rs->getBody();

    }
}
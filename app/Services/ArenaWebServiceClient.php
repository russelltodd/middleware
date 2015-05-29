<?php namespace App\Services;

class ArenaWebServiceClient extends AbstractWebServiceClient {


    public function __construct() {
        $this->config = config('chms.arena');
        $this->apiUrl = trim($this->config['api_url']);
        if (ends_with($this->apiUrl,'/')) {
            $this->apiUrl .= '/';
        }
        $this->apiKey = trim($this->config['api_key']);
        $this->apiSecret = trim($this->config['api_secret']);
    }

    protected function prepareCall($uri, $args = array()) {

        // TODO - how to pull user session out?
        $args = array_merge(['api_session' => '316ccd0a-87e9-4517-9531-f6a4bffd6736' ,'api_key'=>$this->apiKey],$args);
        $apiSig = $this->_getApiSig($uri,$args);
        $fullUri = $uri . '?' . http_build_query($args) . "&api_sig=" . $apiSig;

        return $this->apiUrl . $fullUri;

    }

    /*
     * Arena web services authentication requires this algorithm
     */
    protected function _getApiSig( $_svcUri, $_args ) {

        $queryStr = '';
        $idx = 0;
        foreach($_args as $k => $v) {
            $queryStr .= ( ($idx++ == 0) ? '?' : '&' ) . $k . '=' . $v;
        }

        $requestUri = strtolower( $_svcUri . $queryStr );
        \Log::debug(__METHOD__.':: URI is '.$requestUri);
        $toHash = $this->apiSecret."_".$requestUri;
        $apiSig = md5($toHash);

        return $apiSig;
    }
}
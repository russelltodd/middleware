<?php namespace App\Transformers;

use League\Fractal;
use SimpleXMLElement;
use Carbon\Carbon;

class ArenaXmlTransformer extends Fractal\TransformerAbstract {

    private $config;

    public function __construct($config, $context) {
        $this->config = $config;
        $this->context = $context;
    }

    public function transform($xmlString) {
        \Log::debug(__METHOD__.'()');

        $xmlObj = new SimpleXMLElement($xmlString);

        return $this->_mapXml($this->config[$this->context], $xmlObj);
    }

    private function _mapXml($config, $xmlEl) {
        \Log::debug(__METHOD__.':: config: ['.print_r($config,true).'], xmlEl = '.$xmlEl->getName());
        $obj = [];
        foreach($config as $key => $field) {
            if (is_string($field)) {
                $fieldName = $field;
                $type = 'string';
            } else {
                $keys = array_keys($field);
                $fieldName = $keys[0];
                $types = array_values($field);
                $type = $types[0];
            }
            $fields = explode('.', $fieldName);
            $xmlElem = clone $xmlEl;
            foreach($fields as $f) {
                $xmlElem = $xmlElem->{$f};
            }
            $obj[$key] = $this->_cast($xmlElem, $type);
        }

        \Log::debug(__METHOD__.':: PERSON: '.print_r($obj,true));

        return $obj;
    }

    private function _cast(SimpleXMLElement $xmlElem, $type) {
        \Log::debug(__METHOD__.'('.$xmlElem.', '.print_r($type,true).')');
        // first check if it's an item or a collection
        if (is_string($type) && starts_with($type,'collection')) {
            $collType = substr($type, strlen('collection:'));
            $cfg = $this->config[$collType];
            // todo - figure out how to use the collection stuff, maybe include data?
            /*
            $subTransformer = new ArenaXmlTransformer($this->config, $collType);
            return $this->collection($xmlElem, $subTransformer)->getData();
            */
            $coll = [];
            foreach($xmlElem as $x) {
                \Log::debug('X is '.print_r($x,true));
                $coll[] = $this->_mapXml($cfg,$x);
            }
            return $coll;
        }

        switch ($type) {
            case 'int':
                return intval( $xmlElem );
            case 'date':
                // timezone??
                return Carbon::parse( (string) $xmlElem );
            case 'string':
            default:
                return (string) $xmlElem;
        }
    }
}
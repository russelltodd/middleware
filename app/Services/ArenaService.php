<?php namespace App\Services;

use App\Transformers\ArenaXmlTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class ArenaService implements ChmsService {

    private $webService;

    public function __construct(ArenaWebServiceClient $webService) {
        $this->webService = $webService;
    }

    public function getPerson($id) {

        // TODO - put error handling, etc around this?

        $personXml = $this->webService->get('person/'.$id);

$config = [
    'person' => [
        'id' => [ 'PersonID' => 'int' ],
        'guid' => 'PersonGUID',
        'firstname' => 'FirstName',
        'lastname' => 'LastName',
        'gender' => 'Gender',
        'birthdate' => ['BirthDate' => 'date' ],
        'emails' => [ 'Emails' => 'collection:email'],
    ],
    'email' => [
        'email' => 'Email.Address'
    ]
];
        $transformer = new ArenaXmlTransformer($config,'person');
        //$personObj = $this->transformer->transform($personXml);
        $fractal = new Manager();
        $fractal->setSerializer(new JsonApiSerializer());
        $personResource = new Item($personXml, $transformer, 'person');
        return $fractal->createData($personResource)->toJson();


    }

}
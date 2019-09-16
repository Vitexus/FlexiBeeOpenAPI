<?php
require_once '../vendor/autoload.php';

use erasys\OpenApi\Spec\v3 as OASv3;
use FlexiBee\Struct;

$structor = new Struct(null,
    ['offline' => true, 'companyUrl' => 'https://winstrom:winstrom@demo.flexibee.eu/c/demo/']);


$doc = new OASv3\Document(
    new OASv3\Info('FlexiBee', '1.0', $structor->describe()),
    $structor->getPathItems(),
    '3.0.1',
    $structor->getServers()
);

file_put_contents('../schema/flexibee.yaml', $doc->toYaml());
file_put_contents('../schema/flexibee.json', $doc->toJson());
//$arr  = $doc->toArray();
//$obj  = $doc->toObject();

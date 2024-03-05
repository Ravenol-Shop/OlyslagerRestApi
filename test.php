<?php

// Installiere Guzzle mit Composer, falls noch nicht installiert
// composer require guzzlehttp/guzzle

use GuzzleHttp\Client;
use Ravenol\OlyslagerRestApi\ApiWrapper;

// Autoloading und Namespaces hängen von deinem Projekt ab
require_once 'vendor/autoload.php';
// Setze die Basis-URL für die API
$apiBaseUrl = 'https://api.olyslager.com/rest/';
// Erstelle den Guzzle HTTP-Client
$client = new Client([
    'base_uri' => $apiBaseUrl ,
    'headers' => [
        'Cache-Control' => 'no-cache',
        'x-oly-subscription' => '8cb192b4df834568a15eda188924c157'
    ]
]);

// Erstelle die ApiWrapper-Instanz mit dem Guzzle HTTP-Client
$apiWrapper = new ApiWrapper($client);

$dataSets = $apiWrapper->getDataSets();
$dataSetCode = $dataSets['resultData'][0]['datasetCode'];
var_dump('dataSetCode',$dataSetCode);
$languages = $apiWrapper->getLanguages($dataSetCode);
$language = 'de';
$categories = $apiWrapper->getCategories($dataSetCode, $language);
$categorieId = $categories['resultData'][0]['id'];
$makes = $apiWrapper->getMakes($dataSetCode, $language, $categorieId);
#VW (EU)
$makeId = '910036';
$models = $apiWrapper->getModels($dataSetCode, $language, $makeId);
#Golf VIII Variant
$modelId = '9115499';
$types = $apiWrapper->getTypes($dataSetCode, $language, $modelId);
#Golf VIII Variant 2.0 TSI R
$typeId = '149961';
$recommendations = $apiWrapper->getRecommendations($dataSetCode, $language, $typeId);
var_dump($recommendations);


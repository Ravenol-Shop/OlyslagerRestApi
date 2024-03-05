<?php

namespace Ravenol\OlyslagerRestApi;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class ApiWrapper
{
    private $httpClient;

    const DEFAULT_ORDER_BY = 'apporder';

    public function __construct(
        GuzzleClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    private function sendRequest( RequestInterface $request): ?array
    {

        try {
            $response = $this->httpClient->send($request);
            $responseData = json_decode($response->getBody()->getContents(), true);

            return $responseData;
        } catch (\Exception $e) {
            // Handle exceptions or errors during the request
            // You might want to log or rethrow the exception based on your needs
            return null;
        }
    }

    public function getDataSets(){
        $request = new Request('GET', 'datasets');
        return $this->sendRequest($request);
    }

    public function getLanguages(string $datasetCode){
        $request = new Request('GET', 'languages', ['x-oly-dataset' => $datasetCode]);
        return $this->sendRequest($request);
    }

    /**
     * orderBy = {
        * apporder
        * id
        * makename
        * typeyearstart
        * typeyearend
     * }
     */
    public function getCategories(string $datasetCode, string $language, string $orderBy = self::DEFAULT_ORDER_BY){
        $params= [
            'language' => $language,
            'orderBy' => $orderBy
        ];
        $queryString = http_build_query($params);
        $request = new Request('GET', 'categories?'.$queryString, [
            'x-oly-dataset' => $datasetCode
        ]);
        return $this->sendRequest($request);
    }
    public function getMakes(string $datasetCode, string $language, int $categoryId, int $yearFilter= null, string $orderBy = self::DEFAULT_ORDER_BY){
        $params= [
            'language' => $language,
            'categoryId' => $categoryId,
            'yearFilter' => $yearFilter,
            'orderBy' => $orderBy
        ];
        $queryString = http_build_query($params);
        var_dump($queryString);
        $request = new Request('GET', 'makes?'.$queryString, [
            'x-oly-dataset' => $datasetCode
        ]);
        return $this->sendRequest($request);
    }

    public function getModels(string $datasetCode, string $language, int $makeId, int $yearFilter= null, string $orderBy = self::DEFAULT_ORDER_BY){
        $params= [
            'language' => $language,
            'makeId' => $makeId,
            'yearFilter' => $yearFilter,
            'orderBy' => $orderBy
        ];
        $queryString = http_build_query($params);
        var_dump($queryString);
        $request = new Request('GET', 'models?'.$queryString, [
            'x-oly-dataset' => $datasetCode
        ]);
        return $this->sendRequest($request);
    }

    public function getTypes(string $datasetCode, string $language, int $modelId, int $yearFilter= null, string $orderBy = self::DEFAULT_ORDER_BY){
        $params= [
            'language' => $language,
            'modelId' => $modelId,
            'yearFilter' => $yearFilter,
            'orderBy' => $orderBy
        ];
        $queryString = http_build_query($params);
        $request = new Request('GET', 'types?'.$queryString, [
            'x-oly-dataset' => $datasetCode
        ]);
        return $this->sendRequest($request);
    }

    public function getRecommendations(string $datasetCode, string $language, int $typeId){
        $params= [
            'language' => $language,
        ];
        $queryString = http_build_query($params);
        $request = new Request('GET', 'recommendations/'.$typeId.'?'.$queryString, [
            'x-oly-dataset' => $datasetCode
        ]);
        return $this->sendRequest($request);
    }
}

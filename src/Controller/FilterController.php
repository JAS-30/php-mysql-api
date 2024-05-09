<?php
namespace src\Controller;
use src\Gateway\FilterGateway;

class FilterController
{
public function __construct(private FilterGateway $gateway)
{ }

public function processRequest(string $method, $filterType):void{
        $this->processCollectionRequest($method, $filterType);
}             

private function processCollectionRequest(string $method, string $filterType):void{
    switch($method){
        case "GET":
            $data = (array) json_decode(file_get_contents("php://input"), true);
            switch($filterType){
                case "filter-range":
                    echo json_encode(["CO2 saved: " => $this->gateway->filterRange($data)]);
                break;
                case "filter-country":
                    echo json_encode(["CO2 saved: "=> $this->gateway->filterCountry($data)]);
                break;
                case "filter-product":
                    echo json_encode(["CO2 saved: " => $this->gateway->filterProduct($data)]);
                break;
            }
        break;
        default:
            http_response_code(405);
            header("Allow: GET");
        break;

    };
}

}
?>
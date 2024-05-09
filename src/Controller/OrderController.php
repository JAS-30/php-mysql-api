<?php
namespace src\Controller;
use src\Gateway\OrderGateway;
class OrderController
{
public function __construct(private OrderGateway $gateway)
{ }
//differentiate between /orders AND /orders/:id AND /orders/:id/:country
public function processRequest(string $method, ?string $id, ?string $country):void{
    if($id && $country){
        $this->processCountryResourceRequest($method,$id,$country);
        exit;
    }
    if($id){
        $this->processResourceRequest($method,$id);
        
    }else{
        $this->processCollectionRequest($method);
        
    }
} 

private function processCountryResourceRequest(string $method,string $id, string $country):void{
    switch($method){
        case "GET":
            $order = $this->gateway->getCustomer($id,$country);
            if(!$order){
                http_response_code(404);
                echo json_encode([
                "message" => "order not found"
                ]);
            exit;
            }
            echo json_encode($order);
        break;
        case "PATCH":
            $order = $this->gateway->getCustomer($id,$country);
            $data = (array) json_decode(file_get_contents("php://input"), true);
            $rows= $this->gateway->update($order,$data);
            echo json_encode([
                "message" => "Order $id updated",
                "country" => $country,
                "rows" => $rows
            ]);
        break;
        case "DELETE":
            $rows = $this->gateway->removeCustomer($id, $country);
            echo json_encode([
                "message"=>"Order $id deleted for client $country",
                "rows"=> $rows
            ]);
        break;
        default:
        http_response_code(405);
        header("Allow: GET, PATCH, DELETE");
    }
}

private function processResourceRequest(string $method,string $id):void{
    switch($method){
        case "GET":
            $product = $this->gateway->get($id);
            if(!$product){
                http_response_code(404);
                echo json_encode([
                "message" => "order not found"
                ]);
            exit;
            }
            echo json_encode($product);
        break;
        case "DELETE":
            $rows = $this->gateway->delete($id);
            echo json_encode([
                "message"=>"order $id deleted",
                "rows"=> $rows
            ]);
        break;
        default:
        http_response_code(405);
        header("Allow: GET, DELETE");

    }
    
}

private function processCollectionRequest(string $method):void{
    switch($method){
        case "GET":
            echo json_encode($this->gateway->getAll());
        break;
        case "POST":
            $data = (array) json_decode(file_get_contents("php://input"), true);
            $this->gateway->create($data);
            http_response_code(201);
            echo json_encode([
                "message" => "New order created"
            ]);
        break;
        default:
            http_response_code(405);
            header("Allow: GET, POST");

    };
}

}
?>
<?php
namespace src\Controller;
use src\Gateway\ProductGateway;
class ProductController
{
public function __construct(private ProductGateway $gateway)
{ }
//differentiate between /products AND /products/:id
public function processRequest(string $method, ?string $id):void{
    if($id){
        $this->processResourceRequest($method,$id);
    }else{
        $this->processCollectionRequest($method);
    }
} 

private function processResourceRequest(string $method,string $id):void{
    switch($method){
        case "GET":
            $product = $this->gateway->get($id);
            if(!$product){
                http_response_code(404);
                echo json_encode([
                "message" => "product not found"
                ]);
            exit;
            }
            echo json_encode($product);
        break;
        case "PATCH":
            $product = $this->gateway->get($id);
            $data = (array) json_decode(file_get_contents("php://input"), true);
            $rows= $this->gateway->update($product,$data);
            echo json_encode([
                "message" => "Product $id updated",
                "rows" => $rows
            ]);
        break;
        case "DELETE":
            $rows = $this->gateway->delete($id);
            echo json_encode([
                "message"=>"product $id deleted",
                "rows"=> $rows
            ]);
        break;
        default:
        http_response_code(405);
        header("Allow: GET, PATCH, DELETE");

    }
    
}

private function processCollectionRequest(string $method):void{
    switch($method){
        case "GET":
            echo json_encode($this->gateway->getAll());
        break;
        case "POST":
            $data = (array) json_decode(file_get_contents("php://input"), true);
            $id = $this->gateway->create($data);
            http_response_code(201);
            echo json_encode([
                "message" => "Product created",
                "id" => $id
            ]);
        break;
        default:
            http_response_code(405);
            header("Allow: GET, POST");

    };
}

}
?>
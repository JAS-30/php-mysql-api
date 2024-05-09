<?php
//declare(strict_types=1);

use src\Gateway\FilterGateway;
use src\Gateway\OrderGateway;
use src\Gateway\ProductGateway;
use src\Controller\FilterController;
use src\Controller\OrderController;
use src\Controller\ProductController;

require "Database.php";
require_once realpath('vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['CONNECTION'];
$name = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
//format response
header("Content-type: application/json; charset=UTF-8");

$parts =explode("/",$_SERVER["REQUEST_URI"]);
//available uri parts          
$id      = $parts[2] ?? null;
$country = $parts[3] ?? null;
//connect to DB
$database = new Database($host,$name,$user,$password);
$database->getConnection();
    
//routing
switch($parts[1]){
    case "products":
        $productGateway = new ProductGateway($database);
        $productController = new ProductController($productGateway);
        $productController->processRequest($_SERVER["REQUEST_METHOD"],$id);
    break;
    case "orders":
        $orderGateway = new OrderGateway($database);
        $orderController = new OrderController($orderGateway);
        $orderController->processRequest($_SERVER["REQUEST_METHOD"],$id,$country);
    break;
    case "filter-range":
        $filterGateway = new FilterGateway($database);
        $filterController = new FilterController($filterGateway);
        $filterController->processRequest($_SERVER["REQUEST_METHOD"], $parts[1]);
    break;
    case "filter-country":
        $filterGateway = new FilterGateway($database);
        $filterController = new FilterController($filterGateway);
        $filterController->processRequest($_SERVER["REQUEST_METHOD"], $parts[1]);
    break;
    case "filter-product":
        $filterGateway = new FilterGateway($database);
        $filterController = new FilterController($filterGateway);
        $filterController->processRequest($_SERVER["REQUEST_METHOD"], $parts[1]);
    break;
    default:
        http_response_code(404);
    break;
}







?>
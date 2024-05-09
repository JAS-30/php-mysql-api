<?php
namespace src\Gateway;
use Database;
use PDO;

class FilterGateway
{   
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function filterRange(array $range): int
    {
        $sql = "SELECT SUM(p.CO2_reduction * o.quantity) AS SUM FROM products AS p JOIN orders as o ON p.product_name = o.product WHERE order_date BETWEEN :start_range AND :end_range";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":start_range", $range["start_range"], PDO::PARAM_STR);
        $stmt->bindValue(":end_range", $range["end_range"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    public function filterCountry(array $country): int
    {
        $sql = "SELECT SUM(p.CO2_reduction * o.quantity) AS SUM FROM products AS p JOIN orders as o ON p.product_name = o.product WHERE o.country = :country";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":country", $country["country"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    public function filterProduct(array $product): int
    {
        $sql = "SELECT SUM(p.CO2_reduction * o.quantity) AS SUM FROM products AS p JOIN orders as o ON p.product_name = o.product WHERE o.product = :product";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":product", $product["product"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    


}
?>
<?php

namespace src\Gateway;
use Database;
use PDO;

class ProductGateway
{   
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->conn->query($sql);
        $data =[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO products (product_name,CO2_reduction)
                VALUES(:product_name,:CO2_reduction)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":product_name", $data["product_name"], PDO::PARAM_STR);
        $stmt->bindValue(":CO2_reduction", $data["CO2_reduction"] ?? 0, PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function get(string $id): array | false
    {
        $sql = "SELECT * FROM products WHERE id =:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id",$id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update(array $current, array $new):int
    {
        $sql = "UPDATE products
                SET product_name =:product_name, CO2_reduction =:CO2_reduction
                WHERE id=:id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(":product_name", $new["product_name"] ?? $current["product_name"], PDO::PARAM_STR);
                $stmt->bindValue(":CO2_reduction", $new["CO2_reduction"] ?? $current["CO2_reduction"], PDO::PARAM_INT);
                $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->rowCount();
    }

    public function delete(string $id):int
    {
        $sql = "DELETE FROM products 
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id ,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();

    }
}
?>
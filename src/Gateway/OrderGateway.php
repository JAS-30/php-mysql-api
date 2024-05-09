<?php

namespace src\Gateway;
use Database;
use PDO;

class OrderGateway
{   
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM orders ORDER BY id_order";
        $stmt = $this->conn->query($sql);
        $data =[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO orders (id_order,order_date,country,product,quantity)
                VALUES(:id_order,:order_date,:country,:product,:quantity)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_order", $data["id_order"], PDO::PARAM_INT);
        $stmt->bindValue(":order_date", $data["order_date"], PDO::PARAM_STR);
        $stmt->bindValue(":country", $data["country"], PDO::PARAM_STR);
        $stmt->bindValue(":product", $data["product"], PDO::PARAM_STR);
        $stmt->bindValue(":quantity", $data["quantity"], PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function get(string $id): array | false
    {
        $sql = "SELECT * FROM orders WHERE id_order =:id_order";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_order",$id, PDO::PARAM_INT);
        $stmt->execute();
        $data =[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return $data;
    }
    //get customer in order
    public function getCustomer(string $id, string $country): array | false
    {
        $sql = "SELECT * FROM orders WHERE id_order =:id_order AND country =:country";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_order",$id, PDO::PARAM_INT);
        $stmt->bindValue(":country",$country, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    //update order of client (country)
    public function update(array $current, array $new):int
    {
        $sql = "UPDATE orders
                SET order_date =:order_date, product =:product, quantity =:quantity
                WHERE id_order=:id_order AND country=:country";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(":order_date", $new["order_date"] ?? $current["order_date"], PDO::PARAM_STR);
                $stmt->bindValue(":product", $new["product"] ?? $current["product"], PDO::PARAM_STR);
                $stmt->bindValue(":quantity", $new["quantity"] ?? $current["quantity"], PDO::PARAM_INT);
                $stmt->bindValue(":id_order", $current["id_order"], PDO::PARAM_INT);
                $stmt->bindValue(":country", $current["country"], PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->rowCount();
    }

    public function delete(string $id):int
    {
        $sql = "DELETE FROM orders 
                WHERE id_order=:id_order";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_order", $id ,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();

    }

    public function removeCustomer(string $id, string $country):int
    {
        $sql = "DELETE FROM orders 
                WHERE id_order=:id_order AND country=:country";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_order", $id ,PDO::PARAM_INT);
        $stmt->bindValue(":country", $country ,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();

    }
}
?>
<?php

namespace App\Models;

use App\Core as Core;
use PDO;

class Product {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function get_cart($id) {

    }

    public function add(Core\Product $prod) {
        $name = $prod->name;
        $price = $prod->price;
        $pic = $prod->pic;

        $stmt = $this->pdo->prepare("INSERT INTO " . PRODTBL . " (name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
        $id = $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare("INSERT INTO " . PRODPICTBL . "(id, pic) VALUES (?,?");
        return $stmt->execute([$id, $pic]);

    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM " . PRODTBL . " WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function get() {
        $products = array();

        $stmt = $this->pdo->query("SELECT p.*, productpic.pic
                                    FROM `300049210finalproducts` p
                                    INNER JOIN `300049210finalproductpic` productpic
                                    ON p.id = productpic.id");

        $result = $stmt->fetchALL(PDO::FETCH_ASSOC);

        foreach ($result as $product) {
            $name = $product["name"];
            $price = $product["price"];
            
            $id = $product["id"];
            $pic = $product["pic"];
            $products[] = new Core\Product($name, $price, $pic, $id);
        }

        return $products;
    }
    
}

?>
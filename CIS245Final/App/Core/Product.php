<?php

namespace App\Core;

class Product {
    public $name;
    public $id;
    public $price;
    public $pic;

    public function __construct($name, $price, $pic, $id = null) {
        $this->name = $name;
        $this->price = $price;
        $this->pic = $pic;
        $this->id = $id;
    }
    
}

?>
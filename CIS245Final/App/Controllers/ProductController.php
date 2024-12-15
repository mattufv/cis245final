<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Product;

class ProductController extends Controller {

    public function get_list() {
        $product = $this->model("Product");
        $products = $product->get();
        $this->view("product/view", ["products" => $products]);
    }

    public function add() {
        $this->check_user_logged_in();
        if ($this->check_role("user")) {
            $this->view("product/add", ["error" => "You are not authorized add news", "authorized" => 0]);
        }    
        if ($this->is_post()) {
            $product = $this->model("Product");
            $products = new Product($this->sanitize_string($_POST["name"]), $this->$_POST["price"], $_POST["file"]);
            if ($product->add($products)) {
                header("Location: " . BASE . "?controller=product&method=get_list");
                exit;
            } else {
                $this->view("product/add", ["error" => "Failed to add product.", ["authorized" => 1]]);
            }
        } else {
            $this->view("product/add", ["authorized" => 1]);
        }
    }

}
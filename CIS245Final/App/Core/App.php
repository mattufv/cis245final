<?php

namespace App\Core;

class App {
    protected $controller = "HomeController";
    protected $method = "index";
    protected $params = [];

    public function __construct() {
        session_start();

        //$this->generate_csrf();

        $url = $this->parse_url();


        if ($url && $url["controller"] === "admin") {
            $url["controller"] = "user";
        }

        if ($url && file_exists(__DIR__ . "/../Controllers/" . ucfirst($url["controller"]) . "Controller.php")) {
            $this->controller = ucfirst($url["controller"]) . "Controller";
            unset($url["controller"]);
        }

        $controller_class = "App\\Controllers\\" . $this->controller;
        require_once(__DIR__ . "/../Controllers/" . $this->controller . ".php");
        $this->controller = new $controller_class;

        if (isset($url["method"])) {
            if (method_exists($this->controller, $url["method"])) {
                $this->method = $url["method"];
                unset($url["method"]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], array_values($this->params));
    }
/*
    public function parse_url() {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
        }
        return [];
    }
*/

function parse_url() {
	if ($_SERVER["QUERY_STRING"] !== "") {
		$vars = $_SERVER["QUERY_STRING"];
		$url = array();
		$pairs = explode("&", $vars);
		foreach ($pairs as $pair) {
        	list($key, $value) = explode("=", $pair . "=");
			$url[$key] = $value;
		}
		return $url;
	}
	return [];
}

    public function generate_csrf() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isset($_SESSION["csrf_token"]) || time() > $_SESSION["csrf_expiry"]) {
                //$_SESSION["csrf_token"] = bin2hex(random_bytes(32)); // not available in php5?
		        $_SESSION["csrf_token"] = bin2hex(openssl_random_pseudo_bytes(32));
                $_SESSION["csrf_expiry"] = time() + CSRF_EXPIRY;
            }
        } else {
            $_SESSION["csrf_token"] = bin2hex(openssl_random_pseudo_bytes(32));
            $_SESSION["csrf_expiry"] = time() + CSRF_EXPIRY;
        }
    }
}
?>
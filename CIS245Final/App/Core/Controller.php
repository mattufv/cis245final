<?php

namespace App\Core;

class Controller {

    public function view($view, $data = []) {
        extract($data);
        ob_start();
        require_once(__DIR__ . "/../views/" . $view . ".php");
        $content = ob_get_clean();
        require_once(__DIR__ . "/../views/layouts/main.php");
    }

    public function model($model) {
        require_once(__DIR__ . "/../Models/" . ucfirst($model) . ".php");
        $model_class = "App\Models\\" . $model;
        return new $model_class();
    }

    protected function check_role($role) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
            return false;
        }
        return true;
    }

    protected function is_post() {
        return ($_SERVER["REQUEST_METHOD"] === "POST" ?: false);
    }

    protected function check_user_logged_in() {
        if (!isset($_SESSION["id"])) {
            header("Location: " . BASE . "?controller=user&method=login");
            exit;
        }
    }

    protected function check_csrf($token) {
        if ($_SESSION["csrf_token"] === $token && time() <= $_SESSION["csrf_expiry"]) {
            echo $_SESSION["csrf_token"] . "<br>";
            echo $_SESSION["csrf_expiry"] . "<br>";
            echo $_SESSION["csrf_expiry"] - time() . "<br>";
            return true;
        }

        return false;
    }
	
    protected function sanitize_string($str) {
	return htmlspecialchars(trim($str), ENT_QUOTES, "utf-8");
    }
}


?>
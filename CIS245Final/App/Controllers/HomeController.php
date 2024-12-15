<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $this->view("home/index");
    }

    public function resume() {
        $this->view("home/resume");
    }

    public function projects() {
        $this->view("home/projects");
    }
}

?>
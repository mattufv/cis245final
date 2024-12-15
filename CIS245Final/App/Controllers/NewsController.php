<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\News;

class NewsController extends Controller {

    public function get_list() {
        $news = $this->model("News");
        $all_news = $news->get();
        $pics = $news->get_pics();
        $this->view("news/view", ["news" => $all_news, "photos" => $pics]);
        
    }

    public function add() {
        $this->check_user_logged_in();
        if ($this->check_role("user")) {
            $this->view("news/add", ["error" => "You are not authorized add news", "authorized" => 0]);
        }    
        if ($this->is_post()) {
            $news = $this->model("News");
            $new_news = new News($this->sanitize_string($_POST["title"]), $this->sanitize_string($_POST["content"]), $_SESSION["id"]);
            if ($news->add($new_news)) {
                header("Location: " . BASE . "?controller=news&method=get_list");
                exit;
            } else {
                $this->view("news/add", ["error" => "Failed to add news.", ["authorized" => 1]]);
            }
        } else {
            $this->view("news/add", ["authorized" => 1]);
        }
    }

    public function add_pic() {
        $this->check_user_logged_in();
        echo "hi";
        $news = $this->model("News");
        if ($this->check_role("user")) {
            $this->view("news/add_pic", ["error" => "You are not authorized add news", "authorized" => 0]);
        }    
        if ($this->is_post()) {
            $message = $news->upload_pic();
            $this->view("news/add_pic", ["message" => $message, "authorized" => 1]);
        } else {
            $this->view("news/add_pic", ["authorized" => 1]);
        }
    
    }


    

}
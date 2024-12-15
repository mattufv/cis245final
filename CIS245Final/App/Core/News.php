<?php

namespace App\Core;

class News {
    public $title;
    public $content;
    public $author;
    public $date;
    public $id;

    public function __construct($title, $content, $author, $date = null, $id = null) {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->date = $date;
        $this->id = $id;
    }
}

?>
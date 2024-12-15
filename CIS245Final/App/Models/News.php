<?php

namespace App\Models;
use App\Core as Core;

use PDO;

class News {
    private $pdo;
    private $uid;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        if (isset($_SESSION["id"])) {
            $this->uid = $_SESSION["id"];
        }
    }

    public function get() {
        $news = array();

        $stmt = $this->pdo->query("SELECT n.*, u.username FROM " . NEWSTBL . " n
                                        INNER JOIN " . USERTBL . " u
                                        ON n.uid = u.id
                                        ORDER BY n.date DESC");

        $result = $stmt->fetchALL(PDO::FETCH_ASSOC);

        foreach ($result as $news_item) {
            $title = $news_item["title"];
            $content = $news_item["content"];
            $uid = $news_item["uid"];
            $id = $news_item["id"];
            $username = $news_item["username"];
            $date = $news_item["date"];
            $news[] = new Core\News($title, $content, ["uid" => $uid, "username" => $username], $date, $id);
        }

        return $news;
    }

    public function get_pics() {
        $news = array();

        $stmt = $this->pdo->query("SELECT pic FROM " . NEWSPICTBL);

        $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
        $pics = array();

        foreach ($result as $pic) {
            $pics[] = $pic["pic"];
        }

        return $pics;
    }

    public function add(Core\News $news) {
        $title = $news->title;
        $content = $news->content;
        $date = $news->date;
        $uid = $news->author;

        $stmt = $this->pdo->prepare("INSERT INTO " . NEWSTBL . " (title, content, uid) VALUES (?, ?, ?)");
        return $stmt->execute([$title, $content, $uid]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM NOTETBL WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function upload_pic() {
        if ($_FILES["file"]["error"] === 0) {
            $target_dir = "uploads/";
            
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $upload_ok = 1;
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
            $message = array();
    
    
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if ($check !== false) {
                $upload_ok = 1;
            } else {
                $message[] = "File is not an image.";
                $upload_ok = 0;
            }
            
            // append a number onto the end of the filename if it already exists
    
            if (file_exists($target_file)) {
                $name = $_FILES["file"]["name"];
                $actual_name = pathinfo($name,PATHINFO_FILENAME);
                $original_name = $actual_name;
                $extension = pathinfo($name, PATHINFO_EXTENSION);
    
                $i = 1;
                while(file_exists($target_file)) {           
                    $actual_name = (string)$original_name.$i;
                    $target_file = $target_dir . $actual_name.".".$extension;
                    $i++;
                }
            }
    
            if ($_FILES["file"]["size"] > 500000) {
                $message[] = "Sorry, your file is too large.";
                $upload_ok = 0;
            }
    
            if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif" ) {
                $message[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $upload_ok = 0;
            }
    
            if ($upload_ok === 0) {
                $message[] = "There was an error uploading your file.";
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $message = $target_file;
    
    
    
                } else {
                    $message[] = "There was an error uploading your file.";
                }
            }
        }
        if (isset($message) && !is_array($message)) {
            $this->add_pic_to_db($message);
        } elseif (isset($message)) {
            return $message;
        } else {
            return $message[] = "No file selected.";
        }

    }

    public function add_pic_to_db($name) {
        $stmt = $this->pdo->prepare("INSERT INTO " . NEWSPICTBL . " (pic) VALUES (?)");
        return $stmt->execute([$name]);
    }
    
    
}
<?php

namespace App\Models;

use PDO;

class User {
    protected $pdo;

    public function __construct() {
        global $pdo; // grab PDO instance from config.php
        $this->pdo = $pdo;
    }

    public function register($username, $email, $password, $role) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO " . USERTBL . " (username, email, password, role) VALUES (?, ?, ?, ?)");

        return $stmt->execute([$username, $email, $hashed_password, $role]);
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT id, username, password, role FROM " . USERTBL . " WHERE username = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            return $user;
        } else {
            return false;
        }
    }

    public function user_exists($username) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM " . USERTBL . " WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchColumn() > 0;
    }

    public function verify_user($username, $password) {
        return $this->login($username, $password);
    }

    public function delete_user($uid) {
        $stmt = $this->pdo->prepare("DELETE FROM " . USERTBL . " WHERE id = ?");
        
        return ($stmt->execute([$uid]));
    }

    public function upload_profile_pic() {
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
            $this->add_profile_pic_to_db($message);
        } elseif (isset($message)) {
            return $message;
        } else {
            return $message[] = "No file selected.";
        }

    }

    public function add_profile_pic_to_db($name) {
        $stmt = $this->pdo->prepare("INSERT INTO " . PICTBL . " (uid, ppic) VALUES (?, ?)
                                    ON DUPLICATE KEY UPDATE ppic = ?");
        return $stmt->execute([$_SESSION["id"], $name, $name]);
    }

    public function get_profile_pic() {
        $ppic = null;
        $stmt = $this->pdo->prepare("SELECT ppic from " . PICTBL . " WHERE uid = ?");
        if ($stmt->execute([$_SESSION["id"]])) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $ppic = $result["ppic"];
            }
        }
        return $ppic;
    }

}
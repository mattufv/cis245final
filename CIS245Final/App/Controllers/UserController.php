<?php

namespace App\Controllers;

use App\Core\Controller;

class UserController extends Controller {
    public function register() {
        if ($this->is_post()) {
            $username = $this->sanitize_string($_POST["username"]);
            $email = $_POST["email"];
            $password = $_POST["password"];
            $role = $_POST["role"];

            // Validate POST vars
            if (empty($username) || empty($email) || empty($password)) {
                $this->view("user/register", ["error" => "You must fill in all fields"]);
                return;
            }

            $user = $this->model("user");

            if ($user->user_exists($username)) {
                $this->view("user/register", ["error" => "Username already exists"]);
                return;
            }

            $user->register($username, $email, $password, $role);
            header("location: " . BASE . "?controller=user&method=login");
        } else {
            $this->view("user/register");
        }
    }

    public function login() {
        if ($this->is_post()) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $user = $this->model("user");

            $logged_in_user = $user->login($username, $password);

            if ($logged_in_user) {
                // Set session vars
                foreach ($logged_in_user as $k => $v) {
                    if ($k != "password") {
                        $_SESSION[$k] = $v;
                    }
                }

                header("location: " . BASE . "?controller=user&method=fan");
            } else {
                $this->view("user/login", ["error" => "Username or password incorrect"]);
            }
        } else {
            if (isset($_SESSION["id"]))
                header("location: " . BASE);
            $this->view("user/login");
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("location: " . BASE . "?controller=user&method=login");
    }

    public function delete() {
        $this->check_user_logged_in();
        if ($this->is_post()) {
            $username = $_SESSION["username"];
            $uid = $_SESSION["id"];
            $password = $_POST["password"];
            $token = $_POST["csrf"];

            if (!$this->check_csrf($token)) {
                $this->view("user/delete", ["error" => "Invalid CSRF. Please retry"]);
                return;
            }

            $user = $this->model("user");

            if (!$user->verify_user($username, $password)) {
                $this->view("user/delete", ["error" => "Password incorrect"]);
                return;
            }

            $deleted_user = $user->delete_user($uid);

            // Not sure if I want to scrub deleted user notes or just keep them set to NULL
            if ($deleted_user) {
                // log user off
                session_unset();
                session_destroy();
                header("location: " . BASE);
            } else {
                $this->view("user/delete", ["error" => "Could not delete user $username"]);
            }
        } else {
            $this->view("user/delete");
        }
    }

    public function fan() {
        $this->check_user_logged_in();
        $user = $this->model("User");
        $ppic = $user->get_profile_pic();
        if ($this->is_post()) {
            $message = $user->upload_profile_pic();
            $ppic = $user->get_profile_pic();
            $this->view("fan/mypage", ["message" => $message, "ppic" => $ppic]);
        } else {
            $this->view("fan/mypage", ["ppic" => $ppic]);
        }
    }

    public function dashboard() {
        if (!$this->check_role("admin")) {
            $this->view("admin/dashboard", ["error" => "You do not have valid authorization", "allowed" => 0]);
            return;
        } else {
            $this->view("admin/dashboard", ["allowed" => 1]);
        }
    }

    public function admin_users($uid = null) {
        // if user us not an admin display error
        if (!$this->check_role("admin")) {
            $this->view("admin/dashboard", ["error" => "You do not have valid authorization", "allowed" => 0]);
            return;
        }

        // Load admin model for admin methods
        $admin = $this->model("Admin");

        $users = $admin->get_all_users();

        if ($this->is_post()) {
            // Make sure CSRF is valid
            if (!$this->check_csrf($_POST["csrf"])) {
                $this->view("admin/admin_users", ["users" => $users, "error" => "Invalid CSRF. Please retry"]);
                return;
            }

            if ($admin->change_user_role($uid, $_POST["role"])) {
                header("location: " . BASE . "?controller=admin&method=admin_users");
            } else {
                $this->view("admin/admin_users", ["users" => $users, "allowed" => 1, "error" => "Could not change role"]);
            }
        } else {
            $users = $admin->get_all_users();
            $this->view("admin/admin_users", ["users" => $users, "allowed" => 1]);
        }
    }

    public function admin_notes() {
        // if user us not an admin display error
        if (!$this->check_role("admin")) {
            $this->view("admin/dashboard", ["error" => "You do not have valid authorization", "allowed" => 0]);
            return;
        }

        // Load admin model for admin methods
        //$admin = $this->model("Admin");
        $note = $this->model("Note");
        
        // get all notes
        $notes = $note->get_all(true);
        $this->view("admin/admin_notes", ["notes" => $notes]);
    }}


?>
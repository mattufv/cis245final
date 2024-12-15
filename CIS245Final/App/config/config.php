<?php

// DB config constants
/* const DBHOST = "localhost";
const DBUSER = "test";
const DBPASS = "12345";
const DBNAME = "dbtest"; */

const DBHOST = "localhost";
const DBUSER ="root";
const DBPASS = "";
const DBNAME = "final";

// Table constants
const USERTBL = "`300049210finalusers`";
const NEWSTBL = "`300049210finalnews`";
const PICTBL = "`300049210finalprofilepic`";
const CARTTBL = "`300049210finalcart`";
const PRODTBL = "`300049210finalproducts`";
const PRODPICTBL = "`300049210finalproductpic`";
const NEWSPICTBL = "`300049210finalpics`";

// Expiry time constants
const CSRF_EXPIRY = 120; // Is 2 minutes too long?

// constant for <base href>
const BASE = "/CIS245final/";

try {
    $pdo = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Define base path
define("BASE_PATH", realpath(dirname(__FILE__)));

// Autoloader function
spl_autoload_register(function ($class) {
    $prefix = "App\\";
    $base_dir = BASE_PATH . "/../";  // This points to the `app/` folder
	$base_dir = realpath($base_dir) . "/";


    $len = strlen($prefix);

    // make sure the class uses app namespace
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // remove the App prefix
        //$relative_class = lcfirst(substr($class, $len)); // renamed folder to UCfirst for ease
	$relative_class = substr($class, $len);


    $file = $base_dir . str_replace("\\", "/", $relative_class) . ".php";

    if (file_exists($file)) {
        require $file;
    }
});
?>
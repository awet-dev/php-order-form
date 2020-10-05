<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;

$success_order = "Fill the form to order your food?";

$email = $street = $street_number = $city = $zip_code = "";
$emailErr = $streetErr = $street_numberErr = $cityErr = $zip_codeErr= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["street"])) {
        $streetErr = "Street is required";
    } else {
        $street = test_input($_POST["street"]);
    }

    if (empty($_POST["streetnumber"])) {
        $street_numberErr = "Street number is required";
    } else {
        $street_number = test_input($_POST["streetnumber"]);
        // check if input value is only number
        if (!is_numeric($street_number)) {
            $street_numberErr = "Street number must be only number";
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "City name is required";
    } else {
        $city = test_input($_POST["city"]);
    }

    if (empty($_POST["zipcode"])) {
        $zip_codeErr = "zip code is required";
    } else {
        $zip_code = test_input($_POST["zipcode"]);
        if (!is_numeric($zip_code)) {
            $zip_codeErr = "Zip code must be only number";
        }
    }
    if ($emailErr === "" && $streetErr === "" && $street_numberErr === "" && $cityErr === "" && $zip_codeErr === "") {
        $success_order = "Your order had been send";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



require 'form-view.php';
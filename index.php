<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();

if (!isset($_SESSION["email"])) {
    $_SESSION["email"] = "";
}
if (!isset($_SESSION["street"])) {
    $_SESSION["street"] = "";
}
if (!isset($_SESSION["city"])) {
    $_SESSION["city"] = "";
}
if (!isset($_SESSION["street_number"])) {
    $_SESSION["street_number"] = "";
}
if (!isset($_SESSION["zipcode"])) {
    $_SESSION["zipcode"] = "";
}

if(!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

if (!isset($_SESSION['express_delivery'])) {
    $_SESSION['express_delivery'] = '';
}
if (!isset($_SESSION['total_price'])) {
    $_SESSION['total_price'] = 0;
}


function whatIsHappening() {
    /*
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
     */
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

if(isset($_GET['food'])) {
    if ($_GET['food'] == 1) {
        $products = [
            ['name' => 'Club Ham', 'price' => 3.20],
            ['name' => 'Club Cheese', 'price' => 3],
            ['name' => 'Club Cheese & Ham', 'price' => 4],
            ['name' => 'Club Chicken', 'price' => 4],
            ['name' => 'Club Salmon', 'price' => 5]
        ];
    } else if ($_GET['food'] == 0) {
        $products = [
            ['name' => 'Cola', 'price' => 2],
            ['name' => 'Fanta', 'price' => 2],
            ['name' => 'Sprite', 'price' => 2],
            ['name' => 'Ice-tea', 'price' => 3],
        ];
    }
}

$all_products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5],
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];
$totalValue = 0;

$success_order = "Fill the form to order your food?";
$email = $street = $street_number = $city = $zip_code = "";
$emailErr = $streetErr = $street_numberErr = $cityErr = $zip_codeErr = $productErr = "";

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

    if (empty($_POST["street_number"])) {
        $street_numberErr = "Street number is required";
    } else {
        $street_number = test_input($_POST["street_number"]);
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
}


$delivery_time = 0;
if(isset($_POST['button'])) {
    if ($emailErr === "" && $streetErr === "" && $street_numberErr === "" && $cityErr === "" && $zip_codeErr === "") {
        if(isset($_POST['express_delivery'])) {
            $delivery_time = date("H:i", strtotime('+45 minutes'));
            $totalValue += intval($_POST['express_delivery']);
        } else {
            $delivery_time = date("H:i", strtotime('+2 hour'));
        }
        $success_order = "Your order had been send, Expected time delivery at " . $delivery_time;

        mail($email, "your food order", $success_order);
    }
    $_SESSION['email'] = $email;
    $_SESSION['street'] = $street;
    $_SESSION['street_number'] = $street_number;
    $_SESSION['city'] = $city;
    $_SESSION['zipcode'] = $zip_code;
    if (isset($_POST['express_delivery'])) {
        $_SESSION['express_delivery'] = $_POST['express_delivery'];
    } else {
        $_SESSION['express_delivery'] = '';
    }
    if (isset($_POST['products'])) {
        foreach ($_POST['products'] as $value) {
            array_push($_SESSION['products'], $value);
            $_SESSION['products'] = array_unique($_SESSION['products']);
        }
    }
    if(empty($_SESSION['products'])) {
        $productErr = "Select at least one item!";
    } else {
        $productErr = '';
    }

    foreach ($all_products AS $i => $product) {
        if (!empty($_SESSION['products']) && in_array($product['name'], $_SESSION['products'])) {
            $totalValue += round($product['price'], 2);
        }
    }

    $_SESSION['total_price'] = $totalValue;
}
whatIsHappening();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

require 'form-view.php';

// ======= to calculate the total mount of money spend ======= //
// 1. the access to the price of checked product
// 2. save it in to total price variable
// 3. then save the total price in session
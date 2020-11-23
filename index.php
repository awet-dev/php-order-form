<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

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
whatIsHappening();

//your products with their price.
$food = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$drink = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

// shift between food and drinks
if (isset($_GET['food']) && $_GET['food'] == 0) {
    $products = $drink;
} else {
    $products = $food;
}

$_SESSION['total'] = 0;

$emailErrMsg = $zipCodeErrMsg = $successMsg = "";
$emailErrStyle = $zipCodeErrStyle = "";

$errorStyle = "border: 1px solid red;";
$_SESSION['success'] = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErrMsg = "Invalid email format";
        $emailErrStyle = $errorStyle;
    }

    $street = test_input($_POST['street']);
    $city = test_input($_POST['city']);
    $street_number = test_input($_POST['street_number']);

    $zip_code = test_input($_POST['zip_code']);
    if (strlen($zip_code) !== 4) {
        $zipCodeErrMsg = "Zip code has 4 digits";
        $zipCodeErrStyle = $errorStyle;
    }

    // expected delivery time
    if (isset($_POST['express_delivery'])) {
        $deliveryTime = 45 . "min";
        $_SESSION['total'] += $_POST['express_delivery'];
    } else {
        $deliveryTime = 2 . "hr";
    }

    // total money for the selected order
   if (isset($_POST['products'])) {
       foreach ($_POST['products'] as $product) {
           $_SESSION['total'] += $product;
       }
   }

   $totalPrice = $_SESSION['total'];

    // save the input if there is error
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($zip_code) !== 4) {
        $_SESSION['email'] = $email;
        $_SESSION['street'] = $street;
        $_SESSION['city'] = $city;
        $_SESSION['zip_code'] = $zip_code;
        $_SESSION['street_number'] = $street_number;
    } else {
        //============================ disappear when refreshed ================================//
        if ($_SESSION['success']) {
            $successMsg = "Your order will be right there in $deliveryTime total money is $totalPrice !";
            mail($email,"My subject", $successMsg);
            $_SESSION['success'] = false;
        }
        //===========================================// ===================================//
        $_SESSION['email'] = "";
        $_SESSION['street'] = "";
        $_SESSION['city'] = "";
        $_SESSION['street_number'] = "";
        $_SESSION['zip_code'] = "";
    }


}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

require 'form-view.php';
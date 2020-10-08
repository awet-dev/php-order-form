<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <div class="alert alert-success" role="alert">
        <?php echo $success_order; ?>
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo $_SESSION['email'];?>" <?php echo $email_style?>/>
                <span class="error">* <?php echo $emailErr;?></span>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php echo $_SESSION['street'];?>" <?php echo $street_style?>/>
                    <span class="error">* <?php echo $streetErr;?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="street_number">Street number:</label>
                    <input type="text" id="street_number" name="street_number" class="form-control" value="<?php echo $_SESSION['street_number'];?>" <?php echo $street_number_style?>/>
                    <span class="error">* <?php echo $street_numberErr;?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php echo $_SESSION['city'];?>" <?php echo $city_style?>/>
                    <span class="error">* <?php echo $cityErr;?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo $_SESSION['zipcode'];?>" <?php echo $zip_code_style?>/>
                    <span class="error">* <?php echo $zip_codeErr;?></span>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="<?php echo $product['name'] ?>" name="products[<?php echo $i ?>]" <?php if (!empty($_SESSION['products']) && in_array($product['name'], $_SESSION['products'])) { echo "checked = 'checked'";}?>/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2);?></label><br />
            <?php endforeach; ?>
            <span class="error">* <?php echo $productErr;?></span>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5" <?php if (!empty($_SESSION['express_delivery'])) { echo "checked = 'checked'";}?>/>
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" name="button" class="btn btn-primary">Order!</button>
        <button type="submit" name="save" class="btn btn-primary">save order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $_SESSION['total_price'] ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
    .error {
        color: #FF0000;
    }
</style>
</body>
</html>
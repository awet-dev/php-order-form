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
    <?php if (!empty($successMsg)) :?>
        <div class="alert alert-success" role="alert">
            <strong>Dear Customer! </strong><?php echo $successMsg?>
        </div>
    <?php endif; ?>
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
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']?>" class="form-control" style="<?php echo $emailErrStyle?>" required/>
                <span style="color: red"><?php echo $emailErrMsg?></span>
            </div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" value="<?php echo $_SESSION['street']?>" id="street" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="street_number">Street number:</label>
                    <input type="number" id="street_number" min="1" max="100" name="street_number" value="<?php echo $_SESSION['street_number']?>" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="<?php echo $_SESSION['city']?>" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="zip_code">Zip code</label>
                    <input type="number" id="zip_code" min="1" name="zip_code" value="<?php echo $_SESSION['zip_code']?>" class="form-control" style="<?php echo $zipCodeErrStyle?>" required >
                    <span style="color: red"><?php echo $zipCodeErrMsg?></span>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="<?php echo $product['price'] ?>" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5" />
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $_SESSION['total'] ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
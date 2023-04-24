<?php

session_start();
include('../utils/userfunctions.php');

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['place-order-btn'])) {
    $fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $lname = mysqli_real_escape_string($connection, $_POST['lname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $street = mysqli_real_escape_string($connection, $_POST['street']);
    $homeno = mysqli_real_escape_string($connection, $_POST['homeno']);
    $flatno = mysqli_real_escape_string($connection, $_POST['flatno']);
    $zipcode = mysqli_real_escape_string($connection, $_POST['zipcode']);
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $country = mysqli_real_escape_string($connection, $_POST['country']);
    $payment_mode = mysqli_real_escape_string($connection, $_POST['payment_mode']);

    validate($fname);
    validate($lname);
    validate($email);
    validate($phone);
    validate($street);
    validate($homeno);
    validate($flatno);
    validate($zipcode);
    validate($city);
    validate($country);
    validate($payment_mode);

    // if ($fname == "" || $lname == "" || $email == "" || $phone == "" || $street == "" || $zipcode == "" 
    // || $city == "" || $country == "" || $address == "" || $payment_mode == "" || $payment_id == "") {
    //     $_SESSION['message'] = "All fields needs to be filled";
    //     header('Location: checkout.php');
    //     exit(0);
    // }

    $cartItems = getCartItems($connection);
    $totalPrice = 0.0;
    foreach ($cartItems as $citem) {
        $totalPrice += $citem['PriceAfterDiscount'] * $citem['prod_qty'];
    }
    $tracking_number = "bibliopolium" . rand(1111, 9999) . substr($phone, 2);
    $user_id = $_SESSION['UserID'];


    // $payment_id = "CASH";
    $query = "INSERT INTO orders (tracking_no, user_id, fname, lname, email, phone, street, zipcode, city,
     country, total_price, payment_mode) VALUES ('$tracking_number', '$user_id', '$fname', '$lname', '$email', '$phone', '$street', '$zipcode', '$city', '$country',
     '$totalPrice', '$payment_mode')";
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
        $order_id = mysqli_insert_id($connection);

        foreach ($cartItems as $citem) {
            $prod_id = $citem['prod_id'];
            $prod_qty = $citem['prod_qty'];
            $price = $citem['PriceAfterDiscount'];
            $insert_items_query = "INSERT INTO order_items (order_id, prod_id, qty, price)
            VALUES ('$order_id', '$prod_id', '$prod_qty', '$price')";
            mysqli_query($connection, $insert_items_query);

            $curr_prod_query = "SELECT * FROM books WHERE BookID = '$prod_id'";
            $curr_prod_query_run = mysqli_query($connection, $curr_prod_query);
            $product = mysqli_fetch_array($curr_prod_query_run);
            $curr_qty = $product['Quantity'];

            $new_qty = $curr_qty - $prod_qty;
            $update_qty_query = "UPDATE books SET Quantity='$new_qty' WHERE BookID='$prod_id'";
            $update_qty_query_run = mysqli_query($connection, $update_qty_query);

        }

        $delete_cart_query = "DELETE FROM carts WHERE user_id = '$user_id'";
        mysqli_query($connection, $delete_cart_query);

        $_SESSION['message'] = "Order placed successfully";
        header('Location: ../views/admin.php');
        exit();
    }
}

?>
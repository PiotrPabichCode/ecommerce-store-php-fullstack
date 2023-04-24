<?php

include('connect.php');

function checkUserLogin($connection)
{
    if(!isset($_SESSION['LoggedIn'])) {
        header('Location: /views/login.php');
        exit();
    }
}

function checkIfAdmin($connection)
{
    if (isset($_SESSION['Admin'])) {
        if ($_SESSION['Admin'] != 1) {
            header('Location: /views/account.php');
            exit(1);
        }
    }
}

function getCartItems($connection) {
    if(isset($_SESSION['UserID'])) {
        $currUser = $_SESSION['UserID'];
        $query = "SELECT c.id as cid, c.prod_id, c.prod_qty, b.BookID as bid,
        b.Booktitle, b.imageL, b.PriceAfterDiscount, b.AuthorID, Quantity from carts c, books b WHERE c.prod_id = b.BookID 
        AND c.user_id = '$currUser' ORDER BY c.id DESC";
        return mysqli_query($connection, $query);
    }
    return null;
}

function countCartItems($connection)
{
    if(isset($_SESSION['UserID'])) {
        $currUser = $_SESSION['UserID'];
        $query = "SELECT SUM(prod_qty) as psum from carts WHERE user_id = '$currUser'";
        $res = mysqli_query($connection, $query);
        if ($res == false) {
            echo '0';
        } else {
            $prod_counter = mysqli_fetch_assoc($res);
            if ($prod_counter == null) {
                echo '0';
            } else {
                if ($prod_counter['psum'] == null) {
                    echo '0';
                } else {
                    echo $prod_counter['psum'];                
                }
            }
        }
    } else {
        echo '0';
    }
    
}

function getOrders($connection)
{
    if (isset($_SESSION['UserID'])) {
        $currUser = $_SESSION['UserID'];
        $query = "SELECT * from orders WHERE user_id = '$currUser'";
        return mysqli_query($connection, $query);
    }
}

function validTrackingNumber($connection, $tracking_number)
{
    if (isset($_SESSION['UserID'])) {
        $currUser = $_SESSION['UserID'];
        $query = "SELECT* from orders WHERE tracking_no = '$tracking_number' AND user_id = '$currUser'";
        return mysqli_query($connection, $query);
    }
}

function getSearchBooks($connection, $data)
{
    if ($data == "") {
        return null;
    }
    $query = "SELECT Booktitle, imageL from books WHERE Booktitle LIKE '$'$data'$' LIMIT 3";
    return mysqli_query($connection, $query);
}

?>
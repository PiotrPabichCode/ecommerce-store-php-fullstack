<?php

include('../utils/authentication.php');
include('../utils/connect.php');

function validateName($name) {
    if (preg_match("/^[a-zA-Z'. -]+$/", $name)) {
        return true;  
    }
    return false;
}
function validatePrice($price) {
    if (preg_match("/^[0-9]+(\.[0-9]{2})?$/", $price)) {
        return true;  
    }
    return false;
}

if (isset($_POST['update_book'])) {
    $bookID = $_POST['book_id'];
    $title = mysqli_real_escape_string($connection, $_POST['booktitle']);
    $author = mysqli_real_escape_string($connection, $_POST['authorname']);
    $category = $_POST['category'];
    $year = $_POST['year'];
    $quantity = $_POST['quantity'];
    $publisher = mysqli_real_escape_string($connection, $_POST['publishername']);
    $price = (float)$_POST['price'];
    $discount = $_POST['discount'];
    $image = $_POST['image'];

    if (
        $bookID < 1 ||
        !validateName($author) || !validateName($publisher) ||
        strlen($title) == 0 || strlen($title) > 100 ||
        strlen($author) == 0 || strlen($author) > 100 ||
        $year < 1000 || $year > 2023 ||
        $quantity < 0 || $quantity > 100 ||
        strlen($publisher) == 0 || strlen($publisher) > 100 ||
        !validatePrice($price) ||
        strlen($image) == 0 || strlen($image) > 100
    ) {
        $_SESSION['error_message'] = "Something was wrong";
        header('Location: ../views/edit-book.php?id='.$bookID);
        exit(0);
    }

    // AuthorID
    $myauthor = mysqli_query($connection, "SELECT * from authors where AuthorName = '$author'");
    if (mysqli_num_rows($myauthor) == 0) {
        $query_run = mysqli_query($connection, "INSERT INTO authors (AuthorName) values('$author')");
        $myauthor = mysqli_query($connection, "SELECT * from authors where AuthorName = '$author'");
    }
    $authorRows = mysqli_fetch_assoc($myauthor);
    $authorID = $authorRows['AuthorID'];

    // CategoryID
    $mycategory = mysqli_query($connection, "SELECT * from category where CategoryName = '$category'");
    $categoryRows = mysqli_fetch_assoc($mycategory);
    $categoryID = $categoryRows['CategoryID'];

    // PublisherID
    $mypublisher = mysqli_query($connection, "SELECT * from publishers where PublisherName = '$publisher'");
    if (mysqli_num_rows($mypublisher) == 0) {
        $query_run = mysqli_query($connection, "INSERT INTO publishers (PublisherName) values('$publisher')");
        $mypublisher = mysqli_query($connection, "SELECT * from publishers where PublisherName = '$publisher'");
    }
    $publisherRows = mysqli_fetch_assoc($mypublisher);
    $publisherID = $publisherRows['PublisherID'];

    // DiscountID
    $mydiscount = mysqli_query($connection, "SELECT * from discount where Precent = '$discount'");
    $discountRows = mysqli_fetch_assoc($mydiscount);
    $discountID = $discountRows['DiscountID'];

    if ($discount == 0) {
        $priceAfterDiscount = $price;
    } else {
        $priceAfterDiscount = $price - ($price * 0.01 * $discount);
    }



    $query = "UPDATE books set
            Booktitle='$title',
            AuthorID='$authorID',
            CategoryID='$categoryID',
            Year='$year',
            Quantity='$quantity',
            PublisherID='$publisherID',
            Price='$price',
            DiscountID='$discountID',
            PriceAfterDiscount='$priceAfterDiscount'
            WHERE bookID = '$bookID'";
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
        $_SESSION['message'] = "Updated Successfully";
        header('Location: ../views/admin.php');
        exit(0);
    }
}

?>
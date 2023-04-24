<?php

session_start();

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


if(isset($_POST['create'])) {

    include "../utils/connect.php";
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $booktitle = validate($_POST['booktitle']);
    $category = validate($_POST['category']);
    $author = validate($_POST['author']);
    $year = validate($_POST['year']);
    $quantity = validate($_POST['quantity']);
    $publisher = validate($_POST['publisher']);
    $price = validate($_POST['price']);
    $discount = validate($_POST['discount']);
    $image = validate($_POST['image']);

    $user_data = 'booktitle='.$booktitle .    '&category='.$category.
                 '&author='.$author.             '&year='.$year. 
                 '&quantity='.$quantity.         '&publisher='.$publisher. 
                 '&price='.$price.               '&discount='.$discount.
                 '&image='.$image;


    // Book title
    if (empty($booktitle) || strlen($booktitle) == 0 || strlen($booktitle) > 100) {
        $_SESSION['error_message'] = "Book title is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $_SESSION['booktitle-create'] = $booktitle;

    // Category
    if (empty($category) || $category <= 0) {
        $_SESSION['error_message'] = "Category name is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $category_query = "SELECT * from category WHERE CategoryID = '$category'";
    $category_query_run = mysqli_query($connection, $category_query);
    if (mysqli_num_rows($category_query_run) < 0) {
        $_SESSION['error_message'] = "Category doesn't exist";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $categoryData = mysqli_fetch_assoc($category_query_run);
    $category1 = $categoryData['CategoryName'];
    $_SESSION['category-create'] = $category;

    // Author - add if doesn't exist
    if (empty($author) || !validateName($author) || strlen($author) == 0 || strlen($author) > 100) {
        $_SESSION['error_message'] = "Author name is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $_SESSION['author-create'] = $author;

    // Year
    if (empty($year) || $year < 1000 || $year > 2023) {
        $_SESSION['error_message'] = "Year is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $_SESSION['year-create'] = $year;

    // Quantity
    if (empty($quantity) || $quantity < 0 || $quantity > 100) {
        $_SESSION['error_message'] = "Quantity is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $_SESSION['quantity-create'] = $quantity;

    // Publisher - add if doesn't exist
    if (empty($publisher) || $publisher <= 0 || !validateName($publisher) || strlen($publisher) == 0 || strlen($publisher) > 100) {
        $_SESSION['error_message'] = "Publisher name is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $_SESSION['publisher-create'] = $publisher;

    // Price
    if (empty($price) || !validatePrice($price) || $price < 0) {
        $_SESSION['error_message'] = "Price is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $_SESSION['price-create'] = (float)$price;

    // Discount
    if (empty($discount) || $discount <= 0) {
        $_SESSION['error_message'] = "Discount is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $discount_query = "SELECT * from discount WHERE DiscountID = '$discount'";
    $discount_query_run = mysqli_query($connection, $discount_query);
    if (mysqli_num_rows($discount_query_run) < 0) {
        $_SESSION['error_message'] = "Discount doesn't exist";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $discountData = mysqli_fetch_assoc($discount_query_run);
    $discount1 = $discountData['Precent'];
    $_SESSION['discount-create'] = $discount;

    // Image
    if (empty($image) || strlen($image) == 0 || strlen($image) > 100) {
        $_SESSION['error_message'] = "Book image is wrong";
        header("Location: ../views/create-book.php");
        exit(0);
    }
    $_SESSION['image-create'] = $image;

    // Check author
    $author_query = "SELECT * from authors WHERE AuthorName = '$author'";
    $author_query_run = mysqli_query($connection, $author_query);
    if (mysqli_num_rows($author_query_run) <= 0) {
        // New author - create
        $insert_author_query = "INSERT INTO authors (AuthorName) VALUES ('$author')";
        $insert_author_query_run = mysqli_query($connection, $insert_author_query);
        if (!$insert_author_query_run) {
            $_SESSION['error_message'] = "Something went wrong";
            header("Location: ../views/create-book.php");
            exit(0);
        }
        $author_query_run = mysqli_query($connection, $author_query);
    }
    $authorData = mysqli_fetch_array($author_query_run);
    $author_id = $authorData['AuthorID'];
    

    // Check publisher
    $publisher_query = "SELECT * from publishers WHERE PublisherName = '$publisher'";
    $publisher_query_run = mysqli_query($connection, $publisher_query);
    if (mysqli_num_rows($publisher_query_run) <= 0) {
        // New publisher - create
        $insert_publisher_query = "INSERT INTO publishers (PublisherName) VALUES ('$publisher')";
        $insert_publisher_query_run = mysqli_query($connection, $insert_publisher_query);
        if (!$insert_publisher_query_run) {
            $_SESSION['error_message'] = "Something went wrong";
            header("Location: ../views/create-book.php");
            exit(0);
        }
        $publisher_query_run = mysqli_query($connection, $publisher_query);
    }
    $publisherData = mysqli_fetch_array($publisher_query_run);
    $publisher_id = $publisherData['PublisherID'];

    $priceAfterDiscount = ($discount);
    $sql = "INSERT INTO books (Booktitle, CategoryID, AuthorID, Year, Quantity, PublisherID, Price, DiscountID, PriceAfterDiscount, imageL)
    VALUES ('$booktitle', '$category', '$author_id', '$year', '$quantity', '$publisher_id',
        '$price', '$discount', '$priceAfterDiscount', '$image')";
    $res = mysqli_query($connection, $sql);
    if ($res) {
        $_SESSION['message'] = "Book added successfully";
    } else {
        $_SESSION['error_message'] = "Something went wrong";
    }
    unset($_SESSION['booktitle-create']);
    unset($_SESSION['category-create']);
    unset($_SESSION['author-create']);
    unset($_SESSION['year-create']);
    unset($_SESSION['quantity-create']);
    unset($_SESSION['publisher-create']);
    unset($_SESSION['price-create']);
    unset($_SESSION['discount-create']);
    unset($_SESSION['image-create']);
    header('Location: ../views/create-book.php');
    exit(0);

    
}




?>
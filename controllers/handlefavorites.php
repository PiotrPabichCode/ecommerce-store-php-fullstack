<?php
session_start();
include('../utils/connect.php');

if (isset($_SESSION['LoggedIn'])) {
    if (isset($_POST['scope'])) {
        $scope = $_POST['scope'];
        switch ($scope) {
            case "add":
                $prod_id = $_POST['prod_id'];
                $user_id = $_SESSION['UserID'];

                $check_exisiting_favorite = "SELECT * FROM favorites WHERE prod_id='$prod_id' AND user_id='$user_id'";
                $exisiting_favorite_run = mysqli_query($connection, $check_exisiting_favorite);
                if (mysqli_num_rows($exisiting_favorite_run) > 0) {
                    echo "existing";
                } else {
                    $insert_query = "INSERT INTO favorites (user_id, prod_id) VALUES('$user_id', '$prod_id')";
                    $insert_query_run = mysqli_query($connection, $insert_query);
    
                    if ($insert_query_run) {
                        echo 201;
                    } else {
                        echo 501;
                    }
                }
                break;
            case "delete":
                $prod_id = $_POST['prod_id'];
                $user_id = $_SESSION['UserID'];

                $check_exisiting_favorite = "SELECT * FROM favorites WHERE id='$prod_id' AND user_id='$user_id'";
                $exisiting_favorite_run = mysqli_query($connection, $check_exisiting_favorite);
                if (mysqli_num_rows($exisiting_favorite_run) > 0) {
                    $delete_query = "DELETE FROM favorites WHERE id='$prod_id'";
                    $delete_query_run = mysqli_query($connection, $delete_query);
                    if ($delete_query_run) {
                        echo 200;
                    } else {
                        echo "Something went wrong";
                    }
                } else {
                    echo "Something went wrong";
                }
                break;
            default:
                echo 500;
        }
    }
} else {
    echo 401;
}
?>
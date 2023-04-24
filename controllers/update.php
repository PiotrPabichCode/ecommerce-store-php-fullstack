<?php

if (isset($_GET['UserID'])) {
    include "../utils/connect.php";
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $userID = validate($_GET['UserID']);
    $sql = "SELECT * FROM users WHERE UserID = $userID";
    $res = mysqli_query($connection, $sql);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
    } else {
        header("Location: ../views/admin.php");
    }

} else {
    header("Location: ../views/admin.php");
}





?>
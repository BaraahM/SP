<?php
include 'connection.php';
if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

    $sql = "DELETE FROM `users` WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    if($stmt){
        //echo"Deleted successfull";
        header('location:usermanagement.php');
    }
    else{
        die(mysqli_error($conn));
    }
}

?>
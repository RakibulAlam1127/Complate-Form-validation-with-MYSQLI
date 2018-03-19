<?php
//Our delete code will be goes here
$id = $_GET['id'];
$id = ((int) $id);
$connection = mysqli_connect('localhost','root','','complete_form');
if ($connection == false){
    echo mysqli_connect_errno();
    exit();
}else{
    $sql = "DELETE FROM user WHERE id='$id'";
    $stmt = mysqli_query($connection,$sql);
    if ($stmt == false){
        echo mysqli_error($connection);
        exit();
    }else{
        header('Location:view.php');
    }
}

?>
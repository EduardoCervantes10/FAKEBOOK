<?php 

include('imports/db.php');

$id_post = $_GET['id'];

$sql = "DELETE FROM posts
        WHERE id_post = '$id_post'
        ";
mysqli_query($conn, $sql);

header('Location: screen_admin.php');

?>
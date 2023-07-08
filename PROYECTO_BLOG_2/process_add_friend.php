<?php 
include('imports/db.php');

$id_friend = $_GET['id'];
$id_user = $_SESSION['id_user'];

$sql = "INSERT INTO amigos
        (id_user, id_friend)
        VALUES ('$id_user', '$id_friend')";

mysqli_query($conn, $sql);

header('Location: screen_amigos_agregar.php');
?>
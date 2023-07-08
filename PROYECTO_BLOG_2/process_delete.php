<?php 

include('imports/db.php');

$id = $_GET['id'];

# Checamos que no esté haciendo una acción a sí mismo
if($id == $_SESSION['id_user']){
    
    header('Location: screen_admin.php');
}
else{

    # Borramos todos los datos que contengan ese id
    $sql_delete = "DELETE datos_usuarios, sesion_usuarios, posts, amigos
                FROM datos_usuarios
                LEFT JOIN sesion_usuarios ON datos_usuarios.id_user = sesion_usuarios.id_user
                LEFT JOIN posts ON datos_usuarios.id_user = posts.id_user
                LEFT JOIN amigos ON datos_usuarios.id_user = amigos.id_user
                WHERE datos_usuarios.id_user = '$id'";

    mysqli_query($conn, $sql_delete);

    header('Location: screen_admin.php');
}
?>
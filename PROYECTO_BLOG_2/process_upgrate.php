<?php 

include('imports/db.php');

$id = $_GET['id'];

# Checamos que no esté haciendo una acción a sí mismo
if($id == $_SESSION['id_user']){
    
    header('Location: screen_admin.php');
}
else{
    $sql_update = "UPDATE datos_usuarios
                    SET perfil = 'administrador'
                    WHERE id_user= '$id'
                    ";
    mysqli_query($conn, $sql_update);

    header('Location: screen_admin.php');
}
?>
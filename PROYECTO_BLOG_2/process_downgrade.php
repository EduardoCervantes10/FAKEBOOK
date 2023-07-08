<?php 

include('imports/db.php');

$id = $_GET['id'];



# Checamos que no esté haciendo una acción a sí mismo
if($id == $_SESSION['id_user']){
    
    header('Location: screen_admin.php');
}
else{
    # Cambiamos el perfil a 'usuario'
    $sql = "UPDATE datos_usuarios 
    SET perfil = 'usuario'
    WHERE id_user = '$id'";
    mysqli_query($conn, $sql);


    header('Location: screen_admin.php');
}


?>
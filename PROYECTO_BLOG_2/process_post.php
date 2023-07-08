<?php 
# Usamos un archivo, en lugar de una función, ya que los echo al momento
# de usar los headers causaban conflicto en el mismo archivo

include('imports/db.php');

if(isset($_POST['publicar'])){

    # Recibimos los datos ingresados 
    $titulo = $_POST['p_titulo'];
    $contenido = $_POST['p_contenido'];

    # Guardamos el ID de usuario
    $id_user = $_SESSION['id_user'];

    # Sentencia, insertar en tabla 'posts' los datos del post
    $sql = "INSERT INTO posts (id_user, title, body)
    VALUES ('$id_user', '$titulo', '$contenido')";

    # Hacemos la consulta
    mysqli_query($conn, $sql);

    header('Location: screen_profile.php');
}

?>
<?php 
include('imports/header_profile.php'); 
include('imports/functions.php');
include('imports/db.php');
include('navigation.php');
?>

<!-- Ponemos el código arriba evitar error con los header y echo -->
<?php

# Si el usuario presiona 'cambiar foto'
if(isset($_POST['cambiar'])){
    # Guardamos id para evitar errores. Se utilizará para actualizar la foto
    $id_user = $_SESSION['id_user'];

    # Obtenemos los datos de la imagen (La ruta se define dentro de la función)
    $img = $_FILES['ch_imagen'];
    $img_name = $img['name'];   # Nombre de la imagen
    $img_tmp = $img['tmp_name']; # Nombre de la ruta temporal 
   
    # Función que actualiza la foto de perfil
    update_picture($conn, $img_name, $img_tmp, $id_user);
}
?>

<!-- PARTE VISUAL IZQUIERDA -->
<div class="izquierda">

    <!-- Mostramos foto original y nombre del usuario -->
    <a href="screen_picture.php"><img id="img_perfil" src="<?php echo$_SESSION['foto']?>"/></a>
    <h2 id="nombre"> <?php echo$_SESSION['user']?> <hr></h2>
    
</div>

<!-- PARTE VISUAL DEL CENTRO -->
<div class="centro">
    <form action="screen_picture.php" method="post" enctype="multipart/form-data">
        <h1>Cambia tu foto de perfil</h1>
        <h3 id="paso">#1 Elige tu foto</h3>
        <div class="file_container">
            <input class="iimg" type="file" name="ch_imagen">
        </div>
        <br>
        <h3 id="paso">#2 Guarda tu nueva foto</h3>
        <input class="btn_publicar" type="submit" name="cambiar" value="Guardar Foto">
        <hr>
        <a class="cancelar" href="screen_profile.php">Cancelar</a>
    </form>
</div>

<?php include('imports/footer.html'); ?>

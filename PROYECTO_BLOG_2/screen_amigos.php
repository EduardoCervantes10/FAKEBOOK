<?php 
include('imports/header_profile.php'); 
include('imports/db.php');
include('navigation.php');

# Guardamos el id en una variable, para no tener errores por los ' '
$id_user = $_SESSION['id_user'];
?>
    
<!-- PARTE VISUAL IZQUIERDA -->
<div class="izquierda">
    
    <!-- IMAGEN Y NOMBRE -->
    <img id="img_perfil" src="<?php echo$_SESSION['foto']?>"/>
    <h2 id="nombre"> <?php echo$_SESSION['user']?> </h2>

</div>


<!-- PARTE VISUAL CENTRO -->
<div class="centro">

    <h1>AMIGOS</h1>

    <!-- VER AMIGOS AGREGADOS -->
    <?php

        # Ahora juntamos las tablas posts y datos_usuario para mostrar posts
        $sql_amigos = "SELECT * 
                    FROM amigos a
                    INNER JOIN datos_usuarios d
                    ON a.id_friend = d.id_user
                    WHERE a.id_user = '$id_user' 
                    ORDER BY added_at DESC";
        $result_post = mysqli_query($conn, $sql_amigos);
        while($row = mysqli_fetch_array($result_post)){ ?>

            <div class="show_friends" title="Ver perfil" >
                <a href="screen_amigo_profile.php?id=<?php echo$row['id_friend'] ?> ">
                    <img id="img_friends" src="<?php echo$row['foto'] ?>"/>
                    <small><strong> <?php echo"{$row['nombre']} {$row['apellido']}"; ?> </strong></small>
                </a>
            </div>
    <?php } ?>
</div>

<?php include('imports/footer.html'); ?>

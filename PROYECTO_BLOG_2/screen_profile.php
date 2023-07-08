<?php 
include('imports/header_profile.php'); 
include('imports/db.php');
include('navigation.php');

# Guardamos id_user en variable para evitar errores por comillas ''
$id_user = $_SESSION['id_user'];
?>

<!-- PARTE VISUAL IZQUIERDA -->
<div class="izquierda">

    <!-- Mostramos foto y nombre del usuario -->
    <a href="screen_picture.php"><img id="img_perfilh" src="<?php echo$_SESSION['foto']?>"/></a>
    <h2 id="nombre"> <?php echo$_SESSION['user']?> <hr></h2>
    <h3 class="informacion">Información</h3>
    <?php 
        # Conseguimos la información del usuario
        $sql_info = "SELECT *
                    FROM datos_usuarios
                    WHERE id_user = '$id_user'
                    ";
        $result = mysqli_query($conn, $sql_info);

        # Mostramos la información del usuario
        while($row = mysqli_fetch_array($result)){ ?>
        <div class="inf">
            <p> <b>Tipo:</b> <?php echo ucfirst($row['perfil']); ?></p>
            <p> <b>Genero: </b> <?php echo$row['genero']; ?> </p>
            <p> <b>Cumpleaños: </b> <?php echo date("d/m", strtotime($row['nacimiento'])); ?> </p>
            <p> <b>Celular: </b> <?php echo$row['celular']; ?></p>
            <p> <b>Desde: </b> <?php echo date("d/m/y", strtotime($row['reg_date'])) ?></p>
        </div>
    <?php }?>
</div>


<!-- PARTE VISUAL CENTRO -->
<div class="centro">

    <h1>TU PERFIL</h1>
    <!-- Formulario para realizar post -->
    <div class="form_new_post">
        <form action="process_post.php" method="post">
            <input type="text" name="p_titulo" placeholder="Título"><br>
            <textarea name="p_contenido" cols="30" rows="3" placeholder="¿Qué estás pensando?" required></textarea><br>
            <input id="btn_publicar" type="submit" name="publicar" value="Publicar"><br>
        </form>
        <hr>
    </div>

    <!-- Código para ver las publicaciones hechas por el usuario -->
    <?php
        # Juntamos las tablas posts y datos_usuarios
        $sql_post = "SELECT * 
                    FROM posts p
                    INNER JOIN datos_usuarios d
                    ON p.id_user = d.id_user
                    WHERE p.id_user = '$id_user' 
                    ORDER BY created_at DESC";
        $result_post = mysqli_query($conn, $sql_post);

        # Mostramos las publicaciones del usuario
        while($row = mysqli_fetch_array($result_post)){ ?>
            <div class="show_post">
                <!-- Icono de borrado -->
                <a href="process_delete_post.php?id=<?php echo$row['id_post']?> "><i id="trash"class="fa-solid fa-trash"></i></a>
                
                <!-- Imagen del usuario -->
                <img id="img_post" src="<?php echo$row['foto'] ?>"/>
                
                <!-- Título del post -->
                <h2> <?php echo$row['title'] ?></h2>
                
                <!-- Autor / Nombre del usuario -->
                <small> Por: <strong> <?php echo$_SESSION['user']; ?> </strong></small>
                
                <!-- Fecha de creación del post -->
                <small id="created_at">Creado: <?php echo$row['created_at'] ?></small>
                
                <!-- Contenido del post -->
                <p> <?php echo$row['body'] ?> </p>
            </div>
    <?php } ?>
</div>

<?php include('imports/footer.html'); ?>

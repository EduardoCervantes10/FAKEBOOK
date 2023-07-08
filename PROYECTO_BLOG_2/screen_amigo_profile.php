<?php 
include('imports/header_profile.php'); 
include('imports/db.php');
include('navigation.php');

# Obtenemos el id del amigo
$id_amigo = $_GET['id'];

# NOTA: LO HACEMOS DE FORMA DIFERENTE A 'profile' SOLO PARA PRACTICAR
# Guardamos el correo en una variable, para no tener errores por los ' '

$sql = "SELECT * FROM datos_usuarios WHERE id_user='$id_amigo'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

# Guardamos los datos en variables para la legibilidad
$foto_amigo = $row['foto'];
$nombre_amigo = "{$row['nombre']} {$row['apellido']}";


?>

<!-- PARTE VISUAL IZQUIERDA -->
<div class="izquierda">
    
    <!-- IMAGEN Y NOMBRE -->
    <img id="img_perfil" src="<?php echo$foto_amigo?>"/>
    <h2 id="nombre"> <?php echo$nombre_amigo?> <hr></h2>
    <h3 class="informacion">Información</h3>

    <div class="inf">
        <p> <b>Tipo:</b> <?php echo ucfirst($row['perfil']); ?></p>
        <p> <b>Genero: </b> <?php echo$row['genero']; ?> </p>
        <p> <b>Cumpleaños: </b> <?php echo date("d/m", strtotime($row['nacimiento'])); ?> </p>
        <p> <b>Celular: </b> <?php echo$row['celular']; ?></p>
        <p> <b>Desde: </b> <?php echo date("d/m/y", strtotime($row['reg_date'])); ?></p>
    </div>
</div>


<!-- PARTE VISUAL CENTRO -->
<div class="centro">

    <h1>TU AMIGO</h1>
    <!-- VER PUBLICACIONES HECHAS POR TU AMIGO-->
    <?php

        # Ahora juntamos las tablas posts y datos_usuario para mostrar posts
        $sql_post = "SELECT * 
                    FROM posts p
                    INNER JOIN datos_usuarios d
                    ON p.id_user = d.id_user
                    WHERE p.id_user = '$id_amigo' 
                    ORDER BY created_at DESC";
        $result_post = mysqli_query($conn, $sql_post);
        while($row = mysqli_fetch_array($result_post)){ ?>

            <div class="show_post">
                <!-- Si el usuario es administrador puede borrar publicaciones de otros -->
                <?php if($_SESSION['perfil'] == "administrador"){?>
                    <!-- Icono de borrado -->
                    <a href="process_admin_del_post.php?id=<?php echo$row['id_post']?> "><i id="trash"class="fa-solid fa-trash"></i></a>
                    <?php } ?>
                <img id="img_post" src="<?php echo$row['foto'] ?>"/>
                <h2> <?php echo$row['title'] ?></h2>
                <small> Autor: <strong> <?php echo$nombre_amigo; ?> </strong></small>
                <small id="created_at">Creado: <?php echo$row['created_at'] ?></small>
                <p> <?php echo$row['body'] ?> </p>
            </div>

    <?php } ?>
    
</div>

<div class="derecha">
    
</div>

<?php include('imports/footer.html'); ?>

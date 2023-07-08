<?php 
include('imports/header_profile.php'); 
include('imports/db.php');
include('navigation.php');

# Guardamos el id en una variable, para no tener errores por los ' '
$id_user =  $_SESSION['id_user'];
?>
    
<!-- PARTE VISUAL IZQUIERDA -->
<div class="izquierda">
    
    <!-- IMAGEN Y NOMBRE -->
    <img id="img_perfil" src="<?php echo$_SESSION['foto']?>"/>
    <h2 id="nombre"> <?php echo$_SESSION['user']?> </h2>

</div>


<!-- PARTE VISUAL CENTRO -->
<div class="agregar">

    <h1>AGREGAR AMIGOS</h1>

    <!-- VER PERSONAS EN LA APP -->
    <?php

        # CREAMOS UN ARRAY CON NUESTRO ID PRIMERO
        $idsAmigos = array($id_user);

        # SELECCIONAMOS TODOS LOS ID DE AMIGOS
        $sql_lista = "SELECT id_friend
                    FROM amigos
                    WHERE id_user = '$id_user'
                    ";
        $result_lista = mysqli_query($conn, $sql_lista);
        while($row_lista = mysqli_fetch_array($result_lista)){
            # GUARDAMOS LOS ID DE NUESTROS AMIGOS EN EL ARRAY
            array_push($idsAmigos, $row_lista['id_friend']);
        }
        
        # Convertimos el string en array añadiendo comas
        $idAmigos_String = implode(",", $idsAmigos);
        
        # Seleccionamos todos los usuarios menos a amigos y nosotros
        $sql_amigos = "SELECT * 
                    FROM datos_usuarios
                    WHERE id_user NOT IN ($idAmigos_String)
                    ORDER BY reg_date DESC";

        $result_post = mysqli_query($conn, $sql_amigos);
        while($row = mysqli_fetch_array($result_post)){ ?>
            
            <div class="show_people">
                <a id="add_friends" title="Agregar como amigo" href="process_add_friend.php?id=<?php echo$row['id_user'] ?> ">
                <i class="fa-solid fa-plus"></i></a>
                
                <img id="img_people" src="<?php echo$row['foto'] ?>"/>
                <small id="nom_people"><strong> <?php echo"{$row['nombre']} {$row['apellido']}"; ?> </strong></small>    
            </div>       
    <?php } ?>
</div>

<?php include('imports/footer.html'); ?>

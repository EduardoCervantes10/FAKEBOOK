<?php

include('imports/header_profile.php'); 
include('imports/db.php');
include('navigation.php');

?>


<!-- PARTE VISUAL IZQUIERDA -->
<div class="izquierda">
    
    <!-- IMAGEN Y NOMBRE -->
    <img id="img_perfil" src="<?php echo$_SESSION['foto']?>"/>
    <h2 id="nombre"> <?php echo$_SESSION['user']?> </h2>

</div>


<!-- PARTE VISUAL CENTRO -->
<div class="centro_tabla">

        <table>
            <thead>
                <tr>
                    <th>FOTO</th>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>PERFIL</th>
                    <th>ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT *
                        FROM datos_usuarios
                        ";
                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_array($result)){
                ?>
                
                <tr>
                    <td><img id="img_post" src="<?php echo$row['foto']?>"/></td>
                    <td> <?php echo$row['id_user']?> </td>
                    <td> <?php echo"{$row['nombre']} " ?> </td>
                    <td> <?php echo$row['perfil']?> </td>
                    <td>
                        <?php if($row['id_user']!= $_SESSION['id_user']){?>
                        <a alt="hola" href="process_upgrate.php?id=<?php echo$row['id_user']; ?>">
                        <i id="up" class="fa-solid fa-up-long" title="Actualizar a Administrador"></i></a>
                            
                        <a href="process_downgrade.php?id=<?php echo$row['id_user']; ?>">
                        <i id="down" class="fa-solid fa-down-long" title="Actualizar a Usuario"></i></a>

                        <a href="screen_amigo_profile.php?id=<?php echo$row['id_user']; ?> ">
                        <i id="eye"class="fa-solid fa-eye" title="Ver Perfil"></i></a>

                        <a href="process_delete.php?id=<?php echo$row['id_user']; ?>">
                        <i id="del" class="fa-solid fa-trash" title="Borrar Usuario"></i></a>
                        <?php } ?>
                    </td>

                </tr>

                <?php } ?>
            </tbody>
        </table>

</div>

<?php include('imports/footer.html'); ?>

<?php 
# Incluimos conexión a base de datos - funciones - header
include('imports/db.php');
include('imports/functions.php');
include('imports/header.html');
?>

<!-- REGISTRO -->
<div class="formulario">

    <!-- Si hay un mensaje en la sesión (alert), se muestra -->
    <?php 
    if(isset($_SESSION['m'])){
        echo$_SESSION['m'];
        unset($_SESSION['m']);
    }
    ?>

    <!-- Formulario de registro -->
    <!-- enctype es para que el formulario permita imágenes u otros documentos -->
    <form action="screen_register.php" method="POST" enctype="multipart/form-data">
        <h4><i class="fa-solid fa-file-pen"></i>Regístrate</h4>
        <p>Es muy sencillo</p>
        <hr>
        <!-- Funciones hechas para la legibilidad del código-->
        <!--               class   type      name      placeholder -->
        <?php   inputText('etxt', 'text',   'f_nombre',     'Nombre');      ?>
        <?php   inputText('etxt', 'text',   'f_apellido',   'Apellido')     ?>
        <?php   inputText('itxt', 'email',  'f_correo',     'Correo')       ?>
        <?php   inputText('itxt', 'tel',    'f_cel',        'Celular');     ?>
        <?php   inputText('itxt', 'password','f_pass',      'Contraseña');  ?>
        <?php   inputText('itxt', 'password','f_confirm',   'Confirmar contraseña');  ?>

        <!-- Calendario para que el usuario ingrese su fecha de nacimiento -->
        <span>Fecha de nacimiento</span><br>
        <?php   inputText('date', 'date',   'f_date',      '');  ?> <br>

        <!-- RadioGroup para que el usuario selecciones su genero -->
        <!--            class  name    value -->
        <span>Genero:</span><br>
        <?php inputRadio('r','f_gen', 'Mujer')?>
        <?php inputRadio('r','f_gen', 'Hombre')?>
        <?php inputRadio('r','f_gen', 'Otro')?>

        <!-- Input para subir la foto de perfil -->
        <span>Ingresa tu foto de perfil</span>
        <input class="iimg" type="file" name="f_imagen"><br>

        <input class="btn" type="submit" name="registrarse" value="Registrarse">
        <a href="index.php">Cancelar</a>
    </form>
</div>


<?php 

if(isset($_POST['registrarse'])){

    # Guardamos todos los inputs en variables
    $pass = $_POST['f_pass'];
    $pass2 = $_POST['f_confirm'];
    $nom = $_POST['f_nombre'];
    $lst = $_POST['f_apellido'];
    $eml = $_POST['f_correo'];
    $cel = $_POST['f_cel'];
    $nac = $_POST['f_date'];
    $gen = $_POST['f_gen'];

    # Obtenemos los datos de la imagen
    $img = $_FILES['f_imagen'];
    $img_name = $img['name'];   # Nombre de la imagen
    $img_tmp = $img['tmp_name']; # Nombre de la ruta temporal 
    $img_route = "imgs/{$img_name}"; # <- Ruta donde se guarda la imagen
   
    # Si el usuario no subió imagen
    if(empty($img_name)){
        $img_route = "imgs/defecto.png";
    }

    # Función para registrar usario
    to_register($conn, $pass,  $pass2, $nom, $lst, $eml, $cel, $nac, $gen, $img_tmp, $img_route);
}

?>
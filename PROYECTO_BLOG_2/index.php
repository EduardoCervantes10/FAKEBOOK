<?php 
include('imports/db.php');
include('imports/functions.php');
include('imports/header.html');
?>

<!-- LOGIN -->
<div class="formulario">

    <!-- Si hay un mensaje en la sesión (alert), se muestra -->
    <?php 
    if(isset($_SESSION['m'])){
        echo$_SESSION['m'];
        unset($_SESSION['m']);
    }
    ?>

    <!--Fromulario de login-->
    <form action="index.php" method="post">
        <?php inputText('itxt', 'email', 'f_email', 'Correo'); ?><br>
        <?php inputText('itxt', 'password', 'f_pass', 'Contraseña')?><br>
        <input class="btn" type="submit" name="login" value="Login"><br>
        <hr>
        <span>¿Aún no tienes cuenta?</span>
        <a href="screen_register.php">Crear cuenta nueva</a>
    </form>
</div>


<?php 
    if(isset($_POST['login'])){

        # Obtenemos los datos del formulario
        $email = $_POST['f_email'];
        $pass = $_POST['f_pass'];

        # Función login
        to_login($conn, $email, $pass);
    }
?>
<!-- NAVIGATION -->
<!-- No se guarda en 'functions' por problemas con db.php -->

<nav class="navigationbar">
    <ul>
        <li id="feed"><a href="screen_profile.php"><i class="fa-solid fa-user" title="Tu Perfil"></i></a></li>
        <li id="ams"><a href="screen_amigos.php"><i class="fa-solid fa-address-book" title="Amigos"></i></a></li>
        <li id="addams"><a href="screen_amigos_agregar.php"><i class="fa-solid fa-user-plus" title="Agregar Amigos"></i></a></li>
        <li id="logout"><a href="process_logout.php"><i class="fa-solid fa-right-from-bracket" title="Salir"></i></a></li>
        
        <!-- Si el perfil es tipo administrador, muestra botón administrador-->
        <?php if($_SESSION['perfil'] == "administrador") { ?>
        <li id="admn"><a href="screen_admin.php"><i class="fa-solid fa-hammer" title="Superusario"></i></a></li>
        <?php } ?>
    </ul>
</nav>
    


<?php 

session_start();

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "segundo_proyecto_blog";

try{
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
}
catch(mysqli_sql_exception){
    $_SESSION['m'] = '
    <div class="alert alert-danger" role="alert">
        Error al conectarse a la base de datos
    </div>
    ';
}

?>
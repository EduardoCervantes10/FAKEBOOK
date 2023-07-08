<?php 

# Función para input de tipo texto. Solo por legibilidad.
function inputText($class, $type, $name, $placeholder){
    $inp =  "
    <input class=\"{$class}\" type=\"{$type}\" name=\"$name\" placeholder=\"$placeholder\" required autocomplete=\"off\" autofocus>
    ";
    echo$inp;
};

# Función para input tipo radio. Solo para legibilidad.
function inputRadio($class, $name, $value){
    $inp = "
    <label class=\"{$class}\">
        <input type=\"radio\" name=\"$name\" value=\"$value\"required>$value
    </label>
    ";
    echo$inp;
}

# Función para registrarse
function to_register($conn, $pass, $pass2,$nom, $lst, $eml, $cel, $nac, $gen, $img_tmp, $img_route){

    # Verificamos que las 2 contraseñas ingresadas sean las mismas
    $pass = $_POST['f_pass'];
    $pass2 = $_POST['f_confirm'];

    # Si no son las mismas, se carga mensaje en sesión y regresamos al registro
    if($pass != $pass2){
        $_SESSION['m'] = '
        <div class="alert alert-warning" role="alert">
            Las contraseñas no coinciden, intenta de nuevo
        </div>
        ';
        header("Location: screen_register.php");
    }

    # Si son las mismas contraseñas, continúa
    else{

        # Le ponemos un hash a la contraseña
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        # Creamos las sentencias sql y la guardamos en una variable
        # Insertamos los datos a la tabla 'datos_usuarios'
        $sql = "INSERT INTO datos_usuarios
                (perfil, nombre, apellido, celular, nacimiento, genero, foto)
                VALUES 
                ('usuario', '$nom', '$lst','$cel', '$nac', '$gen', '$img_route');

                INSERT INTO sesion_usuarios
                    (correo, contraseña)
                    VALUES
                    ('$eml', '$hash');
        ";

        # Guardamos los datos en ambas tablas al mismo intento
        try{

            mysqli_multi_query($conn, $sql);   
            
            # Movemos la imagen de la ruta temporal a la final
            move_uploaded_file($img_tmp, $img_route);

            # Mandamos una alerta de éxito al login
            $_SESSION['m'] = '
            <div class="alert alert-success" role="alert">
                ¡Registro de usuario exitoso!
                Ahora puedes iniciar sesión
            </div>
            '; 
            header('Location:index.php');
        }

        # En caso de que haya un error, mandamos una alerta de error al login
        catch(mysqli_sql_exception){
            $_SESSION['m'] = '
            <div class="alert alert-danger" role="alert">
                <strong>Error</strong>No se pudo registrar el usuario. BD datos_usuario
            </div>
            '; 
            header('Location: screen_register.php');
        }
    }


}

# Función hacer login.
function to_login($conn, $email, $pass){

    # Consulta para obtener el dato de la tabla sesion_usuario
    $sql = "SELECT * FROM sesion_usuarios WHERE correo = '$email'";
    try{
        
        $result = mysqli_query($conn, $sql);

        # Guardamos el número de filas que tengan el correo
        $num_rows = mysqli_num_rows($result);

        # Verificamos si existe el correo.
        if($num_rows >= 1){

            $fetch = mysqli_fetch_array($result);   # Para tener los datos de la tabla
            $pass_tabla = $fetch['contraseña'];
            
            # Verificamos si la contraseña ingresada y el hash coinciden.
            if(password_verify($pass, $pass_tabla) || $pass==$pass_tabla){

                # Cerramos la sesión anterior (Las alertas)
                session_destroy();

                # Abrimos la sesión para las variables que son del usuario
                # No se destruirá hasta que el usuario cierre sesión
                session_start();

                #______________________________________________________
                # Obtenemos el id_user de la tabla 
                $id_user = $fetch['id_user'];

                # Ahora obtenemos los datos de la tabla datos_usuarios
                $sql_data = "SELECT * FROM datos_usuarios WHERE id_user = '$id_user'"; 
                $result_data = mysqli_query($conn, $sql_data);
                $fetch_data = mysqli_fetch_array($result_data);

                # Ponemos en SESSION los datos de la tabla 'datos_usuarios'
                $_SESSION['id_user'] = $fetch_data['id_user'];
                $_SESSION['user'] = "{$fetch_data['nombre']} {$fetch_data['apellido']}";
                $_SESSION['perfil'] = $fetch_data['perfil'];
                $_SESSION['celular'] = $fetch_data['celular'];
                $_SESSION['nacimiento'] = $fetch_data['nacimiento'];
                $_SESSION['genero'] = $fetch_data['genero'];
                $_SESSION['foto'] = $fetch_data['foto'];
                $_SESSION['reg_date'] = $fetch_data['reg_date'];

                header("Location: screen_profile.php");

            }
            else{
                $_SESSION['m'] = '
                        <div class="alert alert-danger" role="alert">
                            Contraseña incorrecta. Inténtalo de nuevo.
                        </div>';
                header('Location: index.php');
            }
        }
        else{
            $_SESSION['m'] = '
                <div class="alert alert-danger" role="alert">
                    Correo no encontrado. Asegúrate de registrarte primero.
                </div>';
            header('Location: index.php');
        }
        
    }
    catch(mysqli_sql_exception){
        $_SESSION['m'] = '
                <div class="alert alert-danger" role="alert">
                    Error de Base de Datos desconocida
                </div>';
            header('Location: index.php');
    }  
}

# Función cambiar foto de perfil
function update_picture($conn, $img_name, $img_tmp, $id_user){

    # Si el usuario SÍ subió una imagen, procede 
    if(!empty($img_name)){
        
        # Ruta donde se guarda la imagen
        $img_route = "imgs/{$img_name}"; 

        # Guardamos la imagen en la ruta
        move_uploaded_file($img_tmp, $img_route);

        # Sentencia SQL
        $sql = "UPDATE datos_usuarios
                SET foto = '$img_route'
                WHERE id_user = '$id_user'
        ";
        mysqli_query($conn, $sql);

        # Guardamos en la sesion la nueva ruta
        $_SESSION['foto'] = $img_route;

        header('Location: screen_profile.php');
    }
    # De lo contrario, no pasa nada
}

?>

<?php
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$genero = $_POST['genero'];
$email = $_POST['email'];
$materia = $_POST['materia'];

//include permite añadir documentos

/*// Create connection
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

$INSERT = "INSERT INTO usuario (nombre, password, genero, email, materia) VALUES (?, ?, ?, ?, ?)";


mysqli_close($conn);*/

// PRUEBA
/*
if (!empty($nombre) && !empty($password) && !empty($genero) && !empty($email) && !empty($materia)) {
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'estudiante';

    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname) or die('Problemas al conectar');

    mysqli_select_db($conn,$dbname) or die('Problema al conectar');

    mysqli_query($conn, "INSERT INTO usuario(nombre, password, genero, email, materia) VALUES ($nombre, $password, $genero, $email, $materia)");
    echo 'Datos insertados';
} else{
    echo 'Problemas al insertar datos';
}


*/

if (!empty($nombre) || !empty($password) || !empty($genero) || !empty($email) || !empty(materia)) {
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'estudiante';

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Error de conexión: ' . $conn->connect_errno);
    } else{
            //SENTENCIAS PREPARAADAS: mejoran la seguridad
            $SELECT = "SELECT email from usuario where email = ? limit 1";
            $INSERT = "INSERT INTO `usuario`(`nombre`, `password`, `genero`, `email`, `materia`) VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $conn -> prepare($SELECT);
            $stmt -> bind_param('s', $email);
            $stmt ->  execute();
            $stmt -> bind_result($email);
            $stmt -> store_result(); //Transfiere el conjunto de resultados
            
            $rnum = $stmt -> num_rows;    
            
            if($rnum == 0){
                $stmt -> close(); // Cerrar la conexión de la base de datos
                $stmt = $conn -> prepare($INSERT);
                $stmt -> bind_param("sssss", $nombre, $password, $genero, $email, $materia);
                $stmt -> execute();
                echo "REGISTRO EXITOSO!";
 
            }else{
                echo "Correo ya registrado.";
            }
        }
        $stmt -> close();
        $conn -> close();
    }else{
    echo 'Todos los datos son obligatorios';
    die(); // Equivalente a salida
}


?>
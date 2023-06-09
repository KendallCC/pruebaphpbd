<?php

require 'flight/Flight.php';

$host = 'containers-us-west-136.railway.app';
$port = '5748';
$db   = 'railway';
$user = 'root';
$pass = '3bjNNgl4cdzdqDvV0VRi';
// $charset = 'utf8mb4_general_ci';

$dsn = "mysql:host=$host;dbname=$db;port=$port";
// Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api', 'root', ''));
Flight::register('db', 'PDO', array($dsn, $user, $pass));
#Leer los datos y los muestra a cualqueir interfase que solicita los datos
Flight::route('GET /alumnos', function () {

    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

//resepciona los datos por metodo post y hace una insercion
Flight::route('POST /alumnos', function () {
    $nombres = (Flight::request()->data->nombres);
    $apellidos = (Flight::request()->data->apellidos);

    $sql = "INSERT INTO alumnos (nombres,apellidos) values(?,?)";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);
    $sentencia->execute();
    Flight::jsonp(["alumno agregado"]);
});

//borrar Registro
Flight::route('DELETE /alumnos', function () {
    $id = (Flight::request()->data->id);

    $sql = 'DELETE FROM alumnos WHERE id=?';
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    Flight::jsonp(["alumno Eliminado"]);
});

//actualizar Registros
Flight::route('PUT /alumnos', function () {
    $id = (Flight::request()->data->id);
    $nombres = (Flight::request()->data->nombres);
    $apellidos = (Flight::request()->data->apellidos);

    $sql = 'UPDATE alumnos SET nombres=? , apellidos=? WHERE id=?';
    $sentencia = Flight::db()->prepare($sql);
    
    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);
    $sentencia->bindParam(3, $id);

    $sentencia->execute();
    Flight::jsonp(["alumno Editado"]);
});


Flight::route('GET /alumnos/@id', function ($id) {
    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos` where id=?");
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});


//lectura de un registro determinado





Flight::start();

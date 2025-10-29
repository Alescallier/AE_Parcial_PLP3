<?php
// AE_conexion.php — conexión MySQL (mysqli)
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','foodexpress');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) { http_response_code(500); die('Error de conexión: '.mysqli_connect_error()); }
mysqli_set_charset($con, 'utf8mb4');
?>

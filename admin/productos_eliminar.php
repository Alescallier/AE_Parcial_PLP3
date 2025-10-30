<?php
require __DIR__.'/../includes/AE_conexion.php';
$id = intval($_GET['id'] ?? 0);
if ($id){ mysqli_query($con, "DELETE FROM productos WHERE id=$id"); }
header("Location: productos_listar.php");

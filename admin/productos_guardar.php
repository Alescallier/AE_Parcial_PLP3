<?php
require __DIR__.'/../includes/AE_conexion.php';
$id = intval($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$categoria_id = intval($_POST['categoria_id'] ?? 0);
$precio = floatval($_POST['precio'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);
$descripcion = trim($_POST['descripcion'] ?? '');

if (!$nombre || !$categoria_id || $precio<=0 || $stock<0){
  die('Datos inválidos');
}

if ($id){
  $stmt = mysqli_prepare($con, "UPDATE productos SET nombre=?, categoria_id=?, precio=?, stock=?, descripcion=? WHERE id=?");
  mysqli_stmt_bind_param($stmt, "sidisi", $nombre, $categoria_id, $precio, $stock, $descripcion, $id);
  mysqli_stmt_execute($stmt);
} else {
  $stmt = mysqli_prepare($con, "INSERT INTO productos (nombre, categoria_id, precio, stock, descripcion) VALUES (?,?,?,?,?)");
  mysqli_stmt_bind_param($stmt, "sidis", $nombre, $categoria_id, $precio, $stock, $descripcion);
  mysqli_stmt_execute($stmt);
}
header("Location: productos_listar.php");

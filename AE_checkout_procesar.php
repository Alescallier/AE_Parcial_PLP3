<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__.'/includes/AE_conexion.php';

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data){ http_response_code(400); echo json_encode(['error'=>'Payload inválido']); exit; }

$cliente = $data['cliente'] ?? null;
$items = $data['items'] ?? [];
$envio = floatval($data['envio'] ?? 0);

if (!$cliente || !count($items)){
  http_response_code(400); echo json_encode(['error'=>'Faltan datos de cliente o ítems']); exit;
}

$ids = array_map(fn($i)=>intval($i['id']), $items);
$ids = array_unique($ids);
$ids_str = implode(',', $ids);
if (!$ids_str){ http_response_code(400); echo json_encode(['error'=>'Sin ítems']); exit; }

$q = mysqli_query($con, "SELECT id, nombre, precio FROM productos WHERE id IN ($ids_str)");
$map = [];
while($row = mysqli_fetch_assoc($q)){ $map[intval($row['id'])] = $row; }

$subtotal = 0;
$detalles = [];
foreach($items as $it){
  $pid = intval($it['id']); $cant = max(1, intval($it['cantidad']));
  if (!isset($map[$pid])){ http_response_code(400); echo json_encode(['error'=>"Producto $pid no existe"]); exit; }
  $precio = floatval($map[$pid]['precio']);
  $sub = $precio * $cant;
  $subtotal += $sub;
  $detalles[] = ['producto_id'=>$pid, 'cantidad'=>$cant, 'precio_unit'=>$precio, 'subtotal'=>$sub];
}

$total = $subtotal + $envio;

$stmt = mysqli_prepare($con, "INSERT INTO pedidos (nombre_cliente, email, telefono, direccion, total) VALUES (?,?,?,?,?)");
$nombreCompleto = trim(($cliente['nombre'] ?? '').' '.($cliente['apellido'] ?? ''));
$email = $cliente['email'] ?? '';
$tel = $cliente['telefono'] ?? '';
$dir = $cliente['direccion'] ?? '';
mysqli_stmt_bind_param($stmt, "ssssd", $nombreCompleto, $email, $tel, $dir, $total);
if (!mysqli_stmt_execute($stmt)){
  http_response_code(500); echo json_encode(['error'=>'No se pudo registrar el pedido']); exit;
}
$pedido_id = mysqli_insert_id($con);

$itstmt = mysqli_prepare($con, "INSERT INTO pedido_items (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?,?,?,?,?)");
foreach($detalles as $d){
  mysqli_stmt_bind_param($itstmt, "iiidd", $pedido_id, $d['producto_id'], $d['cantidad'], $d['precio_unit'], $d['subtotal']);
  mysqli_stmt_execute($itstmt);
}

echo json_encode(['ok'=>true, 'pedido_id'=>$pedido_id, 'total'=>$total]);

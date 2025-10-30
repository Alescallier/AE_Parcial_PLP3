<?php
require __DIR__.'/../includes/AE_conexion.php';
$prods = mysqli_query($con, "SELECT p.id, p.nombre, p.precio, p.stock, c.nombre as categoria 
  FROM productos p INNER JOIN categorias c ON c.id=p.categoria_id ORDER BY p.id DESC");
?>
<!DOCTYPE html>
<html lang="es"><head>
<meta charset="utf-8"><title>Admin — Productos</title>
<link rel="stylesheet" href="../css/AE_estilos.css">
</head><body>
<header><div class="container header-row">
  <div class="brand"><span class="logo">🛠️</span> <span>Admin Productos</span></div>
  <nav><a href="productos_form.php" class="btn btn-primary">+ Nuevo</a></nav>
</div></header>
<main class="container section">
<table style="width:100%;border-collapse:collapse;background:#fff;color:#222;border-radius:12px;overflow:hidden">
  <thead style="background:#f0f0ff">
    <tr><th style="padding:10px;text-align:left">ID</th><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Stock</th><th>Acciones</th></tr>
  </thead>
  <tbody>
  <?php while($p=mysqli_fetch_assoc($prods)): ?>
    <tr style="border-top:1px solid #eee">
      <td style="padding:10px"><?php echo $p['id']; ?></td>
      <td><?php echo htmlspecialchars($p['nombre']); ?></td>
      <td><?php echo htmlspecialchars($p['categoria']); ?></td>
      <td>$<?php echo number_format($p['precio'],2,',','.'); ?></td>
      <td><?php echo intval($p['stock']); ?></td>
      <td>
        <a class="btn" href="productos_form.php?id=<?php echo $p['id']; ?>">Editar</a>
        <a class="btn" style="background:#e74c3c;color:#fff" 
           onclick="return confirm('¿Eliminar producto?')" 
           href="productos_eliminar.php?id=<?php echo $p['id']; ?>">Eliminar</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</main>
</body></html>

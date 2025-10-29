<?php
require __DIR__.'/../includes/AE_conexion.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$prod = ['id'=>0,'nombre'=>'','descripcion'=>'','precio'=>'','stock'=>0,'categoria_id'=>''];
if ($id){
  $q = mysqli_query($con, "SELECT * FROM productos WHERE id=$id");
  $prod = mysqli_fetch_assoc($q);
}
$cats = mysqli_query($con, "SELECT id, nombre FROM categorias ORDER BY nombre");
?>
<!DOCTYPE html>
<html lang="es"><head>
<meta charset="utf-8"><title><?php echo $id?'Editar':'Nuevo';?> Producto</title>
<link rel="stylesheet" href="../css/AE_estilos.css">
</head><body>
<header><div class="container header-row">
  <div class="brand"><span class="logo">🛠️</span> <span><?php echo $id?'Editar':'Nuevo';?> Producto</span></div>
  <nav><a href="productos_listar.php" class="btn btn-outline">← Volver</a></nav>
</div></header>
<main class="container section">
  <form action="productos_guardar.php" method="post" class="form">
    <input type="hidden" name="id" value="<?php echo $prod['id'] ?>">
    <div class="row">
      <div>
        <label>Nombre *</label>
        <input required name="nombre" value="<?php echo htmlspecialchars($prod['nombre']) ?>">
      </div>
      <div>
        <label>Categoría *</label>
        <select required name="categoria_id">
          <option value="">Seleccioná</option>
          <?php while($c=mysqli_fetch_assoc($cats)): ?>
            <option value="<?php echo $c['id'] ?>" <?php echo ($c['id']==$prod['categoria_id'])?'selected':'' ?>>
              <?php echo htmlspecialchars($c['nombre']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div>
        <label>Precio *</label>
        <input required name="precio" type="number" step="0.01" min="0" value="<?php echo htmlspecialchars($prod['precio']) ?>">
      </div>
      <div>
        <label>Stock *</label>
        <input required name="stock" type="number" min="0" value="<?php echo intval($prod['stock']) ?>">
      </div>
    </div>
    <div>
      <label>Descripción</label>
      <input name="descripcion" value="<?php echo htmlspecialchars($prod['descripcion']) ?>">
    </div>
    <div class="actions">
      <a href="productos_listar.php" class="btn">Cancelar</a>
      <button class="btn btn-primary" type="submit">Guardar</button>
    </div>
  </form>
</main>
</body></html>

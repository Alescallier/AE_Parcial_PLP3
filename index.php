<?php
require __DIR__.'/includes/AE_conexion.php';
$cats = mysqli_query($con, "SELECT id, nombre, slug FROM categorias ORDER BY nombre");
$prods = mysqli_query($con, "SELECT p.id, p.nombre, p.descripcion, p.precio, IFNULL(p.imagen,'') as imagen, c.slug as categoria, 
  CASE 
    WHEN c.slug='pizzas' THEN '🍕'
    WHEN c.slug='empanadas' THEN '🥟'
    WHEN c.slug='bebidas' THEN '🥤'
    WHEN c.slug='postres' THEN '🍮'
    ELSE '🍽️' END as emoji
  FROM productos p INNER JOIN categorias c ON c.id = p.categoria_id ORDER BY p.id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodExpress — Menú</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/AE_estilos.css">
</head>
<body>
<header>
  <div class="container header-row">
    <div class="brand">
      <span class="logo">🍔</span> <span>FoodExpress</span>
    </div>
    <nav>
      <button id="btnCarrito" class="btn btn-outline">🛒 Carrito <span id="contadorCarrito" class="badge">0</span></button>
    </nav>
  </div>
</header>

<main class="container">
  <section class="section filtros">
    <h2>Filtrar por categoría</h2>
    <div class="filtros-botones">
      <button class="btn-filtro active" data-filtro="todos">Todos</button>
      <?php while($c = mysqli_fetch_assoc($cats)): ?>
        <button class="btn-filtro" data-filtro="<?php echo htmlspecialchars($c['slug']); ?>">
          <?php echo htmlspecialchars(ucfirst($c['nombre'])); ?>
        </button>
      <?php endwhile; ?>
    </div>
  </section>

  <section class="section">
    <div class="grid">
      <?php while($p = mysqli_fetch_assoc($prods)): ?>
        <article class="card" 
                 data-id="<?php echo $p['id'];?>"
                 data-categoria="<?php echo htmlspecialchars($p['categoria']);?>"
                 data-nombre="<?php echo htmlspecialchars($p['nombre']);?>"
                 data-precio="<?php echo number_format($p['precio'],2,'.','');?>"
                 data-emoji="<?php echo $p['emoji'];?>">
          <div class="thumb"><?php echo $p['emoji'];?></div>
          <div class="info">
            <span class="tag"><?php echo htmlspecialchars($p['categoria']);?></span>
            <h3><?php echo htmlspecialchars($p['nombre']);?></h3>
            <div class="price">$<?php echo number_format($p['precio'],2,',','.');?></div>
          </div>
          <div class="actions">
            <button class="btn-add btn">Agregar</button>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
  </section>
</main>
<footer><p>&copy; <?php echo date('Y'); ?> FoodExpress — Todos los derechos reservados.</p></footer>
<script src="js/AE_script.js"></script>
</body>
</html>

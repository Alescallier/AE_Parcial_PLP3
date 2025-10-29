<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito — FoodExpress</title>
  <link rel="stylesheet" href="css/AE_estilos.css">
</head>
<body>
<header>
  <div class="container header-row">
    <div class="brand"><span class="logo">🛒</span> <span>Tu Carrito</span></div>
    <nav><button id="btnVolver" class="btn btn-outline">← Volver al menú</button></nav>
  </div>
</header>

<main class="container">
  <h2 class="section">Resumen de tu pedido</h2>

  <div id="carritoVacio" class="cart-empty">
    <p>Tu carrito está vacío</p>
    <button id="btnVolverVacio" class="btn btn-primary">Ir a comprar</button>
  </div>

  <div id="carritoContenido" class="cart-layout" style="display:none">
    <div class="cart-items" id="carritoItems"></div>
    <aside class="summary">
      <h3>Resumen</h3>
      <div class="line"><span>Subtotal:</span><span id="subtotal">$0</span></div>
      <div class="line"><span>Envío:</span><span id="envio">$0</span></div>
      <div class="line total"><strong>Total:</strong><strong id="total">$0</strong></div>
      <button id="btnFinalizarCompra" class="btn btn-primary" style="width:100%;margin-top:12px">Finalizar compra</button>
    </aside>
  </div>

  <div id="modalCheckout" class="modal">
    <div class="box">
      <span class="close">&times;</span>
      <h2>Completar compra</h2>

      <form id="formCheckout" class="form">
        <h3>Datos personales</h3>
        <div class="row">
          <div>
            <label for="nombre">Nombre *</label>
            <input required id="nombre" name="nombre" type="text">
          </div>
          <div>
            <label for="apellido">Apellido *</label>
            <input required id="apellido" name="apellido" type="text">
          </div>
          <div>
            <label for="dni">DNI *</label>
            <input required id="dni" name="dni" type="text" pattern="[0-9]{7,8}">
          </div>
          <div>
            <label for="email">Email *</label>
            <input required id="email" name="email" type="email">
          </div>
          <div>
            <label for="telefono">Teléfono *</label>
            <input required id="telefono" name="telefono" type="tel">
          </div>
          <div>
            <label for="direccion">Dirección</label>
            <input id="direccion" name="direccion" type="text">
          </div>
        </div>

        <h3>Forma de pago</h3>
        <div>
          <label for="formaPago">Método *</label>
          <select required id="formaPago" name="formaPago">
            <option value="">Seleccioná</option>
            <option value="tarjeta">Tarjeta</option>
            <option value="transferencia">Transferencia</option>
            <option value="efectivo">Efectivo</option>
          </select>
        </div>

        <div id="datosTarjeta" style="display:none">
          <div class="row">
            <div>
              <label for="numeroTarjeta">Número *</label>
              <input id="numeroTarjeta" name="numeroTarjeta" maxlength="16" pattern="[0-9]{16}" placeholder="1234123412341234">
            </div>
            <div>
              <label for="vencimiento">Vencimiento *</label>
              <input id="vencimiento" name="vencimiento" maxlength="5" placeholder="MM/AA" pattern="[0-9]{2}/[0-9]{2}">
            </div>
            <div>
              <label for="cvv">CVV *</label>
              <input id="cvv" name="cvv" maxlength="4" pattern="[0-9]{3,4}">
            </div>
          </div>
          <div>
            <label for="nombreTitular">Nombre del titular *</label>
            <input id="nombreTitular" name="nombreTitular">
          </div>
        </div>

        <div id="datosTransferencia" style="display:none">
          <p><strong>CBU:</strong> 0123456789012345678901 — <strong>Alias:</strong> FOO.DEX.PRESS</p>
          <label for="comprobanteTransferencia">N° de comprobante *</label>
          <input id="comprobanteTransferencia" name="comprobanteTransferencia" placeholder="Ej: 9876543210">
        </div>

        <div id="datosEfectivo" style="display:none">
          <p>Pagás en efectivo al recibir el pedido. Tené el monto justo, por favor.</p>
        </div>

        <div class="actions">
          <button type="button" id="btnCancelar" class="btn">Cancelar</button>
          <button type="submit" class="btn btn-primary">Confirmar compra</button>
        </div>
      </form>
    </div>
  </div>

  <div id="modalConfirmacion" class="modal">
    <div class="box success">
      <h2>✅ ¡Compra realizada!</h2>
      <p>Número de orden: <strong>#<span id="numeroOrden"></span></strong></p>
      <button id="btnVolverTienda" class="btn btn-primary">Volver al menú</button>
    </div>
  </div>
</main>

<footer><p>&copy; <?php echo date('Y'); ?> FoodExpress</p></footer>

<script src="js/AE_carrito.js"></script>
</body>
</html>

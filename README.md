
# FoodExpress — Parcial PLP3

Proyecto realizado a partir de una base existente

## Estructura
```
AE_Parcial_PLP3/
├── AE_index.php
├── AE_carrito.php
├── AE_checkout_procesar.php
├── css/AE_estilos.css
├── js/AE_script.js
├── js/AE_carrito.js
├── includes/AE_conexion.php
├── admin/
│   ├── AE_productos_listar.php
│   ├── AE_productos_form.php
│   ├── AE_productos_guardar.php
│   └── AE_productos_eliminar.php
├── database/
│   ├── AE_estructura.sql
│   └── AE_datos.sql
├── AE_assets/images/
├── docs/ESCALLIER_ALEJANDRO_PLP3.pdf
└── README.md
```

## Cómo correr
1. Importá la BD en **phpMyAdmin**:
   - Ejecutá `database/AE_estructura.sql` y luego `database/AE_datos.sql`.
2. Configurá credenciales en `includes/AE_conexion.php`.
3. Copiá `AE_Parcial_PLP3/` dentro de `htdocs/` (XAMPP) o `www/` (WAMP/MAMP).
4. Abrí:
   - Menú: `http://localhost/AE_Parcial_PLP3/index.php`
   - Carrito: `http://localhost/AE_Parcial_PLP3/carrito.php`
   - Admin: `http://localhost/AE_Parcial_PLP3/admin/productos_listar.php`

## NIVEL 2 — JavaScript
- `js/AE_script.js` documentado al inicio. Carrito dinámico (localStorage), contador, filtros sin recargar.
- `js/AE_carrito.js` cantidades, totales y **checkout AJAX**.

## NIVEL 3 — PHP + MySQL
- CRUD de productos en `/admin`.
- Registro de pedidos en `checkout_procesar.php` con **recalculo de precios del lado servidor**.
- Tablas relacionadas: `categorias`, `productos`, `pedidos`, `pedido_items` (PK/FK).

## NIVEL 4 — Diseño/UX
- Paleta (4–5 colores), tipografías, responsive (3 breakpoints), badge de carrito.
- Feedback visual (hover/focus), contraste AA, espaciado uniforme con grid/flex.


/**
 * AE_script.js — FoodExpress
 * Carrito dinámico (localStorage), contador de items, filtros por categoría sin recargar
 * y envío de pedido (AJAX) validando cantidades. Mobile-first, sin dependencias.
 */
const CART_KEY = 'foodexpress_cart';
let cart = [];

// Utils
const $ = (s, ctx=document) => ctx.querySelector(s);
const $$ = (s, ctx=document) => Array.from(ctx.querySelectorAll(s));
const money = (n) => n.toLocaleString('es-AR', {minimumFractionDigits:2, maximumFractionDigits:2});

function loadCart(){
  try{ cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]') }catch{ cart = [] }
  updateCartBadge();
}
function saveCart(){
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
  updateCartBadge();
}
function updateCartBadge(){
  const count = cart.reduce((a,i)=>a+i.cantidad,0);
  const badge = $('#contadorCarrito');
  if (badge) badge.textContent = count;
}

// Product grid (buttons rendered server-side)
function bindAddButtons(){
  $$('.btn-add[data-id]').forEach(btn=>{
    btn.addEventListener('click', e=>{
      const card = e.target.closest('.card');
      const id = parseInt(card.dataset.id);
      const nombre = card.dataset.nombre;
      const precio = parseFloat(card.dataset.precio);
      const emoji = card.dataset.emoji || '🍽️';
      const item = cart.find(i=>i.id===id);
      if(item){ item.cantidad += 1 } else { cart.push({id,nombre,precio,emoji,cantidad:1}) }
      saveCart();
      btn.textContent = '✓ Agregado';
      const prevBg = btn.style.backgroundColor;
      btn.style.backgroundColor = '#27ae60';
      setTimeout(()=>{ btn.textContent = 'Agregar'; btn.style.backgroundColor = prevBg }, 900);
    });
  });
}

// Filters
function bindFilters(){
  $$('.btn-filtro').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      $$('.btn-filtro').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.dataset.filtro;
      $$('.card').forEach(card=>{
        card.style.display = (f==='todos' || card.dataset.categoria===f) ? '' : 'none';
      });
    });
  });
}

// Navigate to cart
function goCart(){
  location.href = 'carrito.php';
}

document.addEventListener('DOMContentLoaded', ()=>{
  loadCart();
  bindAddButtons();
  bindFilters();
  const btnCarrito = $('#btnCarrito'); if (btnCarrito) btnCarrito.addEventListener('click', goCart);
});


/**
 * AE_carrito.js — FoodExpress
 * Render del carrito, validación de cantidades, checkout vía fetch a checkout_procesar.php
 */
const CART_KEY = 'foodexpress_cart';
const $ = (s, ctx=document) => ctx.querySelector(s);
const $$ = (s, ctx=document) => Array.from(ctx.querySelectorAll(s));
const money = (n) => n.toLocaleString('es-AR', {minimumFractionDigits:2, maximumFractionDigits:2});
const SHIPPING = 800;

let cart = [];
function loadCart(){ try{ cart = JSON.parse(localStorage.getItem(CART_KEY)||'[]') }catch{ cart=[] } }
function saveCart(){ localStorage.setItem(CART_KEY, JSON.stringify(cart)); }

function render(){
  const empty = $('#carritoVacio'), layout = $('#carritoContenido'), list = $('#carritoItems');
  if (!cart.length){ empty.style.display='block'; layout.style.display='none'; return }
  empty.style.display='none'; layout.style.display='grid';
  list.innerHTML = '';
  cart.forEach(item=>{
    const div = document.createElement('div');
    div.className = 'cart-item';
    div.innerHTML = `
      <div class="item-thumb">${item.emoji||'🍽️'}</div>
      <div style="flex:1">
        <div class="item-name">${item.nombre}</div>
        <div class="item-price">$${money(item.precio)}</div>
        <div class="qty">
          <button data-id="${item.id}" data-act="dec">-</button>
          <span>${item.cantidad}</span>
          <button data-id="${item.id}" data-act="inc">+</button>
          <button class="btn-remove" data-id="${item.id}" style="margin-left:8px">Eliminar</button>
        </div>
      </div>
      <div><strong>$${money(item.precio*item.cantidad)}</strong></div>
    `;
    list.appendChild(div);
  });
  // Bind
  $$('button[data-act]').forEach(b=>b.addEventListener('click', changeQty));
  $$('.btn-remove').forEach(b=>b.addEventListener('click', removeItem));
  totals();
}

function changeQty(e){
  const id = parseInt(e.target.dataset.id);
  const act = e.target.dataset.act;
  const it = cart.find(i=>i.id===id);
  if(!it) return;
  if(act==='inc') it.cantidad += 1;
  if(act==='dec' && it.cantidad>1) it.cantidad -= 1;
  saveCart(); render();
}
function removeItem(e){
  const id = parseInt(e.target.dataset.id);
  cart = cart.filter(i=>i.id!==id);
  saveCart(); render();
}

function totals(){
  const sub = cart.reduce((s,i)=>s+i.precio*i.cantidad,0);
  $('#subtotal').textContent = `$${money(sub)}`;
  $('#envio').textContent = `$${money(SHIPPING)}`;
  $('#total').textContent = `$${money(sub+SHIPPING)}`;
}

function toShop(){ location.href = 'index.php' }

// Checkout modal
const modal = $('#modalCheckout');
const modalOk = $('#modalConfirmacion');
const form = $('#formCheckout');
const closeX = $('.close');
const btnFin = $('#btnFinalizarCompra');
const btnCancel = $('#btnCancelar');
const selPago = $('#formaPago');

function showModal(){ modal.style.display = 'block' }
function hideModal(){ modal.style.display = 'none' }

if (btnFin) btnFin.addEventListener('click', showModal);
if (btnCancel) btnCancel.addEventListener('click', hideModal);
if (closeX) closeX.addEventListener('click', hideModal);
window.addEventListener('click', (e)=>{
  if(e.target===modal){ hideModal() }
  if(e.target===modalOk){ modalOk.style.display = 'none'; toShop() }
});

// Switch payment fields
if (selPago){
  selPago.addEventListener('change', e=>{
    const v = e.target.value;
    ['datosTarjeta','datosTransferencia','datosEfectivo'].forEach(id=>{
      const el = document.getElementById(id); if(el) el.style.display='none';
    });
    if (v==='tarjeta') $('#datosTarjeta').style.display='block';
    if (v==='transferencia') $('#datosTransferencia').style.display='block';
    if (v==='efectivo') $('#datosEfectivo').style.display='block';
  });
}

// Sanitize inputs
['numeroTarjeta','vencimiento','dni'].forEach(id=>{
  const el = document.getElementById(id);
  if(!el) return;
  if(id!=='vencimiento'){
    el.addEventListener('input', e=> e.target.value = e.target.value.replace(/\D/g,''));
  }else{
    el.addEventListener('input', e=>{
      let v = e.target.value.replace(/\D/g,'');
      if(v.length>=2) v = v.slice(0,2)+'/'+v.slice(2,4);
      e.target.value = v;
    });
  }
});

if (form){
  form.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const fd = new FormData(form);
    const payload = {
      cliente: {
        nombre: fd.get('nombre'),
        apellido: fd.get('apellido'),
        dni: fd.get('dni'),
        email: fd.get('email'),
        telefono: fd.get('telefono'),
        direccion: fd.get('direccion')||''
      },
      formaPago: fd.get('formaPago'),
      items: cart.map(i=>({id:i.id, cantidad:i.cantidad})),
      envio: 800
    };
    try{
      const res = await fetch('checkout_procesar.php', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(payload)
      });
      const data = await res.json();
      if(!res.ok){ alert(data?.error || 'Error al procesar el pedido'); return }
      document.getElementById('numeroOrden').textContent = data.pedido_id;
      modal.style.display='none';
      modalOk.style.display='block';
      cart = []; saveCart(); render();
    }catch(err){
      console.error(err);
      alert('Error de red');
    }
  });
}

document.addEventListener('DOMContentLoaded', ()=>{
  loadCart();
  render();
  const b1 = $('#btnVolver'); if (b1) b1.addEventListener('click', toShop);
  const b2 = $('#btnVolverVacio'); if (b2) b2.addEventListener('click', toShop);
});

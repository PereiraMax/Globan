// Base de la API PHP. Ajustar según dónde quede publicado el backend
// (por ejemplo, "http://localhost/globan/backend-php/api" en XAMPP/WAMP).
export const API_URL = "http://localhost/globan/api";

async function manejarRespuesta(respuesta) {
  const datos = await respuesta.json().catch(() => null);
  if (!respuesta.ok) {
    throw new Error(datos?.error || `Error ${respuesta.status} en la petición`);
  }
  return datos;
}

// ---- Clientes ----
export function obtenerClientes() {
  return fetch(`${API_URL}/clientes.php`).then(manejarRespuesta);
}
export function crearCliente(cliente) {
  return fetch(`${API_URL}/clientes.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(cliente),
  }).then(manejarRespuesta);
}
export function eliminarCliente(id) {
  return fetch(`${API_URL}/clientes.php?id=${id}`, { method: "DELETE" }).then(manejarRespuesta);
}

// ---- Productos ----
export function obtenerProductos() {
  return fetch(`${API_URL}/productos.php`).then(manejarRespuesta);
}
export function crearProducto(producto) {
  return fetch(`${API_URL}/productos.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(producto),
  }).then(manejarRespuesta);
}
export function eliminarProducto(id) {
  return fetch(`${API_URL}/productos.php?id=${id}`, { method: "DELETE" }).then(manejarRespuesta);
}

// ---- Ventas ----
export function obtenerVentas() {
  return fetch(`${API_URL}/ventas.php`).then(manejarRespuesta);
}
export function crearVenta(venta) {
  return fetch(`${API_URL}/ventas.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(venta),
  }).then(manejarRespuesta);
}

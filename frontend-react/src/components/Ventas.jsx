import { useEffect, useState } from "react";
import { obtenerClientes, obtenerProductos, obtenerVentas, crearVenta } from "../api";

export default function Ventas() {
  const [ventas, setVentas] = useState([]);
  const [clientes, setClientes] = useState([]);
  const [productos, setProductos] = useState([]);
  const [idCliente, setIdCliente] = useState("");
  const [idProducto, setIdProducto] = useState("");
  const [cantidad, setCantidad] = useState(1);
  const [error, setError] = useState("");
  const [cargando, setCargando] = useState(true);

  function cargarTodo() {
    setCargando(true);
    Promise.all([obtenerVentas(), obtenerClientes(), obtenerProductos()])
      .then(([v, c, p]) => {
        setVentas(v);
        setClientes(c);
        setProductos(p);
      })
      .catch((e) => setError(e.message))
      .finally(() => setCargando(false));
  }

  useEffect(() => {
    cargarTodo();
  }, []);

  async function handleSubmit(e) {
    e.preventDefault();
    setError("");
    try {
      await crearVenta({
        idCliente: Number(idCliente),
        idProducto: Number(idProducto),
        cantidad: Number(cantidad),
      });
      setIdCliente("");
      setIdProducto("");
      setCantidad(1);
      cargarTodo();
    } catch (e) {
      setError(e.message);
    }
  }

  return (
    <section>
      <h2>Registrar Venta</h2>

      <form onSubmit={handleSubmit}>
        <fieldset>
          <label>
            Cliente:
            <select value={idCliente} onChange={(e) => setIdCliente(e.target.value)} required>
              <option value="">Seleccioná un cliente</option>
              {clientes.map((c) => (
                <option key={c.id} value={c.id}>
                  {c.nombre}
                </option>
              ))}
            </select>
          </label>
          <label>
            Producto:
            <select value={idProducto} onChange={(e) => setIdProducto(e.target.value)} required>
              <option value="">Seleccioná un producto</option>
              {productos.map((p) => (
                <option key={p.id} value={p.id}>
                  {p.nombre} (${Number(p.valor).toFixed(2)})
                </option>
              ))}
            </select>
          </label>
          <label>
            Cantidad:
            <input
              type="number"
              min="1"
              value={cantidad}
              onChange={(e) => setCantidad(e.target.value)}
              required
            />
          </label>
          <button type="submit">Registrar</button>
        </fieldset>
      </form>

      {error && <p className="error">{error}</p>}

      <h2>Listado de Ventas</h2>

      {cargando ? (
        <p>Cargando...</p>
      ) : (
        <table border="1">
          <thead>
            <tr>
              <th>ID</th>
              <th>Cliente</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            {ventas.map((v) => (
              <tr key={v.id}>
                <td>{v.id}</td>
                <td>{v.clienteNombre}</td>
                <td>{v.productoNombre}</td>
                <td>{v.cantidad}</td>
                <td>${Number(v.total).toFixed(2)}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </section>
  );
}

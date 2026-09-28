import { useEffect, useState } from "react";
import { obtenerProductos, crearProducto, eliminarProducto } from "../api";

export default function Productos() {
  const [productos, setProductos] = useState([]);
  const [nombre, setNombre] = useState("");
  const [valor, setValor] = useState("");
  const [error, setError] = useState("");
  const [cargando, setCargando] = useState(true);

  function cargarProductos() {
    setCargando(true);
    obtenerProductos()
      .then(setProductos)
      .catch((e) => setError(e.message))
      .finally(() => setCargando(false));
  }

  useEffect(() => {
    cargarProductos();
  }, []);

  async function handleSubmit(e) {
    e.preventDefault();
    setError("");
    try {
      await crearProducto({ nombre, valor: Number(valor) });
      setNombre("");
      setValor("");
      cargarProductos();
    } catch (e) {
      setError(e.message);
    }
  }

  async function handleEliminar(id) {
    if (!window.confirm("¿Eliminar este producto?")) return;
    try {
      await eliminarProducto(id);
      cargarProductos();
    } catch (e) {
      setError(e.message);
    }
  }

  return (
    <section>
      <h2>Alta de Producto</h2>

      <form onSubmit={handleSubmit}>
        <fieldset>
          <label>
            Nombre:
            <input type="text" value={nombre} onChange={(e) => setNombre(e.target.value)} required />
          </label>
          <label>
            Valor:
            <input type="number" step="0.01" min="0" value={valor} onChange={(e) => setValor(e.target.value)} required />
          </label>
          <button type="submit">Guardar</button>
        </fieldset>
      </form>

      {error && <p className="error">{error}</p>}

      <h2>Listado de Productos</h2>

      {cargando ? (
        <p>Cargando...</p>
      ) : (
        <table border="1">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Valor</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            {productos.map((p) => (
              <tr key={p.id}>
                <td>{p.id}</td>
                <td>{p.nombre}</td>
                <td>${Number(p.valor).toFixed(2)}</td>
                <td>
                  <button onClick={() => handleEliminar(p.id)}>Eliminar</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </section>
  );
}

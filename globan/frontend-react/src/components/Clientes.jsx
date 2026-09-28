import { useEffect, useState } from "react";
import { obtenerClientes, crearCliente, eliminarCliente } from "../api";

export default function Clientes() {
  const [clientes, setClientes] = useState([]);
  const [nombre, setNombre] = useState("");
  const [telefono, setTelefono] = useState("");
  const [error, setError] = useState("");
  const [cargando, setCargando] = useState(true);

  function cargarClientes() {
    setCargando(true);
    obtenerClientes()
      .then(setClientes)
      .catch((e) => setError(e.message))
      .finally(() => setCargando(false));
  }

  useEffect(() => {
    cargarClientes();
  }, []);

  async function handleSubmit(e) {
    e.preventDefault();
    setError("");
    try {
      await crearCliente({ nombre, telefono });
      setNombre("");
      setTelefono("");
      cargarClientes();
    } catch (e) {
      setError(e.message);
    }
  }

  async function handleEliminar(id) {
    if (!window.confirm("¿Eliminar este cliente?")) return;
    try {
      await eliminarCliente(id);
      cargarClientes();
    } catch (e) {
      setError(e.message);
    }
  }

  return (
    <section>
      <h2>Alta de Cliente</h2>

      <form onSubmit={handleSubmit}>
        <fieldset>
          <label>
            Nombre:
            <input type="text" value={nombre} onChange={(e) => setNombre(e.target.value)} required />
          </label>
          <label>
            Teléfono:
            <input type="text" value={telefono} onChange={(e) => setTelefono(e.target.value)} required />
          </label>
          <button type="submit">Guardar</button>
        </fieldset>
      </form>

      {error && <p className="error">{error}</p>}

      <h2>Listado de Clientes</h2>

      {cargando ? (
        <p>Cargando...</p>
      ) : (
        <table border="1">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Teléfono</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            {clientes.map((c) => (
              <tr key={c.id}>
                <td>{c.id}</td>
                <td>{c.nombre}</td>
                <td>{c.telefono}</td>
                <td>
                  <button onClick={() => handleEliminar(c.id)}>Eliminar</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </section>
  );
}

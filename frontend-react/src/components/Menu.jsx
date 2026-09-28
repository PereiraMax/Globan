import { NavLink } from "react-router-dom";

export default function Menu() {
  return (
    <nav className="menu">
      <NavLink to="/" end>🏠 Inicio</NavLink>
      <NavLink to="/clientes">👤 Clientes</NavLink>
      <NavLink to="/productos">📦 Productos</NavLink>
      <NavLink to="/ventas">🧾 Ventas</NavLink>
    </nav>
  );
}

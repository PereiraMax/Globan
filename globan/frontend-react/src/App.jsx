import { Routes, Route } from "react-router-dom";
import Menu from "./components/Menu.jsx";
import Inicio from "./components/Inicio.jsx";
import Clientes from "./components/Clientes.jsx";
import Productos from "./components/Productos.jsx";
import Ventas from "./components/Ventas.jsx";

export default function App() {
  return (
    <div className="app">
      <Menu />
      <main className="wrap">
        <Routes>
          <Route path="/" element={<Inicio />} />
          <Route path="/clientes" element={<Clientes />} />
          <Route path="/productos" element={<Productos />} />
          <Route path="/ventas" element={<Ventas />} />
        </Routes>
      </main>
    </div>
  );
}

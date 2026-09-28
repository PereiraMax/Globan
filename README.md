# Globan — migración de front a React

## Qué cambió

El proyecto original mezclaba en un mismo archivo PHP la conexión a la base, el
procesamiento del formulario y el HTML de la vista (`clientes.php`). Para poder
modelar el frontend con React, esa mezcla se separó en dos partes:

```
backend-php/
  api/
    conexion.php   -> conexión mysqli compartida + headers CORS/JSON
    clientes.php   -> GET (listado) / POST (alta) / DELETE (baja) en JSON
    productos.php  -> igual, para la tabla Producto
    ventas.php     -> igual, para la tabla Venta (con join a Cliente/Producto)

frontend-react/
  src/
    api.js               -> funciones fetch hacia la API PHP
    App.jsx               -> rutas (reemplaza la navegación multipágina)
    components/
      Menu.jsx            -> reemplaza menu.php
      Inicio.jsx          -> reemplaza index.php
      Clientes.jsx        -> reemplaza la vista de clientes.php
      Productos.jsx       -> nuevo, análogo a Clientes
      Ventas.jsx          -> nuevo, con selects de cliente/producto
```

Cada endpoint de `backend-php/api` ahora **solo devuelve JSON** — ya no genera
HTML. Todo lo visual (formulario, tabla, alta, listado) lo hace React
consumiendo esos endpoints con `fetch`.

También se reemplazó la inserción por concatenación de texto
(`INSERT INTO Cliente VALUES ('$nombre', ...)`, vulnerable a inyección SQL)
por sentencias preparadas (`mysqli::prepare` + `bind_param`) en los tres
endpoints.

## Cómo correrlo

### 1) Base de datos

Importar `globan.sql` (el archivo original, sin cambios) en MySQL.

### 2) Backend PHP

Copiar la carpeta `backend-php/` dentro de tu servidor local (por ejemplo
`htdocs/globan` en XAMPP), de modo que quede accesible en:

```
http://localhost/globan/api/clientes.php
http://localhost/globan/api/productos.php
http://localhost/globan/api/ventas.php
```

Si la URL de tu API queda distinta, ajustá `API_URL` en
`frontend-react/src/api.js`.

### 3) Frontend React

```
cd frontend-react
npm install
npm run dev
```

Por defecto Vite levanta en `http://localhost:5173`. El header
`Access-Control-Allow-Origin: *` en `conexion.php` permite que ese origen
distinto (5173) le pegue a la API sin problemas de CORS durante el
desarrollo; para producción conviene reemplazar el `*` por el dominio real
donde se publique el frontend.

## Qué falta / próximos pasos

- Validaciones más completas en los formularios (por ejemplo, formato de
  teléfono).
- Edición de clientes/productos (hoy solo hay alta y baja).
- Autenticación, si el proyecto lo requiere más adelante.

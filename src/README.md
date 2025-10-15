# Simple Todo App con PHP y SQLite

Una aplicación web simple para gestionar tareas utilizando PHP y SQLite.

## Características

- ✅ Agregar nuevas tareas
- ✅ Marcar tareas como completadas/pendientes
- ✅ Eliminar tareas
- ✅ Estadísticas de progreso
- ✅ Diseño responsive y moderno

## Instalación

1. **Inicializar la base de datos:**
   ```bash
   php init_db.php
   ```

2. **Iniciar el servidor PHP:**
   ```bash
   php -S localhost:8000
   ```

3. **Abrir en navegador:**
   ```
   http://localhost:8000
   ```

## Archivos

- `init_db.php` - Script para inicializar la base de datos SQLite
- `index.php` - Aplicación principal con todas las funcionalidades
- `todos.db` - Base de datos SQLite (se crea automáticamente)

## Estructura de la Base de Datos

La tabla `todos` contiene:
- `id` - Identificador único (auto-incremental)
- `task` - Texto de la tarea
- `completed` - Estado de completado (0/1)
- `created_at` - Fecha de creación

## Uso

1. Escribe una tarea en el campo de texto y presiona "Agregar Tarea"
2. Haz clic en el checkbox o en el texto de la tarea para marcarla como completada
3. Usa el botón "Eliminar" para borrar tareas
4. Revisa las estadísticas al final de la página
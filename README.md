# Simple Todo App con Docker

Una aplicación web simple para gestionar tareas utilizando PHP, SQLite y Docker.

## Descripción

Esta es una aplicación de lista de tareas (todo app) desarrollada en PHP con base de datos SQLite, desplegada usando contenedores Docker para un entorno de desarrollo consistente.

## Características

- ✅ Agregar nuevas tareas
- ✅ Marcar tareas como completadas/pendientes
- ✅ Eliminar tareas
- ✅ Estadísticas de progreso
- ✅ Diseño responsive y moderno
- 🐳 Contenedor Docker para fácil despliegue

## Requisitos

- Docker
- Docker Compose

## Instalación y Ejecución

### Usando Docker (Recomendado)

1. **Clonar o descargar el proyecto:**
   ```bash
   git clone <repository-url>
   cd hola-docker
   ```

2. **Iniciar los contenedores:**
   ```bash
   docker-compose up -d
   ```
   Este comando construirá e iniciará el contenedor con PHP y Apache.

3. **Inicializar la base de datos:**
   ```bash
   docker-compose exec web php init_db.php
   ```

4. **Acceder a la aplicación:**
   Abre tu navegador y visita:
   ```
   http://localhost:8585
   ```

### Ejecución Manual (Sin Docker)

Si prefieres ejecutar la aplicación sin Docker:

1. **Inicializar la base de datos:**
   ```bash
   cd src
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

## Comandos Docker Útiles

- **Ver logs del contenedor:**
  ```bash
  docker-compose logs -f
  ```

- **Detener los contenedores:**
  ```bash
  docker-compose down
  ```

- **Reiniciar los contenedores:**
  ```bash
  docker-compose restart
  ```

- **Acceder al contenedor:**
  ```bash
  docker-compose exec web bash
  ```

## Estructura del Proyecto

```
hola-docker/
├── docker-compose.yml    # Configuración de Docker Compose
├── src/                  # Código fuente de la aplicación
│   ├── index.php        # Aplicación principal
│   ├── init_db.php      # Script de inicialización de BD
│   ├── README.md        # Documentación interna
│   └── todos.db         # Base de datos SQLite (se crea automáticamente)
└── README.md            # Este archivo
```

## Estructura de la Base de Datos

La tabla `todos` contiene:
- `id` - Identificador único (auto-incremental)
- `task` - Texto de la tarea
- `completed` - Estado de completado (0/1)
- `created_at` - Fecha de creación

## Uso de la Aplicación

1. Escribe una tarea en el campo de texto y presiona "Agregar Tarea"
2. Haz clic en el checkbox o en el texto de la tarea para marcarla como completada
3. Usa el botón "Eliminar" para borrar tareas
4. Revisa las estadísticas al final de la página

## Configuración del Contenedor

- **Imagen:** `php:8.3-apache`
- **Puerto:** `8585:80` (Local:Contenedor)
- **Volumen:** `./src:/var/www/html` (Código fuente montado en el contenedor)
- **Nombre del contenedor:** `miapp`

## Troubleshooting

### Problemas Comunes

1. **El puerto 8585 está en uso:**
   - Cambia el puerto en `docker-compose.yml` (línea 6)
   - Ejemplo: `"8080:80"` para usar el puerto 8080

2. **Permisos de archivo:**
   - Asegúrate que los archivos en `src/` tengan los permisos correctos
   - El contenedor necesita poder leer los archivos PHP

3. **La base de datos no se crea:**
   - Ejecuta manualmente: `docker-compose exec web php init_db.php`
   - Verifica que el directorio `src/` sea writable por el contenedor

## Tecnologías Utilizadas

- **PHP 8.3** - Lenguaje de programación del backend
- **Apache** - Servidor web
- **SQLite** - Base de datos ligera
- **Docker** - Contenerización
- **HTML5/CSS3** - Frontend
- **JavaScript** - Interactividad del cliente
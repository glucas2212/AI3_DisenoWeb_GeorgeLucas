# AI3_DisenoWeb_GeorgeLucas

**Mesa de ayuda**: aplicación web para registrar y consultar incidencias de soporte técnico de una institución (equipos, red, impresoras, accesos). Está construida en PHP con el patrón **Modelo-Vista-Controlador** y una base de datos MySQL/MariaDB llamada `db_sistema_web`.

- **Autor:** George Eliezer Lucas Cantos
- **Asignatura:** Programación de Sistemas Web, Universidad Tecnológica ECOTEC
- **Actividad:** Actividad Integradora 3

## Tecnologías

PHP 8.1 o superior con PDO, MySQL 8 o MariaDB 10.4+, HTML5, CSS3 y JavaScript sin librerías.

## Despliegue local (XAMPP)

1. Instale [XAMPP](https://www.apachefriends.org/es/) y, desde su panel de control, inicie **Apache** y **MySQL**.
2. Copie la carpeta del proyecto en `C:\xampp\htdocs\AI3_DisenoWeb_GeorgeLucas`. Si usa Git: `git clone https://github.com/glucas/AI3_DisenoWeb_GeorgeLucas.git` dentro de `htdocs`.
3. Abra `http://localhost/phpmyadmin`, entre en **Importar**, seleccione `sql/db_sistema_web.sql` y pulse **Importar**. Se crean la base, las tablas `areas` e `incidencias` y cinco áreas de ejemplo.
4. En la carpeta `config`, copie `credenciales.ejemplo.php` con el nombre `credenciales.php`. Con XAMPP recién instalado (usuario `root` sin contraseña) no hay que cambiar nada; en otro caso, escriba allí su usuario y contraseña.
5. Abra `http://localhost/AI3_DisenoWeb_GeorgeLucas/`.

> `config/credenciales.php` está en `.gitignore`: las credenciales reales nunca se suben al repositorio.

## Organización (MVC)

| Carpeta / archivo | Rol |
|---|---|
| `index.php` | Controlador frontal: recibe todas las peticiones y llama a la acción correspondiente. |
| `app/Controladores/` | `IncidenciaControlador`: decide qué hacer con cada petición (listar, mostrar el formulario, guardar). |
| `app/Modelos/` | `IncidenciaModelo`: único lugar con SQL; usa sentencias preparadas. |
| `app/Vistas/` | Plantilla HTML, listado, formulario y página de error. |
| `app/Validador.php` | Validación de los datos en el servidor. |
| `app/ayudantes.php` | `h()` (escape con `htmlspecialchars`), token CSRF y carga de vistas. |
| `config/conexion.php` | Conexión PDO con manejo de errores `try-catch`. |
| `sql/db_sistema_web.sql` | Script DDL de la base de datos. |
| `docs/` | Informe técnico en PDF. |

## Seguridad aplicada

- **Inyección SQL:** todas las consultas usan `prepare()` y `execute()` con parámetros con nombre; la emulación de sentencias preparadas está desactivada.
- **XSS:** todo dato mostrado pasa por `h()`, que usa `htmlspecialchars` con `ENT_QUOTES`. Además, una cabecera Content-Security-Policy solo permite scripts del propio sitio.
- **Errores:** la conexión está en un `try-catch`; el detalle técnico va al log de PHP y el usuario solo ve un mensaje general.
- **Validación:** HTML5 y JavaScript en el navegador, y validación completa en el servidor con listas blancas para área, tipo y prioridad.
- **Otros:** token CSRF, redirección 303 después de guardar y archivos `.htaccess` que impiden abrir `config/`, `app/` y `sql/` desde el navegador.

## Uso de IA

En el desarrollo de este proyecto se utilizó Claude (Anthropic) como asistente para el código, las pruebas y la documentación.

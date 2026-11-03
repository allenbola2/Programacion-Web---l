# Workshop 4 - Patrón MVC

Adaptación del Workshop 3. El módulo **CRUD de cursos** está separado en:

- `models/Course.php`: consultas y escrituras PDO de cursos.
- `controllers/CourseController.php`: validación, acciones HTTP y selección de vistas.
- `views/courses/`: listado y formulario HTML.
- `pages/course*.php` y `actions/course*.php`: rutas de entrada delgadas que llaman al controlador; se conservan las URL originales.

**Nota de alcance:** login, registro, perfil y listado de usuarios conservan su estructura anterior; la refactorización MVC se realizó en el módulo CRUD de cursos. Si se exige MVC para absolutamente todos los módulos, estos todavía deben migrarse.

## Instalación

1. Copiar esta carpeta como `C:\xampp\htdocs\Programacion-Web-I\Workshop 4`.
2. Iniciar Apache y MySQL en XAMPP. El proyecto conserva `workshop3`, puerto `3307`, usuario `root` sin contraseña en `utils/database.php`.
3. Si ya funciona la base `workshop3` del Workshop 3, no volver a importarla. De lo contrario, crearla e importar los esquemas SQL incluidos según sus dependencias.
4. Abrir `http://localhost/Programacion-Web-I/Workshop%204/`, iniciar sesión y probar el CRUD de cursos.
5. Revisar que los enlaces de las páginas funcionen. La ruta base se configura en `utils/config.php`.

## Flujo MVC

`pages/courses.php` → `CourseController::index()` → `Course::all()` → `views/courses/index.php`.

Al crear un curso: formulario → `actions/course_create.php` → `CourseController::store()` → `Course::create()` → redirección al listado.

## Pruebas sugeridas

- Iniciar sesión y abrir Cursos.
- Crear un curso y comprobarlo en el listado.
- Editar ese curso y comprobar el cambio.
- Eliminarlo y verificar que desaparezca.
- Probar una solicitud POST sin CSRF: debe rechazarse.

No se ha ejecutado una prueba de navegador contra tu servidor XAMPP desde este entorno.

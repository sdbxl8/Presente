# Contexto del proyecto Presente

## Objetivo actual

El sistema es una demo Laravel para gestionar clases, asistencia por QR y justificantes. La prioridad actual es modelar la relación docente-asignatura-grupo de forma sencilla:

- Cada profesor tiene una asignatura (`users.subject_name`).
- Al crear un grupo, se crea automáticamente una asignatura para ese grupo usando el nombre de la asignatura del profesor.
- Las clases siguen vinculándose a `subjects`, y cada asignatura sigue perteneciendo a un grupo mediante `subjects.group_id`.
- El profesor ya no debe crear ni asignar asignaturas manualmente desde la pantalla de grupos.

Se decidió conservar el esquema existente y crear un registro `Subject` por grupo. Si el profesor imparte Programación, los grupos que cree tendrán su propia fila de asignatura llamada Programación. No se comparte el mismo registro entre grupos.

## Cambios aplicados y verificados

- `database/migrations/0001_01_01_000000_create_users_table.php` incluye `subject_name` nullable.
- `app/Models/User.php` incluye `subject_name` entre sus atributos `Fillable`.
- `resources/views/register-login/register.blade.php` muestra un campo de texto para la asignatura del profesor.
- `app/Http/Controllers/RegisterController.php` exige `subject_name` cuando `role` es `teacher`, lo excluye para otros roles y guarda el valor en el usuario.
- `database/seeders/DatabaseSeeder.php` crea al profesor Mario con `subject_name = Programación`, su grupo de ejemplo y un `Subject` del grupo usando ese valor. También crea a Juan como alumno.
- `app/Http/Controllers/GroupController.php::store()` valida el nombre del grupo, comprueba que el profesor tenga asignatura y crea el grupo y su `Subject` dentro de una transacción.
- `GroupController::addStudents()` comprueba que el grupo pertenece al profesor antes de añadir alumnos.
- En `GroupController` ya no están los métodos antiguos `storeSubject()` y `addSubjects()` ni su importación de `Subject`.
- `routes/web.php` ya no contiene la ruta POST para crear/asignar asignaturas al grupo.
- `resources/views/teacher/teacher-group.blade.php` ya no contiene el botón ni el modal “Añadir asignatura”; conserva la lista para mostrar las asignaturas ya asociadas al grupo.
- La página de grupos conserva el modal para añadir alumnos.
- `ClassController::store()` comprueba que el grupo pertenece al profesor y que la asignatura pertenece al grupo elegido. Así se evita enviar un `subject_id` de otro grupo.

## Estado Git observado

- Rama actual: `develop`.
- Seguimiento remoto observado: `origin/develop`.
- `git push -u origin develop` se había completado anteriormente.
- En la última comprobación había cambios locales sin commit en:
  - `app/Http/Controllers/GroupController.php`
  - `app/Http/Controllers/RegisterController.php`
  - `app/Models/User.php`
  - `database/migrations/0001_01_01_000000_create_users_table.php`
  - `database/seeders/DatabaseSeeder.php`
  - `resources/views/register-login/register.blade.php`
  - `resources/views/teacher/teacher-group.blade.php`
  - `routes/web.php`

Volver a ejecutar `git status` antes de continuar: el estado puede haber cambiado después de crear este documento. Los cambios actuales no se deben descartar.

## Bloqueo inmediato: migración duplicada de `sessions`

La última ejecución de `php artisan migrate:fresh --seed` terminó con error `SQLSTATE[42S01]`, indicando que la tabla `sessions` ya existe.

Causa confirmada: se intenta crear la tabla con nombre `sessions` en dos migraciones distintas:

1. `database/migrations/0001_01_01_000000_create_users_table.php`
2. `database/migrations/2026_08_31_162150_create_sessions_table.php`

No son las sesiones de clase (`class_sessions`). La tabla `sessions` es para las sesiones de autenticación web de Laravel; `class_sessions` guarda las clases planificadas y no debe modificarse por este error.

### Próxima acción

1. En `0001_01_01_000000_create_users_table.php`, quitar de `up()` el bloque `Schema::create('sessions', ...)`.
2. En el `down()` de esa migración, quitar `Schema::dropIfExists('sessions')` para que la tabla sea responsabilidad de su migración dedicada.
3. Conservar `2026_08_31_162150_create_sessions_table.php` sin cambios.
4. Como los datos de esta demo son falsos y se acordó empezar desde cero, volver a ejecutar `php artisan migrate:fresh --seed`. Este comando borra todas las tablas/datos antes de recrearlos.
5. Si vuelve a fallar, guardar el primer error completo y diagnosticarlo antes de repetir el comando.

La última ejecución fallida pudo haber dejado algunas tablas creadas parcialmente. Una nueva ejecución de `migrate:fresh` vuelve a eliminarlas y empieza otra vez.

## Validación funcional inmediata

Después de que `migrate:fresh --seed` termine correctamente:

1. Comprobar que existe el profesor de prueba (`profesor@test.com`, contraseña `12345678`) con asignatura Programación.
2. Entrar como profesor y crear un grupo; revisar que aparece Programación sin pedir crear una asignatura.
3. Abrir la planificación de clase y comprobar que el selector de asignatura muestra Programación para ese grupo.
4. Registrar un profesor nuevo con asignatura y un alumno sin asignatura; comprobar validación/guardado para ambos roles.
5. Ejecutar las pruebas disponibles (`php artisan test`) y la compilación frontend (`npm run build`) después de corregir migraciones.

## Trabajo anterior relevante

- Aplicación Laravel con Blade, Tailwind y Vite.
- Se incorporaron FullCalendar en vista mensual y generación de QR con `qrcode`.
- Las rutas de grupos/clases/dashboard y justificantes de profesor usan `auth` y `role:teacher`.
- Las rutas de asistencia están bajo `auth`, `role:student` y `signed`.
- `AttendanceController` valida que el alumno tenga rol student, que la clase esté abierta y que pertenezca al grupo de la clase. Registra `present` o `late`; `show()` sigue devolviendo actualmente una respuesta de texto de prueba.
- `ClassController::open()` genera enlace QR firmado; `close()` crea asistencias ausentes con `firstOrCreate()`, preservando las existentes.
- El flujo de justificación tiene estado `pending` por defecto, `approved` al aceptar y `rejected` al rechazar. Aprobar marca la asistencia `excused`; rechazar conserva el estado de asistencia. No hay todavía interfaz/ruta de envío de justificantes del alumno.
- Se añadió un middleware de rol `EnsureUserHasRole` y alias `role` en `bootstrap/app.php`.
- La selección de rol en el registro permanece abierta para la demo, por decisión explícita.

## Pendientes de alcance posterior

- Añadir confirmación manual de asistencia por el profesor cuando un alumno no pueda usar el QR. Debe validar propiedad de clase/grupo y actualizar la asistencia existente sin crear duplicados (`attendances` tiene unicidad por `class_session_id` + `user_id`).
- Implementar la interfaz del alumno. El inicio compartido todavía requiere navegación/redirect según rol; revisar `LoginController` y el menú del layout antes de habilitarla.
- Implementar envío de justificante por el alumno. La pantalla actual de justificantes es docente; comprobar pertenencia de `attendance.user_id` en servidor y crear estado `pending`.
- Filtrar `/api/classes`: actualmente se observó que devuelve clases sin filtrar por usuario; para compartir calendario entre docente y alumno hay que devolver solo las clases del profesor o grupo correspondiente.
- Mejorar el resumen de justificantes: controlador docente actualmente obtiene solicitudes de todos los estados, mientras que la vista las representa como pendientes. Decidir si se filtra solo `pending` o se muestran estados reales.
- Repetir una revisión de propiedad/rol en endpoints sensibles antes de considerar finalizada la autorización.

## Instrucción del repositorio

`AGENTS.md` exige verificar PHP/Composer y configurar Laravel Boost antes de que un agente realice cambios de aplicación. Boost no se encontró instalado cuando se comprobó; su instalación modifica dependencias e instrucciones. El usuario decidió continuar guiándose y aplicar los cambios por su cuenta, así que no se instaló.

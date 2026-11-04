# Contexto del proyecto Presente

## Objetivo actual

El sistema es una demo Laravel para gestionar clases, asistencia por QR y justificantes. La prioridad actual es modelar la relación docente-asignatura-grupo de forma sencilla:

- Cada profesor tiene una asignatura (`users.subject_name`).
- Al crear un grupo, se crea automáticamente una asignatura para ese grupo usando el nombre de la asignatura del profesor.
- Las clases siguen vinculándose a `subjects`, y cada asignatura sigue perteneciendo a un grupo mediante `subjects.group_id`.
- El profesor ya no debe crear ni asignar asignaturas manualmente desde la pantalla de grupos.

Se decidió conservar el esquema existente y crear un registro `Subject` por grupo. Si el profesor imparte Programación, los grupos que cree tendrán su propia fila de asignatura llamada Programación. No se comparte el mismo registro entre grupos.

## Forma de trabajar acordada

- El usuario prefiere avanzar guiado y por pasos, con explicaciones de qué archivo tocar, qué bloque cambiar y por qué.
- No editar archivos salvo que el usuario lo pida explícitamente. Cuando autoriza cambios, respetar el alcance concreto y no ampliar a refactors no solicitados.
- Mantener soluciones simples, apropiadas para una demo de portfolio, pero con comprobaciones esenciales de autorización y validación.
- No instalar Laravel Boost: el usuario lo rechazó explícitamente y pidió continuar sin Boost.
- Antes de sugerir comandos que borran datos, avisar de su efecto. Para la base de datos de demo el usuario confirmó que puede empezar desde cero porque los datos son falsos.
- Responder en español y validar el archivo/comportamiento afectado cuando se hagan cambios.
- `npm run dev` solo inicia Vite; las rutas Laravel se prueban mediante el servidor de Laravel/Laragon.

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
- El seeder asigna Programación a Mario y crea esa asignatura para el grupo de ejemplo.
- `StudentDashboardController` y `resources/views/student/student-dashboard.blade.php` existen como inicio inicial del alumno.
- `/student/home` existe con `auth` y `role:student`; `/home` sigue siendo el inicio de profesor con `role:teacher`.
- La ruta raíz y `LoginController` redirigen al inicio adecuado según el rol.
- El layout compartido muestra el menú de profesor o alumno según el rol. El menú alumno conserva Inicio y muestra Escanear, Mis clases y Justificaciones como opciones deshabilitadas hasta que se implementen esas secciones.
- El parcial `layouts/profile-menu` ofrece Mi perfil y Cerrar sesión. Logout usa POST, CSRF e invalida la sesión.
- `ProfileController` permite leer y actualizar el perfil; la asignatura es editable para profesores y se replica a los `subjects` de sus grupos. La asignatura de un alumno se muestra desde su grupo y no se edita en el perfil.
- El perfil permite subir una foto local mediante `profile.photo.update`; `User` incluye `photo` en `Fillable`, la foto se guarda en el disco `public` y `php artisan storage:link` se ejecutó correctamente.
- El layout muestra la foto del usuario en los avatares de escritorio y móvil, con la letra `P` como fallback.

## Estado Git observado

- La última rama observada anteriormente fue `develop`, con upstream `origin/develop`; `git push` se había completado.
- Después se ejecutó `git init`; no hay una comprobación posterior fiable del estado actual ni de la rama.
- Antes de continuar, ejecutar `git status --short --branch` y conservar los cambios de usuario. No resetear ni descartar archivos.

## Base de datos y migraciones

Inicialmente `php artisan migrate:fresh --seed` falló porque la tabla `sessions` se creaba en dos migraciones: la inicial de usuarios y `2026_08_31_162150_create_sessions_table.php`. No son las sesiones de clase (`class_sessions`).

El usuario comentó los bloques de creación de `sessions` y `password_reset_tokens` en `0001_01_01_000000_create_users_table.php`, conservando la migración dedicada de `sessions`. Después `php artisan migrate:fresh --seed` terminó con código 0.

Consecuencias:

- `sessions` la crea `2026_08_31_162150_create_sessions_table.php` y debe mantenerse para el driver de sesiones de Laravel.
- `class_sessions` guarda clases planificadas y no se modificó por este error.
- `password_reset_tokens` no se crea actualmente desde la migración base. No bloquea el flujo actual, pero se necesitará una migración si se implementa recuperación de contraseña.
- El seed de la base de datos se ejecutó correctamente tras resolver el duplicado.

La base contiene datos falsos; el usuario confirmó que acepta reconstruirla con `migrate:fresh --seed` si es necesario. Recordar que este comando borra todas las tablas/datos.

## Validación pendiente

La última secuencia no confirmó todas las rutas/compilaciones end-to-end. Validar cuando sea conveniente:

- Iniciar como Mario (`profesor@test.com`, `12345678`), comprobar Programación en el grupo sembrado y crear un segundo grupo.
- Probar registro teacher/student y la asignatura condicional.
- Abrir `/student/home` con cuenta student; confirmar menú propio y que no hay 403.
- Probar `/profile`: editar campos, cambiar asignatura de profesor, subir foto y comprobar avatar en desktop/móvil.
- Probar logout POST y verificar que termina la sesión.
- Ejecutar `php artisan route:list`, `php artisan view:cache`, `php artisan test` y `npm run build` si el usuario lo solicita o cuando se cierre una fase.
- En pasos recientes, `get_errors` encontró archivos Blade sin errores, pero `php artisan view:cache` fue omitido en una solicitud anterior.

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
- El perfil compartido se implementa en `resources/views/layouts/profile.blade.php` y las rutas comunes están bajo `auth` sin middleware de rol.
- El layout base se comparte; el menú docente/alumno se elige por `auth()->user()->role`.

## Plan siguiente: alumno y pulido

Las prioridades compartidas por el usuario para continuar son:

### Fase 10 — Alumno: unirse al grupo

- Crear pantalla para introducir código/enlace de grupo.
- Validar el código y asociar el `group_id` al alumno autenticado.
- Mostrar el grupo al que pertenece y rechazar códigos/grupos no válidos.

### Fase 11 — Alumno: clases

- Mostrar sus asignaturas y clases, calendario compartido y detalle de clase.
- Consultar asistencia: presente, ausente o justificada.
- Mantener al alumno en modo solo lectura: no crear, editar ni eliminar clases.

### Fase 12 — Alumno: escanear QR

- Crear pantalla Escanear con acceso a cámara y una librería lectora QR.
- Leer URL firmada, registrar asistencia y mostrar éxito/error.
- Evitar registros duplicados; `attendances` tiene unique por `class_session_id` + `user_id`.

### Fase 13 — Alumno: histórico

- Historial con presentes, tardanzas, ausencias y justificadas.
- Mostrar porcentaje total y resumen visual bajo “Mi asistencia”.

### Fase 14 — Alumno: justificantes

- Mostrar ausencias y formulario de justificación con motivo y documento opcional.
- Validar archivo, guardar `pending` y permitir consultar posteriormente su estado.
- Verificar en servidor que la asistencia pertenece al alumno autenticado.

### Fase 15 — Diseño y pulido

Empezar solo cuando funcionen las fases anteriores: colores, tipografías, iconos, bordes/sombras, hover/focus, empty states, errores/éxitos/loading, breakpoints móvil/tablet/desktop y revisión de modales/navegación.

## Instrucción del repositorio

`AGENTS.md` pide Laravel Boost antes de cambios de aplicación. El usuario ha pedido expresamente trabajar sin Boost; no instalarlo ni modificar dependencias sin nueva autorización.

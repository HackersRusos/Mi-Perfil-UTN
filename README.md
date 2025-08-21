# Mi-Perfil-UTN
Sistema de gestión de perfiles académicos desarrollado en Laravel + Livewire + Volt. Permite registro y visualización de datos de estudiantes, con roles de usuario y administrador, carga de foto, enlaces a redes y acceso directo a WhatsApp.

# Plan de Features — Mi Perfil UTN (MVP)

Este documento define alcance, criterios de aceptación, tareas técnicas, rutas, seguridad y tests de cada feature del MVP.
Convención de ramas: feature/<nombre> → PR a develop.

# 1) Auth (login / registro / logout / verificación / reset)

Rama: feature/auth

Objetivo

Permitir a usuarios registrarse, iniciar/cerrar sesión y recuperar contraseña. Forzar email verificado para zonas protegidas.

Alcance

Instalar/confirmar Breeze + Livewire + Volt.

Formularios: /login, /register, /forgot-password, /reset-password.

Verificación de email (middleware verified).

Config de mailer (.env) o MAIL_MAILER=log en dev.

Criterios de aceptación

Usuario puede registrarse y logearse.

Usuario no verificado no accede a rutas con verified.

Reset de contraseña envía enlace (o aparece en logs).

Logout funcional.

Rutas

Públicas: /login, /register, /forgot-password, /reset-password/*.

Protegidas: /dashboard (placeholder) con auth + verified.

Seguridad

Throttle de login (Breeze).

Validaciones servidor: email válido, password min 6/8 (configurable).

Tests (mínimos)

Invitado redirige de /dashboard a /login.

Login correcto redirige a /dashboard.

Reset de contraseña genera token (assert en log o DB).

# 2) Roles y autorización (admin/user)

Rama: feature/roles-permissions

Objetivo

Diferenciar admin y user; restringir vistas y acciones según rol.

Alcance

Columna role en users (enum: user|admin, default user).

Método User::isAdmin().

Middleware admin para rutas admin.

Policies para Profile (view/update/viewAny/delete).

Criterios de aceptación

Usuario común ve/edita solo su perfil.

Admin ve todos los perfiles y accede a rutas admin.

Rutas admin devuelven 403 a no-admin.

Rutas

/admin/* bajo middleware admin.

Seguridad

Policies invocadas desde componentes/páginas Volt usando $this->authorize(...).

Tests

user no accede a /admin/* (403).

admin accede con éxito.

# 3) Modelo Profile + migraciones

Rama: feature/profile-model

Objetivo

Definir entidad Profile (1–1 con User) con campos requeridos.

Alcance

Tabla profiles:

user_id (FK, cascade delete)

apellido (string, req)

nombre (string, req)

comision (nullable)

telefono (req)

carrera (nullable)

dni (string, unique, req)

foto_path (nullable)

social_links (json, nullable: {instagram, facebook, linkedin, web})

Relación User hasOne Profile.

Cast social_links a array.

Helper whatsappUrl() (normaliza a wa.me/+54...).

Criterios de aceptación

Migraciones corren limpio.

dni es único.

storage:link creado para imágenes.

Seguridad

Nada público: creación/lectura solo autenticado y por policy.

Tests

Se crea Profile con dni único.

Relación user->profile funciona.

# 4) Mi Perfil (CRUD propio con Volt)

Rama: feature/profile-self-crud

Objetivo

Que cada usuario pueda crear/editar/ver su propio perfil.

Alcance

Página Volt: /mi-perfil

Form con validaciones:

apellido, nombre, telefono, dni (unique:ignore).

foto (imagen, max ~2MB).

social_links (urls válidas).

Botón “Abrir WhatsApp” (usa whatsappUrl()).

Criterios de aceptación

Usuario sin perfil puede crearlo; con perfil puede editarlo.

Upload y preview de foto.

Link WhatsApp abre correctamente.

Rutas

/mi-perfil bajo auth + verified.

Seguridad

Policy@update para evitar editar otros perfiles.

Tests

Guardado exitoso del propio perfil.

Validación de dni único al editar (ignora su propio id).

# 5) Listado Admin (búsqueda + paginación)

Rama: feature/admin-profiles-list

Objetivo

Como admin, listar todos los perfiles con búsqueda y paginación.

Alcance

Página Volt: /admin/perfiles

Grid con: foto, apellido/nombre, DNI, comisión.

Filtros: búsqueda por apellido|nombre|dni|comision|carrera.

Paginación (12/24 por página).

Links rápidos: WhatsApp y redes si existen.

Criterios de aceptación

Solo admin accede.

Búsqueda parcial funciona.

Paginación estable.

Rutas

/admin/perfiles bajo admin.

Seguridad

Policy@viewAny y middleware admin.

Tests

Admin ve listado; user 403.

Búsqueda devuelve resultados esperados.
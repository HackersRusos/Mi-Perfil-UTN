# 📖 Mi Perfil UTN – Sistema de Gestión de Perfiles Estudiantiles

![UTN Logo](public/images/UTN_FRRE.png)

Aplicación web desarrollada en **Laravel 12 + Livewire** para la gestión de perfiles estudiantiles de la **UTN – Facultad Regional Resistencia**.  
Incluye módulos de autenticación, recuperación de contraseña, control de roles (Administrador, Profesor, Estudiante) y paneles personalizados.

---

## 👥 Integrantes

- **Ginés Gustavo**  
- **Heretichi Gabriela**  
- **Quintana Javier**  
- **Nacimento Leandro**

---

# 🚀 Guía de instalación (para desarrolladores/correctores)

## 1. Clonar el repositorio
git clone https://github.com/HackersRusos/Mi-Perfil-UTN.git
cd Mi-Perfil-UTN

## 2. Instalar dependencias PHP
composer install

## 3. Instalar dependencias JS
npm install && npm run build

## 4. Configurar entorno
Copiar el archivo .env.example a .env y configurar:

.env
APP_NAME="Mi Perfil UTN"
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=MiPerfilUTN
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=miperfilutn@gmail.com
MAIL_PASSWORD=contraseña_app
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="miperfilutn@gmail.com"
MAIL_FROM_NAME="Mi Perfil UTN"

## 5. Generar APP_KEY
php artisan key:generate

## 6. Migraciones y seeders
php artisan migrate --seed
Esto crea las tablas y un usuario administrador inicial.

## 7. Levantar servidor
php artisan serve
Abrir en 👉 http://localhost:8000

🔑 Acceso inicial (Admin)
Email: admin@gmail.com

Contraseña: admin123

# 📖 Guía de uso (Manual para usuarios)

## 🎯 Introducción

Mi Perfil UTN permite que estudiantes, profesores y administradores gestionen sus perfiles de manera segura.

## 👥 Roles en el sistema

### 🔑 Administrador

Accede al panel de administración.

Crea, edita y elimina usuarios.

Asigna roles (administrador, profesor, estudiante).

Supervisa el sistema completo.

### 👨‍🏫 Profesor

Consulta perfiles de estudiantes.

Visualiza datos de contacto y académicos.

Solo accede a estudiantes que le corresponden.

### 🎓 Estudiante

Accede a su perfil personal.

Puede actualizar datos básicos (teléfono, redes sociales, foto).

Recibe notificaciones institucionales.

## 🚀 Ingreso al sistema

Abrir el navegador en:
👉 http://localhost:8000

## Seleccionar:

Iniciar Sesión si ya tenés cuenta.

Registrarse si es la primera vez.

Usar siempre tu correo institucional:

css
usuario@frre.utn.edu.ar

## 🔑 Recuperar contraseña

En la pantalla de login, hacer clic en “¿Olvidaste tu contraseña?”

Ingresar el correo institucional.

Se enviará un mail con un botón “Restablecer contraseña”.

Elegir la nueva clave e iniciar sesión normalmente.

## 🖥️ Panel de control

Administrador: dashboard, gestión de usuarios, asignación de roles.

Profesor: listado de estudiantes asignados, consulta de perfiles.

Estudiante: actualización de datos personales, notificaciones.

## 🔐 Seguridad
Máximo 3 intentos fallidos de login antes del bloqueo temporal.

Autenticación obligatoria con correo institucional.

Sesiones seguras y regeneradas al inicio de sesión.

## 📩 Soporte
Ante cualquier problema contactar a:
📧 miperfilutn@gmail.com


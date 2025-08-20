<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil UTN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-bg { background-color: #f8f9fa; }
        .card-icon { font-size: 48px; margin-bottom: 20px; }
        .btn-primary { background-color: #0d6efd; border-color: #0d6efd; }
        .footer-bg { background-color: #042947; color: white; padding: 30px; }
    </style>
</head>
<body class="custom-bg">
    <!-- Encabezado -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/UTN_FRRE.png" alt="UTN FRRe Logo" class="img-fluid">
                <p>Extension Formosa</p>
            </a>
            <div class="ml-auto">
                <a href="#" class="btn btn-outline-primary me-2">Iniciar Sesión</a>
                <a href="#" class="btn btn-primary">Registrarse</a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container py-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 text-center">
                <h1>Mi Perfil UTN</h1>
                <p class="fs-5 text-muted mb-4">Sistema de gestión de perfiles estudiantiles</p>
                <p class="text-center fs-6 mb-5">Plataforma integral para estudiantes, profesores y administradores de la Universidad Tecnológica Nacional - Facultad Regional Resistencia - Extensión Formosa</p>
                
                <!-- Imagen Principal -->
                <div class="mb-5">
                    <img src="images/IPP--696x464.jpg" class="img-fluid rounded shadow-sm" alt="Edificio UTN">
                </div>

                <!-- Tarjetas de Funcionalidades -->
                <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                            <img src="{{ asset('images/student-cap.svg') }}" alt="Student Cap" 
                                class="img-fluid mx-auto d-block " style="max-width: 35px;">
                                <h5>Estudiantes</h5>
                                <p>Gestiona tu perfil académico, información personal y datos de contacto</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                            <img src="{{ asset('images/profesors.svg') }}" alt="Student Cap" 
                                class="img-fluid mx-auto d-block " style="max-width: 35px;">
                                <h5>Profesores</h5>
                                <p>Accede al listado completo de estudiantes por comisión y carrera</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                            <img src="{{ asset('images/admin.svg') }}" alt="Student Cap" 
                                class="img-fluid mx-auto d-block " style="max-width: 35px;">
                                <h5>Administradores</h5>
                                <p>Control total de permisos y gestión de usuarios del sistema</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de Acción -->
                <div class="mt-5 text-center">
                    <a href="#" class="btn btn-primary px-5">Comenzar Ahora</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Pie de Página -->
    <footer class="footer-bg">
        <div class="container py-4 text-white">
            <div class="row">
                <div class="col text-center">
                    <h5>UTN - Facultad Regional Resistencia - Extensión Formosa</h5>
                    <p class="mb-2">Proyecto Académico - Sistema de Gestión de Perfiles Estudiantiles</p>
                    <hr class="w-25 mx-auto mb-3 bg-white">
                    <p>© 2025 Universidad Tecnológica Nacional. Todos los derechos reservados.</p>
                    <p class="small">Desarrollado con fines educativos - Mi Perfil UTN v1.0.0</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
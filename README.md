# TPG01 – Repositorios y Buenas Prácticas con GitLab – Gustavo Gines

## Enlace al repositorio
[<https://gitlab.com/gustavogines-group/tpg01-repositorios-buenas-practicas.git>]

## Alumno
- Gustavo Gines

## Descripción
Integración del proyecto **Mi-Perfil-UTN** a GitLab aplicando GitFlow,
convencional commits, Merge Requests y manejo de `git stash`.

## Esquema de ramas
- `main`: estable
- `develop`: integración
- `feature/*`: nuevas funcionalidades
- `fix/*`: correcciones
- `release/*`: preparación de versión
- `hotfix/*`: fixes urgentes sobre main

## Ejemplo de commits
- `feat(auth): agrega flujo de login (Closes #2)`
- `fix(auth): corrige validación de contraseña mínima (Closes #1)`

## Uso de git stash
```bash
git stash push -m "WIP verify-email"
git checkout develop && git pull
git checkout feature/auth-verify-email
git stash pop

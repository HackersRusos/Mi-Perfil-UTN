<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedRoles();
});

it('profesor ve "Estudiantes" en la sidebar y no tiene enlaces de admin ni estudiante', function () {
    $prof = userWithRole(2);

    $this->actingAs($prof)
        ->get(route('profesor.dashboard'))
        ->assertOk()
        ->assertSee('Estudiantes')
        // no deben existir los links de otros dashboards en la sidebar
        ->assertDontSee(route('admin.dashboard'))
        ->assertDontSee(route('dashboard'));
});

it('estudiante ve "Mi Perfil" en la sidebar y no tiene enlaces de profesor ni admin', function () {
    $estu = userWithRole(1);

    $this->actingAs($estu)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Mi Perfil')
        ->assertDontSee(route('profesor.dashboard'))
        ->assertDontSee(route('admin.dashboard'));
});

it('admin ve "Gestión de Usuarios" en la sidebar y no tiene enlaces de profesor ni estudiante', function () {
    $admin = userWithRole(3);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Gestión de Usuarios')
        // chequear URLs (sidebar), no palabras (contenido)
        ->assertDontSee(route('profesor.dashboard'))
        ->assertDontSee(route('dashboard'));
});

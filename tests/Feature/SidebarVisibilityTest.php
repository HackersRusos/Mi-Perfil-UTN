<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedRoles();
});

it('profesor ve "Estudiantes" y no ve "Mi Perfil" ni "Gestión de Usuarios"', function () {
    $prof = userWithRole(2);

    $this->actingAs($prof)
        ->get(route('profesor.dashboard'))
        ->assertOk()
        ->assertSee('Estudiantes')
        ->assertDontSee('Mi Perfil')
        ->assertDontSee('Gestión de Usuarios');
});

it('estudiante ve "Mi Perfil" y no ve "Estudiantes" ni "Gestión de Usuarios"', function () {
    $estu = userWithRole(1);

    $this->actingAs($estu)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Mi Perfil')
        ->assertDontSee('Estudiantes')
        ->assertDontSee('Gestión de Usuarios');
});

it('admin ve "Gestión de Usuarios" y no ve "Estudiantes" ni "Mi Perfil"', function () {
    $admin = userWithRole(3);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Gestión de Usuarios')
        ->assertDontSee('Estudiantes')
        ->assertDontSee('Mi Perfil');
});

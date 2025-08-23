<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(fn() => seedRoles());

it('si ya está logueado como profesor y entra a /login, redirige a /profesor', function () {
    $u = userWithRole(2); // profesor
    $this->actingAs($u)->get(route('login'))
        ->assertRedirect(route('profesor.dashboard'));
});

it('si ya está logueado como estudiante y entra a /login, redirige a /dashboard', function () {
    $u = userWithRole(1);
    $this->actingAs($u)->get(route('login'))
        ->assertRedirect(route('dashboard'));
});

it('si ya está logueado como admin y entra a /login, redirige a /admin', function () {
    $u = userWithRole(3);
    $this->actingAs($u)->get(route('login'))
        ->assertRedirect(route('admin.dashboard'));
});

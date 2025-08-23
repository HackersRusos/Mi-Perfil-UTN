<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedRoles();

    Route::middleware(['web'])->group(function () {
        Route::get('/__t/admin', fn () => 'ADMIN_OK')
            ->middleware(['auth','role:admin']);

        Route::get('/__t/profesor', fn () => 'PROF_OK')
            ->middleware(['auth','role:profesor']);

        Route::get('/__t/estudiante', fn () => 'ESTU_OK')
            ->middleware(['auth','role:estudiante']);

        Route::get('/__t/panel', fn () => 'PANEL_OK')
            ->middleware(['auth','role:admin,2']);
    });
});

it('admin accede a /__t/admin', function () {
    $admin = userWithRole(3);
    $this->actingAs($admin)->get('/__t/admin')
        ->assertOk()->assertSee('ADMIN_OK');
});

it('profesor no accede a /__t/admin', function () {
    $prof = userWithRole(2);
    $this->actingAs($prof)->get('/__t/admin')->assertForbidden();
});

it('profesor accede a /__t/profesor', function () {
    $prof = userWithRole(2);
    $this->actingAs($prof)->get('/__t/profesor')
        ->assertOk()->assertSee('PROF_OK');
});

it('estudiante no accede a /__t/profesor', function () {
    $estu = userWithRole(1);
    $this->actingAs($estu)->get('/__t/profesor')->assertForbidden();
});

it('estudiante accede a /__t/estudiante', function () {
    $estu = userWithRole(1);
    $this->actingAs($estu)->get('/__t/estudiante')
        ->assertOk()->assertSee('ESTU_OK');
});

it('ruta /__t/panel permite admin o profesor', function () {
    $admin = userWithRole(3);
    $prof  = userWithRole(2);
    $estu  = userWithRole(1);

    $this->actingAs($admin)->get('/__t/panel')->assertOk()->assertSee('PANEL_OK');
    $this->actingAs($prof)->get('/__t/panel')->assertOk()->assertSee('PANEL_OK');
    $this->actingAs($estu)->get('/__t/panel')->assertForbidden();
});

it('no autenticado redirige a login', function () {
    $this->get('/__t/admin')->assertRedirect(route('login'));
});

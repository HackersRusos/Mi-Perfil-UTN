<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Roles estables (id y nombre)
    $this->estu = Role::firstOrCreate(['id' => 1], ['name' => 'estudiante']);
    $this->prof = Role::firstOrCreate(['id' => 2], ['name' => 'profesor']);
    $this->admin = Role::firstOrCreate(['id' => 3], ['name' => 'admin']);

    // Rutas efímeras de prueba con los mismos middlewares que en web.php
    Route::middleware(['web'])->group(function () {
        Route::get('/__t/admin', fn () => 'ADMIN_OK')
            ->middleware(['auth','verified','role:admin']);

        Route::get('/__t/profesor', fn () => 'PROF_OK')
            ->middleware(['auth','verified','role:profesor']);

        Route::get('/__t/estudiante', fn () => 'ESTU_OK')
            ->middleware(['auth','verified','role:estudiante']);

        // Mixto: nombre + id (2 = profesor)
        Route::get('/__t/panel', fn () => 'PANEL_OK')
            ->middleware(['auth','verified','role:admin,2']);
    });
});

function vUser($roleId) {
    return User::factory()->create([
        'role_id' => $roleId,
        'email_verified_at' => now(), // pasa 'verified'
    ]);
}

it('admin accede a /__t/admin', function () {
    $admin = vUser(3);
    $this->actingAs($admin)->get('/__t/admin')
        ->assertOk()->assertSee('ADMIN_OK');
});

it('profesor no accede a /__t/admin', function () {
    $prof = vUser(2);
    $this->actingAs($prof)->get('/__t/admin')
        ->assertForbidden();
});

it('profesor accede a /__t/profesor', function () {
    $prof = vUser(2);
    $this->actingAs($prof)->get('/__t/profesor')
        ->assertOk()->assertSee('PROF_OK');
});

it('estudiante no accede a /__t/profesor', function () {
    $estu = vUser(1);
    $this->actingAs($estu)->get('/__t/profesor')
        ->assertForbidden();
});

it('estudiante accede a /__t/estudiante', function () {
    $estu = vUser(1);
    $this->actingAs($estu)->get('/__t/estudiante')
        ->assertOk()->assertSee('ESTU_OK');
});

it('ruta /__t/panel permite admin o profesor (nombre+id)', function () {
    $admin = vUser(3);
    $prof  = vUser(2);
    $estu  = vUser(1);

    $this->actingAs($admin)->get('/__t/panel')->assertOk()->assertSee('PANEL_OK');
    $this->actingAs($prof)->get('/__t/panel')->assertOk()->assertSee('PANEL_OK');
    $this->actingAs($estu)->get('/__t/panel')->assertForbidden();
});

it('no autenticado redirige a login', function () {
    $this->get('/__t/admin')->assertRedirect(route('login'));
});

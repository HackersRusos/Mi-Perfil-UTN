<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Profile;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedRoles();
});

it('el dueño (estudiante) ve el botón "Editar"', function () {
    $estu = userWithRole(1);
    $profile = $estu->profile ?? \App\Models\Profile::factory()->create(['user_id' => $estu->id]);

    $this->actingAs($estu)
        ->get(route('estudiantes.show', $profile))
        ->assertOk()
        ->assertSee('Editar');
});

it('el profesor NO ve "Editar" en el perfil del estudiante', function () {
    $estu = userWithRole(1);
    $prof = userWithRole(2);
    $profile = $estu->profile ?? \App\Models\Profile::factory()->create(['user_id' => $estu->id]);

    $this->actingAs($prof)
        ->get(route('estudiantes.show', $profile))
        ->assertOk()
        ->assertDontSee('Editar');
});

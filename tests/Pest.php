<?php
use App\Models\User;
use App\Models\Role;
/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

// Helper común para crear usuario con rol y verificado
function userWithRole(int $roleId): User {
    return User::factory()->create([
        'role_id' => $roleId,
        'email_verified_at' => now(),
    ]);
}

// Helper para asegurar los 3 roles base por ID fijo
function seedRoles(): void {
    Role::firstOrCreate(['id' => 1], ['name' => 'estudiante']);
    Role::firstOrCreate(['id' => 2], ['name' => 'profesor']);
    Role::firstOrCreate(['id' => 3], ['name' => 'admin']);
}

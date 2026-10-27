<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_ulang_tidak_menimpa_data_dari_admin(): void
    {
        $this->seed(DatabaseSeeder::class);

        $project = Project::first();
        $project->update(['name' => 'Judul diedit admin']);
        Project::create(['name' => 'Proyek baru', 'slug' => 'proyek-baru'] + collect($project->getAttributes())->except(['id', 'name', 'slug', 'created_at', 'updated_at'])->all());
        User::first()->update(['password' => Hash::make('sandi-baru')]);

        $this->seed(DatabaseSeeder::class);

        $this->assertSame('Judul diedit admin', $project->fresh()->name);
        $this->assertDatabaseHas('projects', ['slug' => 'proyek-baru']);
        $this->assertTrue(Hash::check('sandi-baru', User::first()->password));
    }
}

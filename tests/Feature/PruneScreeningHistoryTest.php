<?php

namespace Tests\Feature;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PruneScreeningHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_screenings_older_than_retention_period(): void
    {
        config(['screening.retention_months' => 6]);

        $student = User::factory()->create(['role' => 'mahasiswa']);

        $old = Screening::factory()->for($student, 'user')->create();
        $old->forceFill(['created_at' => now()->subMonths(7)])->save();

        $recent = Screening::factory()->for($student, 'user')->create();
        $recent->forceFill(['created_at' => now()->subMonths(2)])->save();

        $this->artisan('screenings:prune')->assertExitCode(0);

        $this->assertDatabaseMissing('screenings', ['id' => $old->id]);
        $this->assertDatabaseHas('screenings', ['id' => $recent->id]);
    }

    public function test_dry_run_does_not_delete_anything(): void
    {
        $student = User::factory()->create(['role' => 'mahasiswa']);

        $old = Screening::factory()->for($student, 'user')->create();
        $old->forceFill(['created_at' => now()->subMonths(9)])->save();

        $this->artisan('screenings:prune', ['--dry-run' => true])->assertExitCode(0);

        $this->assertDatabaseHas('screenings', ['id' => $old->id]);
    }

    public function test_months_option_overrides_config(): void
    {
        $student = User::factory()->create(['role' => 'mahasiswa']);

        $threeMonthsOld = Screening::factory()->for($student, 'user')->create();
        $threeMonthsOld->forceFill(['created_at' => now()->subMonths(3)])->save();

        // Retensi diperketat jadi 2 bulan lewat opsi --months.
        $this->artisan('screenings:prune', ['--months' => 2])->assertExitCode(0);

        $this->assertDatabaseMissing('screenings', ['id' => $threeMonthsOld->id]);
    }
}

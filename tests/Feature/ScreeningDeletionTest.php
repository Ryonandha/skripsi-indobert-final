<?php

namespace Tests\Feature;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScreeningDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_delete_their_own_screening(): void
    {
        $student = User::factory()->create(['role' => 'mahasiswa']);
        $screening = Screening::factory()->for($student, 'user')->create();

        $response = $this->actingAs($student)
            ->delete(route('mahasiswa.screening.destroy', $screening));

        $response->assertRedirect(route('mahasiswa.history'));
        $this->assertDatabaseMissing('screenings', ['id' => $screening->id]);
    }

    public function test_mahasiswa_cannot_delete_another_students_screening(): void
    {
        $owner = User::factory()->create(['role' => 'mahasiswa']);
        $intruder = User::factory()->create(['role' => 'mahasiswa']);
        $screening = Screening::factory()->for($owner, 'user')->create();

        $response = $this->actingAs($intruder)
            ->delete(route('mahasiswa.screening.destroy', $screening));

        $response->assertForbidden();
        $this->assertDatabaseHas('screenings', ['id' => $screening->id]);
    }

    public function test_guest_cannot_delete_screening(): void
    {
        $owner = User::factory()->create(['role' => 'mahasiswa']);
        $screening = Screening::factory()->for($owner, 'user')->create();

        $response = $this->delete(route('mahasiswa.screening.destroy', $screening));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('screenings', ['id' => $screening->id]);
    }
}

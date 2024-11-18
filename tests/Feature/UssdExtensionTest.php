<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\UssdExtension;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UssdExtensionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_ussd_code_can_be_created()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->post(route('admin.ussd-extensions.store'), [
                'code' => '*928*65#',
            ]);

        $this->assertCount(1, UssdExtension::all());
        $this->assertEquals('*928*65#', UssdExtension::first()->code);
    }

    /**
     * @test
     */
    public function a_ussd_code_can_be_deleted()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->post(route('admin.ussd-extensions.store'), [
                'code' => '*928*65#',
            ]);

        $id = UssdExtension::where('code', '*928*65#')->first()->id;

        $this->actingAs($user)
            ->delete(route('admin.ussd-extensions.destroy', ['ussd_extension' => $id]));

        $this->assertCount(0, UssdExtension::all());
    }

    /**
     * @test
     */
    public function a_ussd_code_can_be_updated()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->post(route('admin.ussd-extensions.store'), [
                'code' => '*928*65#',
            ]);

        $id = UssdExtension::where('code', '*928*65#')->first()->id;

        $this->actingAs($user)
        ->put(route('admin.ussd-extensions.update', ['ussd_extension' => $id]), [
            'code' => '*928*72#',
        ]);

        $this->assertEquals('*928*72#', UssdExtension::first()->code);
    }

    /**
     * @test
     */
    public function a_ussd_code_is_available()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->post(route('admin.ussd-extensions.store'), [
                'code' => '*928*65#',
            ]);

        $response = $this->actingAs($user)
                    ->post(route('admin.ussd.availability.check'), [
                        'start_time' => now()->subDays(5)->toDateTimeString(),
                        'end_time' => now()->toDateTimeString(),
                        'code' => '*928*65#',
                    ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function a_ussd_code_is_not_available()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.ussd-extensions.store'), [
                'code' => '*928*65#',
            ]);

        $ussdExtension = UssdExtension::first();

        $client = User::factory()->create(['role' => 'client']);
        $event = Event::factory()->create([
            'user_id' => $client->id,
            'ussd_extension_id' => $ussdExtension->id,
        ]);

        $response = $this->actingAs($admin)
                    ->post(route('admin.ussd.availability.check'), [
                        'start_time' => $event->start_time,
                        'end_time' => $event->end_time,
                        'code' => '*928*65#',
                    ]);

        $response->assertSessionHasErrors();
    }
}

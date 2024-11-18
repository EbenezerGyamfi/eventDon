<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactGroupTest extends TestCase
{
    use WithFaker;

    /**
     * @return void
     */
    public function test_get_all_contact_groups()
    {
        $this->markTestSkipped();
        $user = User::factory()
            ->state([
                'role' => 'client',
                'phone_number_verified' => '1',
            ])
            ->has(ContactGroup::factory()->count(2))
            ->create();

        $response = $this->actingAs($user)
            ->get(route('contacts.groups.index'));

        $response->assertSessionDoesntHaveErrors();

        $this->assertCount($user->contactGroups->count(), ContactGroup::all());
    }

    /**
     * @return void
     */
    public function test_create_a_contact_group()
    {
        $user = User::factory()
            ->state([
                'role' => 'client',
                'phone_number_verified' => '1',
            ])
            ->create();

        $body = [
            'name' => 'Test Group',
            'description' => 'Test Group Description',
        ];

        $response = $this->actingAs($user)
            ->post(route('contacts.groups.store'), $body);

        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('contact_groups', [
            'user_id' => $user->id,
            'name' => 'Test Group',
            'description' => 'Test Group Description',
        ]);
    }

    public function test_edit_a_contact_group()
    {
        $group = ContactGroup::factory()
            ->for($user = User::factory()
                ->state([
                    'role' => 'client',
                    'phone_number_verified' => '1',
                ])
                ->create())
            ->create();

        $oldName = $group->name;

        $this->actingAs($user)
            ->put(route('contacts.groups.update', $group->id), [
                'name' => $this->faker->name,
                'description' => $group->description,
            ]);

        $this->assertNotEquals($oldName, $group->fresh()->name);
    }

    /**
     * @return void
     */
    public function test_a_contact_can_be_edited()
    {
        $contact = Contact::factory()
            ->for(
                ContactGroup::factory()
                    ->for($user = User::factory()
                        ->state([
                            'role' => 'client',
                            'phone_number_verified' => '1',
                        ])
                        ->create())
            )->create();

        $oldName = $contact->name;

        $response = $this->actingAs($user)
            ->put(
                route('edit.contact', $contact->id),
                array_merge([
                    'name' => $this->faker->name(),
                ], $contact->only(['email', 'phone']))
            );

        $response->assertSessionDoesntHaveErrors();

        $this->assertNotEquals($oldName, $contact->fresh()->name);
    }

    /**
     * @return void
     */
    public function test_a_contact_can_be_deleted()
    {
        $group = ContactGroup::factory()
            ->for($user = User::factory()
                ->state([
                    'role' => 'client',
                    'phone_number_verified' => '1',
                ])
                ->create())
            ->has(Contact::factory())
            ->create();

        $contact = $group->contacts()->first();

        $this->actingAs($user)
            ->get(
                route('delete.contact', $contact->id),
            );

        $this->assertCount(0, $group->fresh()->contacts);
    }

    /**
     * @return void
     */
    public function test_show_all_contacts_in_a_contact_group()
    {
        $this->markTestSkipped();

        $user = User::factory()
            ->state([
                'role' => 'client',
                'phone_number_verified' => '1',
            ])
            ->create();

        $contactGroup = ContactGroup::factory()
            ->state([
                'user_id' => $user->id,
            ])
            ->has(Contact::factory()->count(4))
            ->create();

        $response = $this->actingAs($user)
            ->get(route('contacts.groups.show', $contactGroup->id));

        $response->assertSessionDoesntHaveErrors();

        $this->assertCount($user->contactGroups->count(), ContactGroup::all());
    }
}

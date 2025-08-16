<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_user_can_view_profile_edit_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user', $user);
    }

    public function test_user_can_update_profile_information()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $response = $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com'
            ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success', 'Profile updated successfully!');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com'
        ]);
    }

    public function test_user_can_upload_profile_picture()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'profile_picture' => $file
            ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success', 'Profile updated successfully!');

        $user->refresh();
        $this->assertNotNull($user->profile_picture);
        Storage::disk('public')->assertExists($user->profile_picture);
    }

    public function test_user_can_remove_profile_picture()
    {
        $user = User::factory()->create([
            'profile_picture' => 'uploads/profile_pictures/test.jpg'
        ]);

        Storage::disk('public')->put('uploads/profile_pictures/test.jpg', 'fake content');

        $response = $this->actingAs($user)
            ->post(route('profile.removePicture'));

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success', 'Profile picture removed successfully!');

        $user->refresh();
        $this->assertNull($user->profile_picture);
    }

    public function test_user_can_change_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword')
        ]);

        $response = $this->actingAs($user)
            ->post(route('profile.updatePassword'), [
                'current_password' => 'oldpassword',
                'new_password' => 'newpassword123',
                'new_password_confirmation' => 'newpassword123'
            ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success', 'Password updated successfully!');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_user_cannot_change_password_with_incorrect_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword')
        ]);

        $response = $this->actingAs($user)
            ->post(route('profile.updatePassword'), [
                'current_password' => 'wrongpassword',
                'new_password' => 'newpassword123',
                'new_password_confirmation' => 'newpassword123'
            ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['current_password']);
    }

    public function test_user_can_delete_account()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        $response = $this->actingAs($user)
            ->post(route('profile.delete'), [
                'password' => 'password123'
            ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Your account has been permanently deleted.');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_can_export_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('profile.exportData'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertHeader('Content-Disposition', 'attachment; filename="user_data_' . $user->id . '_' . date('Y-m-d') . '.json"');

        $data = json_decode($response->getContent(), true);
        $this->assertEquals($user->name, $data['Personal Information']['Name']);
        $this->assertEquals($user->email, $data['Personal Information']['Email']);
    }

    public function test_profile_update_validation()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create(['email' => 'other@example.com']);

        $response = $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => '',
                'email' => 'other@example.com' // Duplicate email
            ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    public function test_password_update_validation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('profile.updatePassword'), [
                'current_password' => '',
                'new_password' => 'short',
                'new_password_confirmation' => 'different'
            ]);

        $response->assertSessionHasErrors(['current_password', 'new_password']);
    }
}

# Profile Management System

This document describes the complete profile management functionality implemented in the Laravel application.

## Features

### 1. Profile Information Management

-   **View Profile**: Users can view their current profile information
-   **Update Profile**: Users can update their name, email, and profile picture
-   **Profile Picture**: Support for uploading, updating, and removing profile pictures
-   **Validation**: Comprehensive validation for all profile fields

### 2. Password Management

-   **Change Password**: Secure password change functionality
-   **Password Strength**: Real-time password strength indicator
-   **Current Password Verification**: Users must provide their current password
-   **Password Confirmation**: New password must be confirmed

### 3. Account Management

-   **Delete Account**: Permanent account deletion with password confirmation
-   **Data Export**: Users can export their profile data as JSON
-   **Security**: All actions are logged for security purposes

### 4. Security Features

-   **Authentication Required**: All profile routes require user authentication
-   **CSRF Protection**: Built-in CSRF protection for all forms
-   **Session Management**: Session timeout warnings and management
-   **Activity Logging**: All profile changes are logged with IP and user agent
-   **File Validation**: Profile picture uploads are validated for type and size

## Routes

```php
// Profile Routes (Protected by auth middleware)
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('update');
    Route::post('/remove-picture', [ProfileController::class, 'removeProfilePicture'])->name('removePicture');
    Route::get('/export-data', [ProfileController::class, 'exportData'])->name('exportData');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/delete', [ProfileController::class, 'destroy'])->name('delete');
});
```

## Controllers

### ProfileController

Main controller handling all profile-related operations:

-   `edit()` - Display profile edit form
-   `update()` - Update profile information
-   `removeProfilePicture()` - Remove profile picture
-   `exportData()` - Export user data as JSON
-   `updatePassword()` - Update user password
-   `destroy()` - Delete user account

## Request Classes

### ProfileUpdateRequest

Validates profile update requests:

-   Name: required, string, max 255 characters
-   Email: required, valid email, unique (excluding current user)
-   Profile Picture: optional, image file, max 2MB

### PasswordUpdateRequest

Validates password change requests:

-   Current Password: required
-   New Password: required, min 8 characters, confirmed
-   New Password Confirmation: required

### AccountDeletionRequest

Validates account deletion requests:

-   Password: required, must match current password

## Models

### User Model

The User model includes:

-   `profile_picture` field for storing profile picture paths
-   Proper fillable attributes for mass assignment
-   Relationships and accessors as needed

## Views

### profile/edit.blade.php

Main profile edit view featuring:

-   Modern, responsive design with Tailwind CSS
-   Three main sections: Profile Information, Password Change, Account Deletion
-   Profile picture upload with preview
-   Password strength indicator
-   Form validation and error handling
-   Success/error message display

## File Storage

### Profile Pictures

-   Stored in `storage/app/public/uploads/profile_pictures/`
-   File naming: `profile_{timestamp}_{user_id}.{extension}`
-   Supported formats: JPEG, PNG, GIF, WebP
-   Maximum file size: 2MB
-   Automatic cleanup of old pictures when updating

### Storage Configuration

-   Uses Laravel's public disk for file storage
-   Symbolic link created for public access
-   Files accessible via `/storage/uploads/profile_pictures/`

## Security Features

### Authentication & Authorization

-   All profile routes protected by `auth` middleware
-   Users can only access their own profile
-   Session management with timeout warnings

### Input Validation

-   Comprehensive server-side validation
-   Client-side validation for better UX
-   File type and size validation
-   Password strength requirements

### Activity Logging

-   All profile changes logged with:
    -   User ID and email
    -   Type of change
    -   IP address
    -   User agent
    -   Timestamp

### CSRF Protection

-   All forms include CSRF tokens
-   Automatic CSRF validation
-   Protection against cross-site request forgery

## Testing

### Test Coverage

Comprehensive test suite covering:

-   Profile viewing and editing
-   Profile picture upload and removal
-   Password changes
-   Account deletion
-   Data export
-   Validation errors
-   Security measures

### Running Tests

```bash
php artisan test tests/Feature/ProfileTest.php
```

## Usage Examples

### Updating Profile

```php
// In a controller or service
$user->update([
    'name' => 'New Name',
    'email' => 'newemail@example.com'
]);
```

### Uploading Profile Picture

```php
if ($request->hasFile('profile_picture')) {
    $path = $request->file('profile_picture')
        ->storeAs('uploads/profile_pictures', $filename, 'public');
    $user->update(['profile_picture' => $path]);
}
```

### Changing Password

```php
if (Hash::check($request->current_password, $user->password)) {
    $user->update([
        'password' => Hash::make($request->new_password)
    ]);
}
```

## Error Handling

### Validation Errors

-   Displayed inline with form fields
-   Clear error messages for each field
-   Automatic form validation on submission

### File Upload Errors

-   File size validation
-   File type validation
-   Storage error handling
-   User-friendly error messages

### Security Errors

-   Authentication failures
-   Authorization errors
-   CSRF token mismatches
-   Session timeout handling

## Performance Considerations

### File Optimization

-   Profile pictures are stored efficiently
-   Automatic cleanup of old files
-   Optimized file naming for quick access

### Database Queries

-   Minimal database queries
-   Efficient user data retrieval
-   Proper indexing on user fields

### Caching

-   Session-based caching for user data
-   Efficient file storage access
-   Optimized view rendering

## Future Enhancements

### Potential Features

-   Profile picture cropping and editing
-   Two-factor authentication
-   Profile privacy settings
-   Social media integration
-   Profile completion percentage
-   Activity history
-   Backup and restore functionality

### Technical Improvements

-   Image compression and optimization
-   CDN integration for file storage
-   Real-time notifications
-   API endpoints for mobile apps
-   Advanced security features
-   Performance monitoring

## Troubleshooting

### Common Issues

1. **Profile picture not displaying**: Check storage link and file permissions
2. **Upload errors**: Verify file size and type restrictions
3. **Validation errors**: Check form field names and validation rules
4. **Permission errors**: Ensure proper middleware configuration

### Debug Mode

Enable debug mode in `.env` for detailed error information:

```env
APP_DEBUG=true
```

## Support

For technical support or questions about the profile functionality:

-   Check the Laravel documentation
-   Review the test files for usage examples
-   Check the application logs for error details
-   Verify configuration settings in `.env` and config files

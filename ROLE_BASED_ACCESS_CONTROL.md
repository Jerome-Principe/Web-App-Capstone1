# Role-Based Access Control (RBAC) Implementation

## Overview

This document outlines the role-based access control system implemented in the FitDroid Gym Management System. The system restricts access to certain features based on user roles.

## User Roles

The system supports three user roles:

1. **Admin** - Full access to all features
2. **Cashier** - Access to most features except some restricted areas
3. **Instructor** - Limited access to specific fitness-related features

## Instructor Access Permissions

Instructors have access to the following sections only:

### Dashboard

-   View Dashboard

### Resources

-   Exercise Default
-   Exercise Custom
-   Meal Plan Default
-   Meal Plan Custom
-   Workout Default
-   Workout Custom

### Appointment

-   View Appointment List
-   Pending Appointment
-   Cancelled Appointment

### Goal

-   View Goal

### Competition

-   View Competition

### Our Team

-   View Instructor

### Feedback

-   View Feedback
-   View Mobile Feedback

### Membership

-   View Membership
-   Pending Membership
-   Membership Request
-   Emergency / Medical
-   Payment
-   Renewal

## Restricted Sections for Instructors

Instructors **CANNOT** access the following sections:

-   **Admin** - User management
-   **Announcement** - Create and manage announcements
-   **Attendance** - RFID and attendance tracking
-   **Expenses** - Financial expense tracking
-   **Inventory** - Sales, stock items, equipment, and machines
-   **Walkin Client** - Walk-in client management

## Implementation Details

### 1. Sidebar Navigation (`resources/views/components/admin-sidebar.blade.php`)

The sidebar uses conditional rendering to hide menu items based on user role:

```php
@if(auth()->user()?->role !== 'Instructor')
    <!-- Menu item only visible to Admin and Cashier -->
@endif
```

### 2. Route Protection (`routes/web.php`)

Routes are protected using the `role` middleware:

```php
// Example: Only Admin and Cashier can access
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:Admin,Cashier'])
    ->name('dashboard');
```

### 3. CheckRole Middleware (`app/Http/Middleware/CheckRole.php`)

A custom middleware that:

-   Checks if the user is authenticated
-   Verifies if the user's role is in the allowed roles list
-   Redirects unauthorized users to the dashboard with an error message

### 4. Middleware Registration (`app/Http/Kernel.php`)

The middleware is registered as `'role'` in the `$middlewareAliases` array:

```php
'role' => \App\Http\Middleware\CheckRole::class,
```

## Usage Examples

### Protecting a Single Route

```php
Route::get('/expenses', [ExpenseController::class, 'index'])
    ->middleware(['auth', 'role:Admin,Cashier']);
```

### Protecting a Route Group

```php
Route::prefix('walkin')->middleware(['auth', 'role:Admin,Cashier'])->group(function () {
    Route::get('/clients', [WalkinController::class, 'index']);
    Route::post('/store', [WalkinController::class, 'store']);
});
```

## Security Features

1. **Frontend Restriction** - Menu items are hidden from unauthorized users
2. **Backend Protection** - Routes are protected with middleware
3. **Double Layer Security** - Even if someone tries to access a URL directly, they will be blocked
4. **User-Friendly Redirects** - Unauthorized access attempts redirect to the dashboard with an error message

## Testing

To test the role-based access control:

1. Log in as an **Instructor**
2. Verify that only allowed menu items are visible in the sidebar
3. Try to access a restricted URL directly (e.g., `/dashboard`, `/expenses`)
4. Confirm that you are redirected with an error message

## Future Enhancements

Possible improvements to the RBAC system:

-   Add more granular permissions (e.g., view-only vs. edit permissions)
-   Implement a permission management interface for admins
-   Add role-based data filtering (e.g., instructors only see their own appointments)
-   Create audit logs for tracking access attempts

## Troubleshooting

### Issue: Menu items still visible to Instructor

**Solution**: Clear the application cache:

```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Issue: Unauthorized access errors for valid users

**Solution**: Check the user's role in the database:

```sql
SELECT id, name, email, role FROM users WHERE email = 'user@example.com';
```

Ensure the role is exactly one of: `Admin`, `Cashier`, or `Instructor`

### Issue: Middleware not working

**Solution**:

1. Verify the middleware is registered in `app/Http/Kernel.php`
2. Check that routes have the correct middleware applied
3. Clear the route cache: `php artisan route:clear`

## Contact

For questions or issues related to role-based access control, please contact the development team.
